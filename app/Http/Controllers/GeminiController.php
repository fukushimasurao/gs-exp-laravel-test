<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// ⭐️ ↓下2行を追加
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Str;

class GeminiController extends Controller
{
    public function showConsultPage()
    {
        return view('ai-consult');
    }

    public function generateResponse(Request $request)
    {
        // formから送られてきたai_queryを取得
        $query = $request->input('ai_query');
        // 生成AIのモデルを指定してインスタンス化
        $gemini = Gemini::generativeModel(model: 'models/gemini-1.5-pro-002');
        // 生成AIに対して、生成したい内容をリクエスト
        $result = $gemini->generateContent($query);
        // 生成AIの結果を取得
        $markdownText = $result->text();
        // MarkdownをHTMLに変換
        $html = Str::markdown($markdownText);
        // ai-consult.blade.phpに$htmlを渡して表示
        return view('ai-consult', ['response' => $html]);
    }
}
