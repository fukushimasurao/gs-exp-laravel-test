<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    // ホワイトリスト形式。ここに指定したカラムのみ、controllerからのcreate()やfill()、update()で値が代入される。書き忘れがち。
    protected $fillable = ['start_date', 'end_date', 'event_name', 'user_id'];

    /**
     * リレーション定義。ScheduleはUserに所属する
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
