<x-layout>
  <x-slot:title>
    Проект "{{$project->name}}"
  </x-slot>
  <x-slot:desc>
    Проект "{{$project->name}}"
  </x-slot>

  <main class="container mx-auto px-4 py-8">
  <div class="{{--max-w-6xl--}} mx-auto space-y-8">
    <a href="{{route('my')}}"
      class="justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 flex items-center gap-2"
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
        class="lucide lucide-arrow-left w-4 h-4"
      >
        <path d="m12 19-7-7 7-7"></path>
        <path d="M19 12H5"></path></svg>Назад к проектам
    </a>

    <div class="grid md:grid-cols-2 gap-6">
      <div class="space-y-4">
        <div>
          <h1 class="text-4xl font-bold mb-2">{{$project->name}}</h1>
          <p class="text-muted-foreground">{{$project->description}}</p>
          @if(!$project->visible)
            <p class="text-muted-foreground">Видимость проекта: приватный. Только вы видите этот проект</p>
          @endif
        </div>
        <div class="flex items-center gap-2">
          <div
            class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80"
          >
            Фразы: {{$project->phrases_count}}
          </div>
        </div>

        <div class="space-y-4">
      <h2 class="text-2xl font-semibold">Ключевые фразы</h2>
      <div class="flex flex-wrap gap-3">
        @foreach($project->phrases as $ph)
        <a href="{{route('key', $ph->slug)}}" target="_blank" class="rounded-lg border bg-card text-card-foreground shadow-sm">
          <div class="p-6 pt-6">
            <div class="flex items-center justify-between">
              <span class="text-lg">{{$ph->phrase}}</span>
              @if(false)
              <div
                class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground"
              >
                08.11.2025
              </div>
              @endif
            </div>
          </div>
        </a>
        @endForeach

      </div>
    </div>

      </div>
      <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
        <div class="flex flex-col space-y-1.5 p-6">
          <h3 class="text-2xl font-semibold leading-none tracking-tight">Добавить ключевые фразы</h3>
          <p class="text-sm text-muted-foreground">Введите фразы для отслеживания в этом проекте (каждая с новой строки)</p>
        </div>
        <div class="p-6 pt-0">
          <form class="space-y-4" method="POST" action="{{route('my.project.add', $project->id)}}">
            @csrf
            <div class="space-y-2">
              {{--<label
                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                for="phrase"
                >Ключевая фраза</label>--}}
                <textarea
                class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                id="phrase"
                name="phrases"
                placeholder="Введите ключевые фразы..."
                rows="3"
                required
              ></textarea>
            </div>
            <button
              class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 w-full"
              type="submit"
            >
              Добавить фразы
            </button>
          </form>
        </div>
      </div>
    </div>


    

    
  </div>

  <div class="mt-8 grid md:grid-cols-2 gap-6">
      @foreach($phrases as $ph)
        <div class="rounded-lg border text-card-foreground p-3 sm:p-6 bg-card border-border shadow-lg">

        <h1 class="py-2 text-2xl md:text-3xl font-semibold bg-gradient-to-r from-primary via-primary-glow to-accent bg-clip-text text-transparent">
        {{$ph->phrase}}
      </h1>

      <div id="chart_{{$loop->iteration}}"></div>

        </div>
      @endForeach
    </div>
</main>


@push('scripts')
  <script src="/js/d3.js"></script>
  @vite('resources/css/graph.css')
  @vite('resources/js/graphs.js')

@endPush

</x-layout>

