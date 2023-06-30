<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TweetRequest;
use App\Http\Requests\TweetUpdateRequest;
use App\Models\Tweet;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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
    public function store(TweetRequest $request)
    {
        try {
            $inputs = $request->all();
            
            // 画像があった場合の処理
            if($file = $request->image) {
                $fileName = date('Ymd_His').'_'. $file->getClientOriginalName();
                $target_path = public_path('storage/');
                $file->move($target_path, $fileName);
                $inputs = $request->except(['image']); // 'image'キーを一度除外する
                $inputs['image'] = $fileName; // 'image'キーにファイル名を追加する
            }
            
            Tweet::create($inputs);
            
            session()->flash('message', '新しい投稿ができました。');
            return redirect()->route('tweet.index');
            
        } catch (\Exception $e) {
            // 例外が発生した場合の処理
            Log::error($e); // ログに残す
            session()->flash('message', '投稿の保存中にエラーが発生しました。');
            return back()->withInput();
        }
    }
    
    /**
     * 投稿詳細ページを表示
     * @param int $id
     * @return view
     */
    public function show(int $id)
    {
        $tweet = Tweet::find($id);
        return view('tweets.show', ['tweet' => $tweet]);
    }
    
    /**
     * 編集ページを表示
     * @param int $id
     * @return view
     */
    public function edit(int $id)
    {
        $tweet = Tweet::find($id);
        // 直打ち対策
        if(Auth::id() != $tweet->user_id) {
            return redirect()->route('tweet.index');
        }
        
        return view('tweets.edit', ['tweet' => $tweet]);
    }
    
        /**
     * 投稿データを登録
     * @return redirect
     */
    public function update(TweetUpdateRequest $request)
    {
        try {
            $inputs = $request->all();
            
            // 画像があった場合の処理
            if($file = $request->image) {
                $fileName = date('Ymd_His').'_'. $file->getClientOriginalName();
                $target_path = public_path('storage/');
                $file->move($target_path, $fileName);
                $inputs = $request->except(['image']); // 'image'キーを一度除外する
                $inputs['image'] = $fileName; // 'image'キーにファイル名を追加する
            }
            
            $tweet = Tweet::find($inputs['id']);
            $tweet->fill([
                'content' => $inputs['content'],
                'image' => $inputs['image'] ?? null,
            ]);

            $tweet->save();
            
            session()->flash('message', '投稿データを更新しました。');
            return redirect()->route('tweet.index');
            
        } catch (\Exception $e) {
            // 例外が発生した場合の処理
            Log::error($e); // ログに残す
            session()->flash('message', '投稿の保存中にエラーが発生しました。');
            return back()->withInput();
        }
    }
}
