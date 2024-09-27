<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Models\Anime;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $tweets = Tweet::with(['user', 'liked'])->latest()->get();
      // dd($tweets);
      return view('tweets.index', compact('tweets'));
    }  

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // アニメの検索結果を取得
        $animes = Anime::query();

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $animes = $animes->where('title', 'LIKE', '%' . $keyword . '%');
        }

        $animes = $animes->get();

        // 検索結果と選択されたアニメタイトルをビューに渡す
        return view('tweets.create', compact('animes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tweet' => 'required|max:255',
        ]);

        // アニメのタイトルが選択されている場合、Tweetにタイトルを組み込む
        $tweetContent = $request->input('tweet');

        if ($request->has('selected_anime')) {
            $animeTitle = $request->input('selected_anime');
            $tweetContent = "【{$animeTitle}】\n{$tweetContent}";
        }

        // ログインユーザーのTweetとして保存
        $request->user()->tweets()->create([
            'tweet' => $tweetContent,
        ]);

        return redirect()->route('tweets.index')->with('success', 'Tweetが作成されました！');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet)
    {
        $tweet->load('comments');
        return view('tweets.show', compact('tweet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tweet $tweet)
    {
        return view('tweets.edit', compact('tweet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tweet $tweet)
    {
        $request->validate([
            'tweet' => 'required|max:255',
        ]);

        $tweet->update($request->only('tweet'));

        return redirect()->route('tweets.show', $tweet);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet)
    {
        $tweet->delete();

        return redirect()->route('tweets.index');
    }

    /**
     * Search for tweets containing the keyword.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = Tweet::query();

        // キーワードが指定されている場合のみ検索を実行
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where('tweet', 'like', '%' . $keyword . '%');
        }

        // ページネーションを追加（1ページに10件表示）
        $tweets = $query->latest()->paginate(10);

        return view('tweets.search', compact('tweets'));
    }
}
