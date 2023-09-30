@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto">投稿一覧</p>
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
      <div class="post_bottom_area d-flex">
        <div class="d-flex post_status">
          <div class="mr-5">
            <i class="fa fa-comment" post_id="{{ $post->id }}"></i><span>{{ $post->commentCounts($post->id)}}</span>
          </div>


          <div>
            <p class="m-0">

              @if(Auth::user()->is_Like($post->id))
              <i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $post->likeCounts($post->id)}}</span>
              @else
              <i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $post->likeCounts($post->id)}}</span>


              @endif
            </p>

          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area w-25">
    <div class="m-4">
      <div class="posts_top_btn mb-20"><a href="{{ route('post.create') }}">投稿</a></div>
      <div class="keyword_box mb-20">
        <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" value="検索" form="postSearchRequest">
      </div>
      <div class="mb-20">
        <input type="submit" name="like_posts" class="category_btn_pink category_btn" value="いいねした投稿" form="postSearchRequest">
        <input type="submit" name="my_posts" class="category_btn_yellow category_btn" value="自分の投稿" form="postSearchRequest">
      </div>
      <ul class="main_sub_categories">
        <li>
          <span>教科</span>
          <i class="fa-solid fa-chevron-down" style="color: #404040;"></i>
          <i class="fa-solid fa-chevron-up open" style="color: #404040;"></i>
        </li>
        @foreach($subjects as $subject)
        <input type="submit" name="sub_categories" class="category_btn" value="{{ $subject->subject }}" form="postSearchRequest" subject_id="{{ $subject->id }}">
        </input>
        @endforeach
        @foreach($categories as $category)
        <li class="main_categories" category_id="{{ $category->id }}">
          <span>{{ $category->main_category }}<span>
              <i class="fa-solid fa-chevron-down" style="color: #404040;"></i>
              <i class="fa-solid fa-chevron-up" style="color: #404040;"></i>
        </li>
        @foreach($category->subCategories as $sub_category)
        <input type="submit" name="sub_categories" class="category_btn" value=" {{ $sub_category->sub_category }}" form="postSearchRequest" category_id="{{ $sub_category->id }}">
        </input>
        @endforeach
        @endforeach
      </ul>
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
@endsection