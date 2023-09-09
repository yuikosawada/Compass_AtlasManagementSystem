<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>AtlasBulletinBoard</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&family=Oswald:wght@200&display=swap" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <!-- font awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

</head>

<body class="all_content">
  <div class="d-flex">
    <div class="sidebar">
      @section('sidebar')
      <p>
        <img src="image/home.png" class="sidebar_icon" alt="top"><a href="{{ route('top.show') }}">マイページ</a></img>
      </p>
      <p>
        <i class="fa-solid fa-arrow-right-from-bracket"><a href="/logout">ログアウト</a></i>
      </p>
      <p>
        <img src="image/home.png" class="sidebar_icon" alt="school"><a href="{{ route('calendar.general.show',['user_id' => Auth::id()]) }}">スクール予約</a></img>
      </p>
      <!-- 管理者のみ表示 -->
      @if(auth()->user()->role >= 1 && auth()->user()->role <= 3)
     <p>
        <img src="image/home.png" class="sidebar_icon" alt="school_comfirm"><a href="{{ route('calendar.admin.show',['user_id' => Auth::id()]) }}">スクール予約確認</a></img>
      </p>
      <!-- 管理者のみ表示 -->
      <p>
        <img src="image/home.png" class="sidebar_icon" alt="school_register"><a href="{{ route('calendar.admin.setting',['user_id' => Auth::id()]) }}">スクール枠登録</a></img>
      </p>
      @endif
      <p>
        <img src="image/home.png" class="sidebar_icon" alt="posts"><a href="{{ route('post.show') }}">掲示板</a></img>
      </p>
      <p>
        <img src="image/home.png" class="sidebar_icon" alt="search"><a href="{{ route('user.show') }}">ユーザー検索</a></img>
      </p>
      @show
    </div>
    <div class="main-container">
      @yield('content')
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="{{ asset('js/register.js') }}" rel="stylesheet"></script>
  <script src="{{ asset('js/bulletin.js') }}" rel="stylesheet"></script>
  <script src="{{ asset('js/user_search.js') }}" rel="stylesheet"></script>
  <script src="{{ asset('js/calendar.js') }}" rel="stylesheet"></script>
</body>

</html>