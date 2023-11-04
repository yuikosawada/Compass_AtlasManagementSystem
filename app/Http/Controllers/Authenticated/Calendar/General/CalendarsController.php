<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    public function show(){
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    public function reserve(Request $request){
        DB::beginTransaction();
        try{
            $getPart = $request->getPart;
            $getDate = $request->getData;
            // エラー $getDateと$getPartに入ってるものの数が合わない（$getPartに過ぎた日にちがふくまれてない）
            dd($getPart);
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            
            foreach($reserveDays as $key => $value){
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                $reserve_settings->decrement('limit_users');
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

    // 予約削除
    public function delete(Request $request)
    {
     


        // ReserveSettingsのidとReserveSettingUersのreserve_settiing_idが一致し、かつ、ReserveSettingUersのuser_idとログイン中のユーザーのidが一致するレコードを削除

        // ReserveSettings::with('reserve_setting_users')->findOrFail($id)->delete();
        DB::beginTransaction();
        try{
            $reservePart = $request->reservePart;
            $reserve_date = $request->reserve_date;
            // エラー $getDateと$getPartに入ってるものの数が合わない（$getPartに過ぎた日にちがふくまれてない）
            // $reserveDays = array_filter(array_combine($reserve_date, $reserve_part));
            
            // foreach($reserveDays as $key => $value){
                $reserve_settings = ReserveSettings::where('setting_reserve', $reserve_date)->where('setting_part', $reservePart)->first();
                // dd($reserve_settings);
                // 予約リミット数を増やす
                $reserve_settings->increment('limit_users');
                // 削除
                $reserve_settings->users()->detach(Auth::id());
            // }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);

    }
}