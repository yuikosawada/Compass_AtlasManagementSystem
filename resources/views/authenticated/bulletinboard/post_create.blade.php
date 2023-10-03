@extends('layouts.sidebar')

@section('content')
<div class="post_create_container d-flex">
  <div class="post_create_area border w-50 m-5 p-5">
    <div class="">
      <p class="mb-0">カテゴリー</p>
      <select class="w-100" form="postCreate" name="post_category_id">

        <!-- カテゴリー表示 -->
        @foreach($main_categories as $main_category)
        <optgroup label="{{ $main_category->main_category }}"></optgroup>
        @foreach($main_category->subCategories as $sub_category)
        <option value="{{ $sub_category->id}}">{{ $sub_category->sub_category}}</option>
        @endforeach
        @endforeach

      </select>
    </div>
    <div class="mt-3">
      @if($errors->first('post_title'))
      <span class="error_message">{{ $errors->first('post_title') }}</span>
      @endif
      <p class="mb-0">タイトル</p>
      <input type="text" class="w-100" form="postCreate" name="post_title" value="{{ old('post_title') }}">
    </div>
    <div class="mt-3">
      @if($errors->first('post_body'))
      <span class="error_message">{{ $errors->first('post_body') }}</span>
      @endif
      <p class="mb-0">投稿内容</p>
      <textarea class="w-100" form="postCreate" name="post_body">{{ old('post_body') }}</textarea>
    </div>
    <div class="mt-3 text-right">
      <input type="submit" class="btn btn-primary" value="投稿" form="postCreate">
    </div>
    <form action="{{ route('post.create') }}" method="post" id="postCreate">{{ csrf_field() }}</form>
  </div>
  @can('admin')
  <div class="w-25 ml-auto mr-auto">
    <div class="category_area mt-5 p-5">
      <div class="">
        <!-- メインカテゴリー追加ー -->
        @if ($errors->has('main_category_name'))
        <p class="error">{{ $errors->first('main_category_name') }} </p> @endif
        <p class="m-0">メインカテゴリー</p>
        <input type="text" class="w-100" name="main_category_name" form="MainCategoryRequest">
        <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="MainCategoryRequest">
      </div>
      <!-- サブカテゴリー追加 -->
      <div class="">
        @if ($errors->has('sub_category_name'))
        <p class="error">{{ $errors->first('sub_category_name') }} </p> @endif
        @if ($errors->has('main_category_id'))
        <p class="error">{{ $errors->first('main_category_id') }} </p> @endif
        <p class="m-0">サブカテゴリー</p>
        <select class="" name="main_category_id" form="SubCategoryRequest">
          <option value="">-----</option>
          @foreach ($main_categories as $main_category)
          <option value="{{ $main_category->id }}">{{ $main_category->main_category }}</option>
          @endforeach
        </select>
        <input type="text" class="w-100" name="sub_category_name" form="SubCategoryRequest">
        <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="SubCategoryRequest">
      </div>
      <!-- ここまで -->
      <form action="{{ route('main.category.create') }}" method="post" id="MainCategoryRequest">{{ csrf_field() }}</form>
      <!-- ここから追加 -->
      <form action="{{ route('sub.category.create') }}" method="post" id="SubCategoryRequest">{{ csrf_field() }}</form>
      <!-- ここまで -->
    </div>
  </div>
  @endcan
</div>
@endsection