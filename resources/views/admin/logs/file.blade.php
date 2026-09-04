<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ $logFile['title'] }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="mb-4 flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.logs.file', ['log' => 'laravel']) }}"
           class="px-3 py-2 rounded bg-slate-700 text-white">Laravel лог</a>
        <a href="{{ route('admin.logs.file', ['log' => 'worker']) }}"
           class="px-3 py-2 rounded bg-slate-700 text-white">Worker лог</a>
        <form method="post" action="{{ route('admin.logs.clear', ['log' => $log]) }}">
          @csrf
          <button type="submit" class="px-3 py-2 rounded bg-red-700 text-white"
                  onclick="return confirm('Очистить этот лог-файл?')">
            Очистить лог
          </button>
        </form>
      </div>

      <div class="mb-2 text-sm text-slate-400">{{ $path }}</div>
      <pre class="w-full max-h-[70vh] overflow-auto whitespace-pre-wrap break-words rounded bg-slate-950 p-4 text-xs text-slate-200">{{ $content }}</pre>
    </div>
  </div>
</x-app-layout>
