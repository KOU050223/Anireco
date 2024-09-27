<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Tweet作成') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <!-- 検索フォーム -->
          <form action="{{ route('tweets.create') }}" method="GET" class="mb-6">
            <div class="flex items-center">
              <input type="text" name="keyword" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="アニメのタイトルを検索" value="{{ request('keyword') }}">
              <button type="submit" class="ml-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700">
                検索
              </button>
            </div>
          </form>

          <!-- 検索結果の表示 -->
          @if(isset($animes) && count($animes) > 0)
            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mb-4">検索結果</h3>
            <form id="anime-selection-form" class="mb-4">
              <ul>
                @foreach ($animes as $anime)
                  <li class="mb-2">
                    <label class="inline-flex items-center">
                      <input type="radio" name="selected_anime" value="{{ $anime->title }}" class="form-radio text-blue-500">
                      <span class="ml-2 text-gray-700 dark:text-gray-300">{{ $anime->title }} <small class="text-gray-500">({{ $anime->release_year }})</small></span>
                    </label>
                  </li>
                @endforeach
              </ul>
            </form>
          @else
            <p class="text-gray-500 mb-4">検索結果はありません。</p>
          @endif

          <!-- Tweet投稿フォーム -->
          <form method="POST" action="{{ route('tweets.store') }}">
            @csrf
            <div class="mb-4">
              <label for="tweet" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Tweet</label>
              <input type="text" name="tweet" id="tweet" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="メッセージを入力してください">
              @error('tweet')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
              @enderror
            </div>

            <!-- 選択したアニメのタイトルを hidden フィールドで渡す -->
            <input type="hidden" name="selected_anime" id="selected_anime">

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Tweet</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    // ラジオボタンの値をhiddenフィールドに設定する
    document.addEventListener('DOMContentLoaded', function() {
      const radioButtons = document.querySelectorAll('input[name="selected_anime"]');
      const hiddenField = document.getElementById('selected_anime');

      radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
          if (this.checked) {
            hiddenField.value = this.value;
          }
        });
      });
    });
  </script>
</x-app-layout>
