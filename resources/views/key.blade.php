<x-layout>
  <x-slot:title>
    {{$key->phrase}} - динамика запросов за последний год, статистика и популярность
  </x-slot>
  <x-slot:desc>
    {{$key->phrase}} - динамика запросов за последний год, статистика и популярность за последние 12 месяцев
  </x-slot>

  <div class="container mx-auto px-4 py-8 pt-2">
  <div class="max-w-6xl mx-auto space-y-4 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="text-center space-y-2">
      <h1
        class="py-2 text-4xl md:text-5xl font-bold bg-gradient-to-r from-primary via-primary-glow to-accent bg-clip-text text-transparent"
      >
        {{$key->phrase}}
      </h1>
      <p class="text-muted-foreground text-lg">
        Интерактивная визуализация популярности за период {{$firstMonth}} - {{$lastMonth}}
      </p>

      <div class="flex mt-2 gap-2 flex-wrap justify-center">
        @if(!$hasDevicesStats)
        <form class="flex justify-center" method="POST" action="{{route('devices', $key->slug)}}">
          @csrf
          <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 min-w-[250px]" 
          type="submit"
          onclick="(function() {
                    if(!confirm('Хотите получить данные по устройствам для этого запроса?')) event.preventDefault();
                  })();">
                  <svg class="inline-block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-mobile"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14z" /><path d="M11 4h2" /><path d="M12 17v.01" /></svg>
            Получить данные по устройствам
          </button>
        </form>
        @endif

        <button class="share_btn inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none 
        focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 
        [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 
        text-sm px-4 py-2 rounded-xl shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30 transition-all animate-in fade-in slide-in-from-bottom-12 duration-1000 delay-500">
          <svg class="inline-block" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-share"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M18 6m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M8.7 10.7l6.6 -3.4" /><path d="M8.7 13.3l6.6 3.4" /></svg>
          Поделиться
      </button>
      </div>
      
    </div>
    <div class="rounded-lg border text-card-foreground p-3 sm:p-6 bg-card border-border shadow-lg">
      <div id="chart"></div>
      {{--<div class="mb-6">
        <h2 class="text-2xl font-bold mb-2">Тренд: "React разработка"</h2>
        <p class="text-muted-foreground">Количество поисковых запросов за последний год</p>
      </div>--}}

      <div class="mt-6 grid {{--grid-cols-2 md:grid-cols-4--}} grid-cols-2 md:grid-cols-4 gap-4">
        <div class="p-4 bg-secondary rounded-xl">
          <p class="text-sm text-muted-foreground mb-1">{{$lastMonth}} (запросы)</p>
          <p class="text-2xl font-bold text-primary">{{formatNumber($lastMonthStat->value)}}</p>
        </div>
        <div class="p-4 bg-secondary rounded-xl">
          <p class="text-sm text-muted-foreground mb-1">Всего запросов (последние {{$monthCount}} месяцев)</p>
          <p class="text-2xl font-bold text-primary">{{formatNumber($addStats['all'])}}</p>
        </div>
        {{--<div class="p-4 bg-secondary rounded-xl">
          <p class="text-sm text-muted-foreground mb-1">Средний рост</p>
          <p class="text-2xl font-bold text-chart-3">+15%</p>
        </div>--}}
        <div class="p-4 bg-secondary rounded-xl">
          <p class="text-sm text-muted-foreground mb-1">Минимум ({{formatNumber($addStats['min']->value)}} запросов)</p>
          <p class="text-2xl font-bold text-accent">{{$addStats['min_month']}}</p>
        </div>
        <div class="p-4 bg-secondary rounded-xl">
          <p class="text-sm text-muted-foreground mb-1">Максимум ({{formatNumber($addStats['max']->value)}} запросов)</p>
          <p class="text-2xl font-bold text-accent">{{$addStats['max_month']}}</p>
        </div>
        {{--<div class="p-4 bg-secondary rounded-xl">
          <p class="text-sm text-muted-foreground mb-1">Прогноз</p>
          <p class="text-2xl font-bold text-chart-4">5,200</p>
        </div>--}}
      </div>
      @if($hasDevicesStats)
      <div class="mt-6 grid {{--grid-cols-2 md:grid-cols-4--}} grid-cols-2 md:grid-cols-4 gap-4">
        <div class="p-4 bg-secondary rounded-xl flex items-center gap-4">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-desktop"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 5a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10z" /><path d="M7 20h10" /><path d="M9 16v4" /><path d="M15 16v4" /></svg>
          <div>
            <p class="text-sm text-muted-foreground mb-1">Персональные компьютеры ({{formatNumber($addStats['desktop'])}})</p>
            <p class="text-2xl font-bold text-primary">{{$addStats['desktop_percent']}}%</p>
          </div>         
        </div>
        <div class="p-4 bg-secondary rounded-xl flex items-center gap-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-mobile"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14z" /><path d="M11 4h2" /><path d="M12 17v.01" /></svg>          
            <div>
            <p class="text-sm text-muted-foreground mb-1">Телефоны ({{formatNumber($addStats['phone'])}})</p>
            <p class="text-2xl font-bold text-primary">{{$addStats['phone_percent']}}%</p>
          </div>         
        </div>
        <div class="p-4 bg-secondary rounded-xl flex items-center gap-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-tablet"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4a1 1 0 0 1 1 -1h12a1 1 0 0 1 1 1v16a1 1 0 0 1 -1 1h-12a1 1 0 0 1 -1 -1v-16z" /><path d="M11 17a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /></svg>
            <div>
            <p class="text-sm text-muted-foreground mb-1">Планшеты ({{formatNumber($addStats['tablet'])}})</p>
            <p class="text-2xl font-bold text-primary">{{$addStats['tablet_percent']}}%</p>
          </div>         
        </div>
      </div>
      @endif

      {{--@if(count($ups) > 0)
      <div class="mt-6 text-xl">Топ отрезки роста</div>
      <div class="mt-2 grid grid-cols-1 sm:grid-cols-3 gap-4">
        @foreach($ups as $s)
          <x-trend-card-light :stat="$s" />
        @endForeach
      </div>
      @endif

      @if(count($downs) > 0)
      <div class="mt-6 text-xl">Топ отрезки спада</div>
      <div class="mt-2 grid grid-cols-1 sm:grid-cols-3 gap-4">
        @foreach($downs as $s)
          <x-trend-card-light :stat="$s" />
        @endForeach
      </div>
      @endif--}}

      <div class="mt-6 grid sm:grid-cols-2 gap-4">

      @if($addStats['ups_count'] > 0)
      <div
        class="rounded-lg border text-card-foreground shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border-border bg-card/50 backdrop-blur-sm"
      >
        <div class="p-6 {{--pt-0--}}">
          <div class="flex items-center gap-2 mb-4">
            <span class="text-xl {{--text-muted-foreground--}}">Месяцы роста</span>
            <div
              class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-2xl font-semibold transition-colors focus:outline-none focus:ring-2 
              focus:ring-ring focus:ring-offset-2 border-transparent bg-green-500/10 text-green-600 dark:text-green-400 hover:bg-green-500/20"
            >{{$addStats['ups_count']}}</div>
          </div>

           @foreach($ups as $s)
            <x-trend-card-light-v2 :stat="$s" />
          @endForeach
        </div>
      </div>
      @endif
      @if($addStats['downs_count'] > 0)
      <div
        class="rounded-lg border text-card-foreground shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border-border bg-card/50 backdrop-blur-sm"
      >
        <div class="p-6 {{--pt-0--}}">
          <div class="flex items-center gap-2 mb-4">
            <span class="text-xl {{--text-muted-foreground--}}">Месяцы спада</span>
            <div
              class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-2xl font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-red-500/10 text-red-600 dark:text-red-400 hover:bg-red-500/20"
            >{{$addStats['downs_count']}}</div>
          </div>
           @foreach($downs as $s)
            <x-trend-card-light-v2 :stat="$s" />
          @endForeach
        </div>
       
      </div>
      @endif

      </div>

    </div>

    {{--<div class="grid md:grid-cols-2 gap-6">
      <div class="p-6 bg-card rounded-2xl border border-border">
        <h3 class="text-xl font-semibold mb-3">О графике</h3>
        <p class="text-muted-foreground">
          График показывает количество поисковых запросов по выбранному тренду за последние 12 месяцев. Данные
          обновляются ежедневно и позволяют отслеживать динамику интереса пользователей.
        </p>
      </div>
      <div class="p-6 bg-card rounded-2xl border border-border">
        <h3 class="text-xl font-semibold mb-3">Как использовать</h3>
        <ul class="space-y-2 text-muted-foreground">
          <li>• Наведите курсор на график для детальной информации</li>
          <li>• Анализируйте пики и спады активности</li>
          <li>• Используйте статистику для прогнозирования</li>
          <li>• Сравнивайте периоды для выявления паттернов</li>
        </ul>
      </div>
    </div>--}}
  </div>
</div>

@push('scripts')
  <script src="/js/d3.js"></script>
  @vite('resources/css/graph.css')
  @vite('resources/js/graph.js')

@endPush

</x-layout>

