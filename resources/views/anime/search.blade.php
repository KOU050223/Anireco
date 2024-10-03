<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      アニメ検索
    </h2>
    <!-- アニメDBをAPI叩いて更新 -->
    <form action="{{ route('fetch.all.titles') }}" method="POST">
      @csrf
      <button type="submit">アニメDBを更新</button>
    </form>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
        <form action="{{ route('anime.search') }}" method="GET" class="mb-6">
            <div class="flex items-center">
              <input type="text" name="keyword" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="アニメのタイトルを検索" value="{{ request('keyword') }}">
              <button type="submit" class="ml-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700">
                検索
              </button>
            </div>
          </form>

          <!-- 検索結果の表示 -->
          @if(request('keyword') && isset($animes) && count($animes) > 0)
            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mb-4">検索結果</h3>
            <ul>
              @foreach ($animes as $anime)
                <li class="mb-2">
                  <a href ="{{ route('anime.show', $anime->tid) }}" class="inline-flex items-center">
                    <span class="ml-2 text-gray-700 dark:text-gray-300">{{ $anime->title }} <small class="text-gray-500">({{ $anime->release_year }})</small></span>
                  </a>
                </li>
              @endforeach
            </ul>
          @elseif(request('keyword'))
            <p class="text-gray-500 mb-4">検索結果はありません。</p>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
