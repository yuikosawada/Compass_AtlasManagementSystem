@extends('layouts.sidebar')

@section('content')
<!-- <p>ユーザー検索</p> -->
<div class="search_content w-100 d-flex">
  <div class="reserve_users_area">
    @foreach($users as $user)
    <div class="border one_person box-shadow">
      <div>
        <span>ID : </span><span>{{ $user->id }}</span>
      </div>
      <div><span>名前 : </span>
        <a href="{{ route('user.profile', ['id' => $user->id]) }}">
          <span>{{ $user->over_name }}</span>
          <span>{{ $user->under_name }}</span>
        </a>
      </div>
      <div>
        <span>カナ : </span>
        <span>({{ $user->over_name_kana }}</span>
        <span>{{ $user->under_name_kana }})</span>
      </div>
      <div>
        @if($user->sex == 1)
        <span>性別 : </span><span>男</span>
        @else
        <span>性別 : </span><span>女</span>
        @endif
      </div>
      <div>
        <span>生年月日 : </span><span>{{ $user->birth_day }}</span>
      </div>
      <div>
        @if($user->role == 1)
        <span>権限 : </span><span>教師(国語)</span>
        @elseif($user->role == 2)
        <span>権限 : </span><span>教師(数学)</span>
        @elseif($user->role == 3)
        <span>権限 : </span><span>講師(英語)</span>
        @else
        <span>権限 : </span><span>生徒</span>
        @endif
      </div>
      <div>
        @if($user->role == 4)
        <span>選択科目 :</span>
        @foreach($user->subjects as $user)
        <span>
          {{$user->subject}}
        </span>
        @endforeach
        @endif
      </div>
    </div>
    @endforeach
  </div>
  <div class="search_area w-25">
    <div class="search_area_inner">
      <p class="search_area_label">検索</p>
      <div>
        <input type="text" class="free_word search_gray_box" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
      </div>
      <div class="f-d-column">
        <lavel class="search_area_label">カテゴリ</lavel>
        <select form="userSearchRequest" name="category" class="search_gray_box">
          <option value="name">名前</option>
          <option value="id">社員ID</option>
        </select>
      </div>
      <div class="f-d-column">
        <label class="search_area_label">並び替え</label>
        <select name="updown" form="userSearchRequest" class="search_gray_box">
          <option value="ASC">昇順</option>
          <option value="DESC">降順</option>
        </select>
      </div>
      <div class="">
          <p class="m-0 border_bottom search_conditions search_area_label d-flex space-between "><span>検索条件の追加</span>
          <i class="fa-solid fa-chevron-down down-arrow  down-arrow-none" style="color: #404040;"></i>
          <i class="fa-solid fa-chevron-up up-arrow up-arrow-none" style="color: #404040;"></i>
        </p>
         
        <div class="search_conditions_inner" style="display: none;">
          <div class="f-d-column">
            <label class="search_area_label">性別</label>
            <div>
              <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
              <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
            </div>
          </div>
          <div class="f-d-column">
            <label class="search_area_label">権限</label>
            <select name="role" form="userSearchRequest" class="engineer search_gray_box">
              <option selected disabled>----</option>
              <option value="1">教師(国語)</option>
              <option value="2">教師(数学)</option>
              <option value="3">教師(英語)</option>
              <option value="4" class="">生徒</option>
            </select>
          </div>
          <div class="selected_engineer">
            <label class="search_area_label">選択科目</label>
            <!-- 選択科目追加 -->
            <div class="d-f">
              <p>国語<input type="checkbox" class="mr-20" name="subject" value="1" id="1" form="userSearchRequest"></p>
              <p>数学<input type="checkbox" class="mr-20" name="subject" value="2" id="2" form="userSearchRequest"></p>
              <p>英語<input type="checkbox" class="mr-20" name="subject" value="3" id="3" form="userSearchRequest"></p>
            </div>
          </div>
        </div>
      </div>

      <div>
        <input type="submit" name="search_btn" value="検索" class="search_btn" form="userSearchRequest">
      </div>
      <div class="ta-c">
        <input type="submit" value="リセット" class="reset_btn" form="userSearchRequest">
      </div>
    </div>
    <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
  </div>
</div>
@endsection