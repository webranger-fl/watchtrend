<x-layout>
  <x-slot:title>
    {{config('app.name')}} - личный кабинет
  </x-slot>
  <x-slot:desc>
    {{config('app.name')}} - личный кабинет
  </x-slot>

  <main class="container mx-auto px-4 py-8">
  <div class="max-w-4xl mx-auto space-y-8">
    <div>
      <h1 class="text-4xl font-bold mb-2">Проекты</h1>
      <div class="flex items-center justify-between gap-4">
        <p class="text-muted-foreground">Управляйте своими проектами и отслеживайте тренды</p>
        <button id="add_project"
          class="justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 flex items-center gap-2"
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
            class="lucide lucide-plus w-4 h-4"
          >
            <path d="M5 12h14"></path>
            <path d="M12 5v14"></path></svg>Добавить новый проект
        </button>
      </div>
    </div>

    <div style="display:none" id="add_project_block" class="rounded-lg border bg-card text-card-foreground shadow-sm">
  <div class="flex flex-col space-y-1.5 p-6">
    <h3 class="text-2xl font-semibold leading-none tracking-tight">Добавить новый проект</h3>
    <p class="text-sm text-muted-foreground">Создайте проект для группировки и отслеживания ключевых фраз</p>
  </div>
  <div class="p-6 pt-0">
    <form class="space-y-4" method="POST" action="{{route('my.addProject')}}" >
      @csrf
      <div class="space-y-2">
        <label
          class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
          for="name"
          >Название проекта</label
        ><input
          class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
          id="name"
          name="name"
          placeholder="Введите название проекта"
          value="{{old('name')}}"
          required
        />
      </div>
      <div class="space-y-2">
        <label
          class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
          for="description"
          >Описание</label
        ><textarea
          class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
          id="description"
          name="description"
          placeholder="Введите описание проекта"
        ></textarea>
      </div>
      <button
        class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 w-full"
        type="submit"
      >
        Создать проект
      </button>
    </form>
  </div>
</div>



    <div class="space-y-4">
      <h2 class="text-2xl font-semibold">Мои проекты</h2>
      <div class="grid gap-4 md:grid-cols-2">
        @foreach($projects as $p)
        <a href="{{route('my.project', $p->id)}}"
          class="rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-lg transition-shadow cursor-pointer"
        >
          <div class="flex flex-col space-y-1.5 p-6">
            <div class="flex items-start gap-3">
              <div class="p-2 bg-primary/10 rounded-lg">
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
                  class="lucide lucide-folder w-5 h-5 text-primary"
                >
                  <path
                    d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"
                  ></path>
                </svg>
              </div>
              <div class="flex-1">
                <h3 class="font-semibold tracking-tight text-xl">{{$p->name}}</h3>
                <p class="text-sm text-muted-foreground mt-1">{{$p->description}}</p>
              </div>
            </div>
          </div>
          {{--<div class="p-6 pt-0">
            <div class="flex items-center gap-2 text-sm text-muted-foreground">
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
                class="lucide lucide-trending-up w-4 h-4">
                <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                <polyline points="16 7 22 7 22 13"></polyline></svg><span>8 ключевых фраз</span>
            </div>
          </div>--}}
        </a>
        @endForeach
      </div>
    </div>
  </div>
</main>



</x-layout>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    let btn = document.querySelector('#add_project')
    btn.addEventListener('click', function() {
      document.querySelector('#add_project_block').style.display = 'block'
    })

  })
</script>