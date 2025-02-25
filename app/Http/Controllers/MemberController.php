<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function index()
    {
        // DBのmemberてーぶるの中身取得
        // member viewに↑の情報を表示させてあげる。
        $members = DB::select("SELECT * FROM members");
        return view('members', compact('members'));
    }
}
