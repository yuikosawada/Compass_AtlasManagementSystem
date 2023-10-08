<?php

namespace App\Calendars\General;

use App\Models\Calendars\ReserveSettings;
use App\Calendars\General\CalendarView;
use Carbon\Carbon;
use Auth;

class CalendarWeekDay
{
  protected $carbon;

  function __construct($date)
  {
    $this->carbon = new Carbon($date);
  }

  function getClassName()
  {
    return "day-" . strtolower($this->carbon->format("D"));
  }

  function pastClassName()
  {
    return;
  }

  /**
   * @return
   */

  function render()
  {
    return '<p class="day">' . $this->carbon->format("j") . '日</p>';
  }

  function selectPart($ymd)
  {
    $one_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();
    $two_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first();
    $three_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first();
    if ($one_part_frame) {
      $one_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first()->limit_users;
    } else {
      $one_part_frame = '0';
    }
    if ($two_part_frame) {
      $two_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first()->limit_users;
    } else {
      $two_part_frame = '0';
    }
    if ($three_part_frame) {
      $three_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first()->limit_users;
    } else {
      $three_part_frame = '0';
    }

    $html = [];
      $html[] = '<select name="getPart[]" class="border-primary" style="width:70px; border-radius:5px;" form="reserveParts">';
    $html[] = '<option value="" selected></option>';
    //  0を"1"に変更
    if ($one_part_frame == "1") {
      $html[] = '<option value="1" disabled>リモ1部(残り0枠)</option>';
    } else {
      $html[] = '<option value="1">リモ1部(残り' . $one_part_frame . '枠)</option>';
    }
    //  0を"2"に変更
    if ($two_part_frame == "2") {
      $html[] = '<option value="2" disabled>リモ2部(残り0枠)</option>';
    } else {
      $html[] = '<option value="2">リモ2部(残り' . $two_part_frame . '枠)</option>';
    }
    //  0を"3"に変更
    if ($three_part_frame == "3") {
      $html[] = '<option value="3" disabled>リモ3部(残り0枠)</option>';
    } else {
      $html[] = '<option value="3">リモ3部(残り' . $three_part_frame . '枠)</option>';
    }
    $html[] = '</「>';
    return implode('', $html);
  }

  function getDate()
  {
    return '<input type="hidden" value="' . $this->carbon->format('Y-m-d') . '" name="getData[]" form="reserveParts">';
  }

  function everyDay()
  {
    return $this->carbon->format('Y-m-d');
  }

  function authReserveDay()
  {
    return Auth::user()->reserveSettings->pluck('setting_reserve')->toArray();
  }

  function authReserveDate($reserveDate)
  {
    return Auth::user()->reserveSettings->where('setting_reserve', $reserveDate);
  }
}
