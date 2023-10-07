<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;

class PostComment extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'post_id',
        'user_id',
        'comment',
    ];
//   投稿に紐づいているコメントを同時に削除する
    public function deleteCommentByPost($id)
 {
    PostComment::where('post_id', '=', $id)->delete();
    // $this->where('post_id', '=', $id)->delete();
 }

    public function post(){
        return $this->belongsTo('App\Models\Posts\Post');
    }

    public function commentUser($user_id){
        return User::where('id', $user_id)->first();
    }

    
}