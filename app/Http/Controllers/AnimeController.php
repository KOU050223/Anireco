<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AnimeController extends Controller
{
    public function fetchAllTitles()
    {
        $response = Http::timeout(120)->get("https://cal.syoboi.jp/db.php?Command=TitleLookup&TID=*");

            if ($response->successful()) {
                $xml = simplexml_load_string($response->body());
                $titleItems = $xml->TitleItems->TitleItem;

                foreach ($titleItems as $titleItem) {
                    $this->saveTitle($titleItem);
                }

                return response()->json(['message' => 'Titles saved successfully']);
            }

        return response()->json(['message' => 'Failed to fetch titles'], 500);
    }

    private function saveTitle($titleItem)
    {
        Anime::updateOrCreate(
            ['tid' => (string) $titleItem->TID],
            [
                'title' => (string) $titleItem->Title,
                'release_year' => (int) $titleItem->FirstYear,
            ]
        );
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($tid)
    {
        // 選択されたアニメの詳細を表示
        $anime = Anime::where('tid', $tid)->firstOrFail();        return view('anime.show', compact('anime'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anime $anime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anime $anime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anime $anime)
    {
        //
    }
    
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // キーワードが入力された場合に検索を実行
        $animes = Anime::query()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('title', 'LIKE', "%{$keyword}%");
            })
            ->get();
    
        return view('anime.search', compact('animes'));
    }    
}
