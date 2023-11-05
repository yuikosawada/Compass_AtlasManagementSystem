@extends('layouts.sidebar')

@section('content')
<!-- 予約キャンセルモーダル -->
<div class="modal js-modal">
  <div class="modal__bg js-modal-close"></div>
  <div class="modal__content">
    <form action="{{ route('deleteParts') }}" method="post">
      <div class="w-100">
        <div class="modal-inner w-50 m-auto">
        <dt>予約日：</dt>  
        <dd class="reserve_date"></dd>
        <input type="hidden" class="reserve_date" name="reserve_date">
        <dt>時間：</dt> 
        <dd class="reserve_part"></dd>
        <input type="hidden" class="reserve_part" name="reservePart">
        <p class="">上記の予約をキャンセルしてもよろしいですか？</p>
        </div>
       
        <div class="w-50 m-auto edit-modal-btn d-flex">
          <a class="js-modal-close btn btn-primary d-inline-block" href="">閉じる</a>
          <input type="hidden" class="edit-modal-hidden" name="id" value="">
          <input type="submit" class="btn btn-danger d-block" id="" value="キャンセル" >
        </div>
      </div>
      {{ csrf_field() }}
    </form>
  </div>
</div>

<!-- ここまで -->
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5 box-shadow" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto" style="border-radius:5px;">

      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="">
        {!! $calendar->render() !!}
      </div>
    </div>
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary mt-30" value="予約する" form="reserveParts">
    </div>
  </div>
</div>
@endsection