<x-layout :header="false">

<div class="min-h-screen bg-gradient-to-br from-background via-background to-secondary">
  
  <div class="container mx-auto px-4 py-16">
    <div class="flex flex-col items-center justify-center min-h-[80vh] text-center space-y-8">
      <div class="space-y-4 animate-in fade-in slide-in-from-bottom-4 duration-1000">
        <div class="flex items-center justify-center gap-3 mb-6">
          <div class="p-3 bg-primary/10 rounded-2xl">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="lucide lucide-trending-up w-12 h-12 text-primary"
            >
              <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
              <polyline points="16 7 22 7 22 13"></polyline>
            </svg>
          </div>
        </div>
        <h1
          class="text-5xl md:text-7xl font-bold bg-gradient-to-r from-primary via-primary-glow to-accent bg-clip-text text-transparent"
        >
          WatchTrend
        </h1>
        <p class="text-xl md:text-2xl text-muted-foreground max-w-2xl mx-auto">
          Визуализируйте и анализируйте тренды с помощью интерактивных графиков
        </p>
      </div>

      @include('partials.form')

      {{--<a href="{{route('trends')}}" class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-11 mt-12 text-lg px-8 py-6 rounded-xl shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30 transition-all animate-in fade-in slide-in-from-bottom-12 duration-1000 delay-500">
        <svg class="inline-block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trending-up"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8" /><path d="M14 7l7 0l0 7" /></svg>
        Октябрь 2025. Тренды
      </a>--}}
      
      
      {{--<div
        class="grid md:grid-cols-3 gap-6 max-w-4xl mx-auto mt-12 animate-in fade-in slide-in-from-bottom-8 duration-1000 delay-300"
      >
        <div
          class="p-6 bg-card rounded-2xl border border-border hover:border-primary/50 transition-all hover:shadow-lg hover:shadow-primary/10"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="lucide lucide-chart-column w-10 h-10 text-primary mb-4 mx-auto"
          >
            <path d="M3 3v16a2 2 0 0 0 2 2h16"></path>
            <path d="M18 17V9"></path>
            <path d="M13 17V5"></path>
            <path d="M8 17v-3"></path>
          </svg>
          <h3 class="text-lg font-semibold mb-2">Интерактивные графики</h3>
          <p class="text-sm text-muted-foreground">Детальная визуализация данных за последний год</p>
        </div>
        <div
          class="p-6 bg-card rounded-2xl border border-border hover:border-primary/50 transition-all hover:shadow-lg hover:shadow-primary/10"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="lucide lucide-activity w-10 h-10 text-accent mb-4 mx-auto"
          >
            <path
              d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2"
            ></path>
          </svg>
          <h3 class="text-lg font-semibold mb-2">Анализ трендов</h3>
          <p class="text-sm text-muted-foreground">Отслеживайте изменения популярности ключевых слов</p>
        </div>
        <div
          class="p-6 bg-card rounded-2xl border border-border hover:border-primary/50 transition-all hover:shadow-lg hover:shadow-primary/10"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="lucide lucide-trending-up w-10 h-10 text-chart-3 mb-4 mx-auto"
          >
            <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
            <polyline points="16 7 22 7 22 13"></polyline>
          </svg>
          <h3 class="text-lg font-semibold mb-2">Данные в реальном времени</h3>
          <p class="text-sm text-muted-foreground">Актуальная информация о запросах и поисковых трендах</p>
        </div>
      </div>--}}

      {{--<button
        class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-11 mt-12 text-lg px-8 py-6 rounded-xl shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30 transition-all animate-in fade-in slide-in-from-bottom-12 duration-1000 delay-500"
      >
        Посмотреть пример графика
      </button>
      --}}
      @if(count($trends) > 0)
      <div class="w-full max-w-4xl mx-auto mt-16 animate-in fade-in slide-in-from-bottom-16 duration-1000 delay-700">
        <h2 class="text-2xl font-semibold text-center mb-6 text-foreground">Популярное {{--Популярные тренды--}}</h2>
        <div
          class="flex flex-wrap justify-center gap-3 p-6 {{--bg-card/50 backdrop-blur-sm rounded-2xl border border-border--}}"
        >
        @foreach($trends as $t)
          <a href="{{route('key', $t->slug)}}"
            class="inline-flex items-center rounded-full border font-semibold focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80 text-lg px-4 py-2 cursor-pointer transition-all hover:scale-110 hover:shadow-lg hover:shadow-primary/20 hover:border-primary/50"
          >
            {{$t->phrase}}
          </a>
          @endForeach

        </div>
      </div>
      @endif
    </div>
  </div>
</div>

</x-layout>