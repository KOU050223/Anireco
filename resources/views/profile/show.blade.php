<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('User詳細') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <a href="{{ route('tweets.index') }}" class="text-blue-500 hover:text-blue-700 mr-2">一覧に戻る</a>
          <p class="text-gray-800 dark:text-gray-300 text-lg">{{ $user->name }}</p>
          <div class="text-gray-600 dark:text-gray-400 text-sm">
            <p>アカウント作成日時: {{ $user->created_at->format('Y-m-d H:i') }}</p>
          </div>
          @if ($user->id !== auth()->id())
          <div class="text-gray-900 dark:text-gray-100">
            @if ($user->followers->contains(auth()->id()))
            <form action="{{ route('follow.destroy', $user) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-500 hover:text-red-700">unFollow</button>
            </form>
            @else
            <form action="{{ route('follow.store', $user) }}" method="POST">
              @csrf
              <button type="submit" class="text-blue-500 hover:text-blue-700">follow</button>
            </form>
            @endif
          </div>
          @endif

          <!-- 🔽 フォローフォロワー数 -->
          <p>{{$user->follows->count()}}フォロー中</p>
          <p>{{$user->followers->count()}}フォロワー</p>

          <!-- 🔽 Tweet表示 -->
          @if ($tweets->count())

          <!-- ページネーション -->
          <div class="mb-4">
            {{ $tweets->appends(request()->input())->links() }}
          </div>

          @foreach ($tweets as $tweet)
          <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
            <a href="{{ route('profile.show', $tweet->user) }}">
              <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $tweet->user->name }}</p>
            </a>
            <p class="text-gray-800 dark:text-gray-300">{!! nl2br(e($tweet->tweet)) !!}</p>
            <a href="{{ route('tweets.show', $tweet) }}" class="text-blue-500 hover:text-blue-700">詳細を見る</a>
            <div class="flex justify-left gap-4">
              
              <a href="{{ route('tweets.comments.create', $tweet) }}" class="text-blue-500 hover:text-blue-700 mr-2"><p class="text-gray-600 dark:text-gray-400 ml-4">💭 {{ $tweet->comments->count() }}</p></a>

              @if ($tweet->liked->contains(auth()->id()))
              <form action="{{ route('tweets.dislike', $tweet) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700">❤ {{$tweet->liked->count()}}</button>
              </form>
              @else
              <form action="{{ route('tweets.like', $tweet) }}" method="POST">
                @csrf
                <button type="submit" class="text-blue-500 hover:text-blue-700">❤ {{$tweet->liked->count()}}</button>
              </form>
              @endif
        　  </div>
          </div>
          @endforeach

          <!-- ページネーション -->
          <div class="mt-4">
            {{ $tweets->appends(request()->input())->links() }}
          </div>

          @else
          <p>No tweets found.</p>
          @endif

        </div>
      </div>
    </div>
  </div>
</x-app-layout>

