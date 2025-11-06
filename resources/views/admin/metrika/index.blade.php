<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight dark:[text-64px]">
          {{ __('Яндекс Метрика стата') }}
      </h2> <br>
      <a href="{{$base}}/traffic?period=week&isMinSamplingEnabled=false&id={{config('app.ym_counter')}}&stateHash=6772ae23c1886300191198fa&group=day" target="_blank">
        <x-bladewind.button class="ml-4" size="small">Посещаемость из поисковых систем, за неделю</x-bladewind.button>
      </a>
      <a href="{{$base}}/entrance?period=week&isMinSamplingEnabled=false&id={{config('app.ym_counter')}}&group=day&stateHash=6772b3998615d5000ca3f411" target="_blank">
        <x-bladewind.button class="ml-4" size="small">Страницы входа с трафиком из поисковых систем, за неделю</x-bladewind.button>
      </a>
      <a href="{{$base}}/deepness_time?period=week&isMinSamplingEnabled=false&id={{config('app.ym_counter')}}&group=day&stateHash=6772b474093473000cf8806d" target="_blank">
        <x-bladewind.button class="ml-4" size="small">Время на сайте, за неделю</x-bladewind.button>
      </a>
  </x-slot>

  {{--<x-bladewind.card title="Посты" class="max-w-7xl mx-auto mt-8 !bg-slate-900/50 !border-slate-700/50 !shadow-slate-900/80">
  </x-bladewind.card>--}}


</x-app-layout>
