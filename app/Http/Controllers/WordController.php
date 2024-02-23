<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

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

    private function getCurrentUser()
    {
        return Auth::user();
    }

    /**
     * 単語の一覧を返す
     *
     * @param Request $request
     * @return Illuminate\Http\JsonResponse;
     */
    public function index(Request $request): JsonResponse
    {
        $user = $this->getCurrentUser();
        $sort = $request->sort == '2' ? 'asc' : 'desc';
        if ($user) {
            // 表示順
            $query = $user->words()->orderBy('created_at', $sort);
            // 記憶度
            if (in_array($request->memorySearch, ['0', '1', '2'])) {
                $query->where('memory', $request->memorySearch);
            }
            $userWords = $query->paginate(12);
            return response()->json($userWords);
        } else {
            return response()->json(['message' => 'ログインしてません'], 401);
        }
    }

    /**
     * 単語の新規作成
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Http\JsonResponse;
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validation = $request->validate([
                'word_en' => 'required',
                'word_ja' => 'required',
                'part_of_speech' => 'required',
                'memory' => 'required',
            ]);
            DB::beginTransaction();
            $this->getCurrentUser()->words()->create($request->all());
            DB::commit();
            return response()->json(['message' => '単語の登録に成功しました'], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 412);
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
        }
    }
}
