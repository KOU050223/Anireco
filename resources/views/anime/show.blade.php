<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ $anime->title }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <h3 class="text-2xl mb-4">{{ $anime->title }}</h3>
          <p><strong>放送年:</strong> {{ $anime->release_year }}</p>
          <p><strong>概要:</strong> {{ $anime->description }}</p>
          <a href="{{ route('anime.search') }}" class="mt-4 inline-block text-blue-500 hover:underline">検索に戻る</a>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
