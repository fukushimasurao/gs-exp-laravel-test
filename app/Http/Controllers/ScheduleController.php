<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    		// ⭐️ここから追加！！！
    public function scheduleGet(Request $request)
    {
        // バリデーション
        $request->validate([
            'start_date' => 'required|integer',
            'end_date' => 'required|integer'
        ]);

        // カレンダー表示期間
        // JSから送られてきた形式を下記で利用できる用に変形している
        $start_date = date('Y-m-d', $request->input('start_date') / 1000);
        $end_date = date('Y-m-d', $request->input('end_date') / 1000);

        // Scheduleから取得処理
        $schedules = Schedule::query()
            ->select(
            // テーブルのカラム名を、FullCalendarの形式に合わせる
                'start_date as start',
                'end_date as end',
                'event_name as title'
            )
            // FullCalendarの表示範囲のみ表示
            ->where('end_date', '>', $start_date)
            ->where('start_date', '<', $end_date)
            ->where('user_id', Auth::id()) // ログインユーザーのスケジュールのみ取得
            ->get();

        // 終日の予定の時間部分は、00:00:00として保存している。
        // このような00:00:00のものは、時間部分を消して'Y-m-d'の形に変更しする。
        // FullCalendar側が'Y-m-d'の形式でないと終日の予定として認識できないため。
            $schedules = $schedules->map(function ($event) {
            $startDate = new \DateTime($event->start);
            $endDate = new \DateTime($event->end);

            if ($startDate->format('H:i:s') === '00:00:00' && $endDate->format('H:i:s') === '00:00:00') {
                $event->start = $startDate->format('Y-m-d');
                $event->end = $endDate->format('Y-m-d');
            }

            return $event;
        });

        return $schedules;
    }

    public function scheduleList()
    {
        // Schedule modelから、user_idが今ログインしている人のIDだけを抽出して、それをstart_date昇順にして取得
        $schedules = Schedule::where('user_id', Auth::id())->orderBy('start_date', 'asc')->get();
        return view('schedule-list', compact('schedules'));
    }

    // show($id)の$idは、URLで渡される'/schedules/{id}'のidの部分です。URLが`/schedules/19`だったら、この引数にも19が渡されます。
    public function show($id)
    {
        // findOrFail()は、データベースからレコードを取得し、もしそのレコードが存在しない場合は404エラー（Not Found）を出してくれる
        $schedule = Schedule::findOrFail($id);
        return view('schedule-show', compact('schedule'));
    }

    public function destroy($id)
    {
        // showメソッドと同じ。Scheduleからひとつ抜き出す。
        $schedule = Schedule::findOrFail($id);

        // delete()で文字通り削除。
        $schedule->delete();

        // 'schedule-list'にリダイレクト。'schedule-list'はrouteでつけた「あだ名」の部分です。
        return redirect()->route('schedule-list');
    }

        public function edit($id)
    {
        // showメソッドと同じ。Scheduleからひとつ抜き出す。
        $schedule = Schedule::findOrFail($id);
        
        return view('schedule-edit', ['schedule' => $schedule]);
    }

        // ⭐️追加
    public function update(Request $request, $id)
    {
        // ブラウザから送られる内容 = formのinputの内容に対してバリデーションの処理
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'event_name' => 'required|max:32',
            'details' => 'nullable|string|max:1024',
        ]);

        // URLで与えられたIDでスケジュールを検索
        $schedule = Schedule::findOrFail($id);
        
        // $request->inputでブラウザから送られてきた内容を各カラムに設定
        $schedule->start_date = $request->input('start_date');
        $schedule->end_date = $request->input('end_date');
        $schedule->event_name = $request->input('event_name');
        $schedule->details = $request->input('details');
        
        // 保存！
        $schedule->save();

        // 完了したら、リダイレクト。
        return redirect()->route('schedules.show', $schedule->id);
    }
}
