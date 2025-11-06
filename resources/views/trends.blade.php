<x-layout>

  <div class="container mx-auto px-4 py-16">
  <div class="max-w-7xl mx-auto">
    <div class="text-center mb-12 animate-in fade-in slide-in-from-bottom-8 duration-1000">
      <h1
        class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-primary via-primary to-primary/60 bg-clip-text text-transparent"
      >
        Октябрь 2025. Популярные тренды
      </h1>
      {{--<p class="text-lg text-muted-foreground max-w-2xl mx-auto">
        Актуальные изменения популярности
      </p>--}}
    </div>
    <div
      class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-in fade-in slide-in-from-bottom-16 duration-1000 delay-300"
    >
    @foreach($stats as $s)
      <a href="{{route('key', $s->phrase->slug)}}" target="_blank"
        class="rounded-lg border text-card-foreground shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border-border bg-card/50 backdrop-blur-sm"
      >
        <div class="flex flex-col space-y-1.5 p-6">
          <h3 class="font-semibold tracking-tight text-xl flex items-center justify-between">
            <span>{{$s->phrase->phrase}}</span
            >
            @if($s->percent_change >= 0)
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
              class="lucide lucide-trending-up w-5 h-5 text-green-500"
            >
              <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
              <polyline points="16 7 22 7 22 13"></polyline>
            </svg>
            @else 
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
              class="lucide lucide-trending-down w-5 h-5 text-red-500"
            >
              <polyline points="22 17 13.5 8.5 8.5 13.5 2 7"></polyline>
              <polyline points="16 17 22 17 22 11"></polyline>
            </svg>
            @endif
          </h3>
        </div>
        <div class="p-6 pt-0">
          <div class="flex items-center gap-2">
            <span class="text-sm text-muted-foreground">Изменение за месяц:</span>
            @if($s->percent_change >= 0)
            <div
              class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-green-500/10 text-green-600 dark:text-green-400 hover:bg-green-500/20"
            >
              +{{$s->percent_change}}%
            </div>
            @else 
            <div
              class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-red-500/10 text-red-600 dark:text-red-400 hover:bg-red-500/20"
            >
              {{$s->percent_change}}%
            </div>
            @endif
          </div>
        </div>
      </a>
    @endForeach


      {{--<div
        class="rounded-lg border text-card-foreground shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border-border bg-card/50 backdrop-blur-sm"
      >
        <div class="flex flex-col space-y-1.5 p-6">
          <h3 class="font-semibold tracking-tight text-xl flex items-center justify-between">
            <span>Web3</span
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="lucide lucide-trending-down w-5 h-5 text-red-500"
            >
              <polyline points="22 17 13.5 8.5 8.5 13.5 2 7"></polyline>
              <polyline points="16 17 22 17 22 11"></polyline>
            </svg>
          </h3>
        </div>
        <div class="p-6 pt-0">
          <div class="flex items-center gap-2">
            <span class="text-sm text-muted-foreground">Изменение за месяц:</span>
            <div
              class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-red-500/10 text-red-600 dark:text-red-400 hover:bg-red-500/20"
            >
              -5.2%
            </div>
          </div>
        </div>
      </div>--}}





    </div>
  </div>
</div>


</x-layout>