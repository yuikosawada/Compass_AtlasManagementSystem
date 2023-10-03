<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use App\Http\Requests\BulletinBoard\CommentFormRequest;
use App\Http\Requests\BulletinBoard\PostCreateFormRequest;
use App\Http\Requests\BulletinBoard\MainCategoryRequest;
use App\Http\Requests\BulletinBoard\SubCategoryRequest;
use App\Models\Users\Subjects;
use Auth;

class PostsController extends Controller
{
    public function show(Request $request)
    {
        $posts = Post::with('user', 'postComments')->get();
        $categories = MainCategory::get();
        $like = new Like;
        $post_comment = new Post;
        // $post_sub_category = PostSubCategory::get('id');
        // $sub_category =  new SubCategory;

        $subjects = Subjects::with('users')->get();

        if (!empty($request->keyword)) {
            $posts = Post::with('user', 'postComments')
                ->where('post_title', 'like', '%' . $request->keyword . '%')
                ->orWhere('post', 'like', '%' . $request->keyword . '%')->get();
        } else if ($request->category_word) {
            $sub_category = $request->category_word;
            $posts = Post::with('user', 'postComments')->get();
        } else if ($request->like_posts) {
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
                ->whereIn('id', $likes)->get();
        } else if ($request->my_posts) {
            $posts = Post::with('user', 'postComments')
                ->where('user_id', Auth::id())->get();
        } else if ($request->sub_categories) {
            // サブカテゴリで絞り込む処理
            $posts = Post::whereHas('subCategories', function ($query) use ($request) {
                $query->where('sub_category', $request->sub_categories);
            })->get();
        }
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment', 'subjects'));
    }

    public function postDetail($post_id)
    {
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    public function postInput()
    {
        $main_categories = MainCategory::get();
        $sub_categories = SubCategory::get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories', 'sub_categories'));
    }

    public function postCreate(PostCreateFormRequest $request)
    {
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);
        // サブカテゴリと記事を紐づけ（中間テーブルに記録）
        $sub_category_id = $request->post_category_id;
        $post->subCategories()->attach($sub_category_id);

        return redirect()->route('post.show');
    }

    public function postEdit(Request $request)
    {
        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function postDelete($id)
    {
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }
    public function mainCategoryCreate(MainCategoryRequest $request)
    {
        
        try {
            MainCategory::create(['main_category' => $request->main_category_name]);
            return redirect()->route('post.input');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }
    //サブカテゴリ作成
    public function subCategoryCreate(SubCategoryRequest $request)
    {
        // SubCategoryRequestでバリデーションに引っかかったものの表示までしてくれているので、RegisterControllerには登録処理のみでOK

        // $main_category = $request->main_category_id;
        SubCategory::create(
            [
                'sub_category' => $request->sub_category_name,
                'main_category_id' =>$request->main_category_id
            ]

        );
        return redirect()->route('post.input');
    }
    // ここまで

    public function commentCreate(CommentFormRequest $request)
    {
        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);

        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }



    public function myBulletinBoard()
    {
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard()
    {
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

   
    public function postLike(Request $request)
    {
        $user_id = Auth::id();
        $post_id = $request->post_id;


        // $like = new Like;
        // すでにいいねが存在するか確認
        $existingLike = Like::where('like_user_id', $user_id)
            ->where('like_post_id', $post_id)
            ->first();

        if (!$existingLike) {
            // まだいいねしていない場合、新しいいいねを作成
            $like = new Like;
            $like->like_user_id = $user_id;
            $like->like_post_id = $post_id;
            $like->save();
        } else {
            // すでにいいねしている場合、いいねを取り消す
            $existingLike->delete();
        }

        return response()->json();
    }

    public function postUnLike(Request $request)
    {
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
            ->where('like_post_id', $post_id)
            ->delete();

        return response()->json();
    }
}
