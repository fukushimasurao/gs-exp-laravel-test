<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// ⭐️ 2行追加
use App\Models\Schedule; // ⭐️ScheduleModelを利用するためここで呼び出す。
use Illuminate\Support\Facades\Auth; // ⭐️Auth::id()を利用するためここで呼び出す。


class ScheduleController extends Controller
{
    public function scheduleAdd(Request $request)
    {
        // バリデーション設定。
        $request->validate([
            'start_date' => 'required|integer', // 必須。integer型。
            'end_date' => 'required|integer', // 必須。integer型。
            'event_name' => 'required|max:32', // 必須。最大32文字
        ]);

        // 登録処理
        $schedule = new Schedule;
        // 日付に変換。JavaScriptのタイムスタンプはミリ秒なので秒に変換
        $schedule->start_date = date('Y-m-d H:i:s', $request->input('start_date') / 1000);
        $schedule->end_date = date('Y-m-d H:i:s', $request->input('end_date') / 1000);
        $schedule->event_name = $request->input('event_name');
        $schedule->user_id = Auth::id(); // ログインユーザーのIDを設定
        $schedule->save();

        return; // viewの返答はいらないので、returnだけ書いて終わり。
    }
}
