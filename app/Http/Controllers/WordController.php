<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WordController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum');
    //     $this->middleware(function ($request, $next) {

    //         $id = $request->route()->parameter('id');

    //         if(!is_null($id)){ // null判定
    //             $wordUserId = Word::findOrFail($id)->user->id;
    //             $wordUserId = (int)$wordUserId; // キャスト 文字列→数値に型変換
    //             $userId = Auth::id();
    //             if($userId !== $wordUserId) {
    //                 abort(404);
    //             }
    //         }
    //         return $next($request);
    //     });
    // }
    public function index()
    {
        $user = Auth::user();
        if ($user) {
            $userWords = $user->words;
            return response()->json($userWords);
        } else {
            return response()->json(['message' => 'ログインしてません'], 401);
        }
    }
}
