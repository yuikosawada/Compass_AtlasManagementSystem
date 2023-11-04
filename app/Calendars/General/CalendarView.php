<?php

namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;
use App\Models\Calendars\ReserveSettings;


class CalendarView
{

  private $carbon;
  function __construct($date)
  {
    $this->carbon = new Carbon($date);
  }

  public function getTitle()
  {
    return $this->carbon->format('Y年n月');
  }

  function render()
  {
    $html = [];
    $html[] = '<div class="text-center">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th>土</th>';
    $html[] = '<th>日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';
    $weeks = $this->getWeeks();
    foreach ($weeks as $week) {
      $html[] = '<tr class="' . $week->getClassName() . '">';

    

      $days = $week->getDays();
      foreach ($days as $day) {
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");

        if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
          // passed-dayを追加し過去の日付をグレーに
          $html[] = '<td class="calendar-td passed-day">';
        } else {
          $html[] = '<td class="calendar-td ' . $day->getClassName() . '">';
        }
        $html[] = $day->render();
       

        // 今日以降で予約している日に予約部を表示する（はじめから記述されていた(頭にelse追加した)）
        // else if (in_array($day->everyDay(), $day->authReserveDay())) {
        if (in_array($day->everyDay(), $day->authReserveDay())) {
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
          if ($reservePart == 1) {
            $reservePart = "リモ1部";
            $reservePartPast = "1部参加";
          } else if ($reservePart == 2) {
            $reservePart = "リモ2部";
            $reservePartPast = "2部参加";
          } else if ($reservePart == 3) {
            $reservePart = "リモ3部";
            $reservePartPast = "3部参加";
          }


          // ここから過去
          if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">'.$reservePartPast.'</p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          } else {
            // ここから未来
            $reserve_settings = ReserveSettings::get();
            $reserve_settings_id = $day->authReserveDate($day->everyDay())->first()->id;
            
            $id = $reserve_settings->first()->users
            ->where('reserve_setting_id', $reserve_settings_id)
            ->first();

            $html[] = '<button type="submit" class="btn btn-danger p-0 w-75 cancel-modal-open" name="delete_date" id = "'.$id.'" reserve_part = "'.$reservePart.'" reserve_date ="'.$day->authReserveDate($day->everyDay())->first()->setting_reserve.'" style="font-size:12px" reservePart="' . $day->authReserveDate($day->everyDay())->first()->setting_part . '">' . $reservePart . '</button>';
            $html[] = '<input type="hidden" name="getId[]" value="" form="deleteParts">';
            $html[] = '<input type="hidden" name="getPart[]" value="" 
          form="reserveParts">';
          }
          // 予約してない過去日の場合
        } else if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
          $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">受付終了</p>';
          $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
        } else {
          $html[] = $day->selectPart($day->everyDay());
          
        }
        $html[] = $day->getDate();
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">' . csrf_field() . '</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">' . csrf_field() . '</form>';
    return implode('', $html);
  }

  protected function getWeeks()
  {
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while ($tmpDay->lte($lastDay)) {
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
