<?php

namespace App\Http\Controllers\Authenticated\Calendar\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\Admin\CalendarView;
use App\Calendars\Admin\CalendarSettingView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\Users\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    public function show()
    {
        $calendar = new CalendarView(time());
        // authReserveDateに自分が予約した日を送信する
        // 自分のIDとreserve_setting_usersのuser_idが同じカラムのreserve_setting_idを取得し、それとreserve_settingsテーブルのIDが同じレコードのsetting_reserveを取得したい。

        // $authId = Auth::id();
        // $reserveDate  = ReserveSettings::whereHas('users', function ($q) use ($authId) {
        //     $q->where('user_id', $authId);
        // })->pluck('setting_reserve');
        
        // ここまで

        return view('authenticated.calendar.admin.calendar', compact('calendar'));
        // return view('authenticated.calendar.admin.calendar', compact('calendar', 'reserveDate'));
    }

    public function reserveDetail($date, $part)
    {
        $reservePersons = ReserveSettings::with('users')->where('setting_reserve', $date)->where('setting_part', $part)->get();
        return view('authenticated.calendar.admin.reserve_detail', compact('reservePersons', 'date', 'part'));
    }

    public function reserveSettings()
    {
        $calendar = new CalendarSettingView(time());
        return view('authenticated.calendar.admin.reserve_setting', compact('calendar'));
    }

    public function updateSettings(Request $request)
    {
        $reserveDays = $request->input('reserve_day');
        foreach ($reserveDays as $day => $parts) {
            foreach ($parts as $part => $frame) {
                ReserveSettings::updateOrCreate([
                    'setting_reserve' => $day,
                    'setting_part' => $part,
                ], [
                    'setting_reserve' => $day,
                    'setting_part' => $part,
                    'limit_users' => $frame,
                ]);
            }
        }
        return redirect()->route('calendar.admin.setting', ['user_id' => Auth::id()]);
    }
}
