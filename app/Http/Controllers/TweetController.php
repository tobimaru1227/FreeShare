<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function index()
    {
        $tweets = Tweet::all();
        return view('tweets.index', ['tweets' => $tweets]);
    }
}
