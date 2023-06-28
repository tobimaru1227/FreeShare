<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;

class TweetController extends Controller
{
    public function index()
    {
        $tweets = Tweet::orderBy('created_at', 'desc')->get();
        return view('tweets.index', ['tweets' => $tweets]);
    }
    
    /**
     * 投稿ページを表示
     * @return view
     */
    public function create()
    {
        return view('tweets.create');
    }
    
    /**
     * 投稿データを登録
     * @return redirect
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        
        // 画像があった場合の処理
        if($file = $request->image) {
            $fileName = date('Ymd_His').'_'. $file->getClientOriginalName(); // ファイルのオリジナルネーム取得
            $target_path = public_path('storage/');
            $file->move($target_path, $fileName);
            $inputs = $request->except(['image']); // 'image'キーを一度除外する
            $inputs['image'] = $fileName; // 'image'キーにファイル名を追加する
        }
        
        Tweet::create($inputs);
        
        session()->flash('message', '新しい投稿ができました。');
        return redirect()->route('tweet.index');
    }
}
