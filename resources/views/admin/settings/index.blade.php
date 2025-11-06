<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __('Настройки') }}
      </h2>
      <p class="mt-4 text-slate-300">Настройки сайта</p>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900 dark:text-gray-100 submitable">
                  {{-- __("You're logged in!") --}}
                  <p>

                    Окружение: {{$env}}
                    <div class="my-2 text-slate-300">
                      Локально нужно вручную рестартануть сервер, чтобы новое окружение применилось
                    </div>
                    @if($env === 'local')
                      <form class="mb-2" method="post" action="{{route('admin.settings.setEnv', ['env' => 'production'])}}">
                        @csrf
                        <x-bladewind::button icon="command-line" color="blue" size="small" can_submit="true" class="my-2" onclick="(function() {
                          if(!confirm('Действительно переключить переменную окружения?')) event.preventDefault();
                        })();"
                        >Переключить на production</x-bladewind::button>
                      </form>
                    @else
                    <form class="mb-2" method="post" action="{{route('admin.settings.setEnv', ['env' => 'local'])}}">
                      @csrf
                      <x-bladewind::button icon="command-line" color="blue" size="small" can_submit="true" class="my-2" onclick="(function() {
                        if(!confirm('Действительно переключить переменную окружения?')) event.preventDefault();
                      })();"
                      >Переключить на local</x-bladewind::button>
                    </form>
                    @endif
                    <svg style="display:inline-block"  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-brand-php"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-10 0a10 9 0 1 0 20 0a10 9 0 1 0 -20 0" /><path d="M5.5 15l.395 -1.974l.605 -3.026h1.32a1 1 0 0 1 .986 1.164l-.167 1a1 1 0 0 1 -.986 .836h-1.653" /><path d="M15.5 15l.395 -1.974l.605 -3.026h1.32a1 1 0 0 1 .986 1.164l-.167 1a1 1 0 0 1 -.986 .836h-1.653" /><path d="M12 7.5l-1 5.5" /><path d="M11.6 10h2.4l-.5 3" /></svg> Версия PHP: {{$phpVer}} <br>
                    <svg style="display:inline-block"  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-brand-laravel"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l8 5l7 -4v-8l-4 -2.5l4 -2.5l4 2.5v4l-11 6.5l-4 -2.5v-7.5l-4 -2.5z" /><path d="M11 18v4" /><path d="M7 15.5l7 -4" /><path d="M14 7.5v4" /><path d="M14 11.5l4 2.5" /><path d="M11 13v-7.5l-4 -2.5l-4 2.5" /><path d="M7 8l4 -2.5" /><path d="M18 10l4 -2.5" /></svg> Версия Laravel: {{$laraVer}} <br>
                    <svg style="display:inline-block"  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-network"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9a6 6 0 1 0 12 0a6 6 0 0 0 -12 0" /><path d="M12 3c1.333 .333 2 2.333 2 6s-.667 5.667 -2 6" /><path d="M12 3c-1.333 .333 -2 2.333 -2 6s.667 5.667 2 6" /><path d="M6 9h12" /><path d="M3 20h7" /><path d="M14 20h7" /><path d="M10 20a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M12 15v3" /></svg> IP адрес: {{request()->ip()}} <br>

                  </p>

                  <h2>Внутренний кэш Laravel</h2>
                    <div>
                      @if($innerCacheStatus['routes']) кэш маршрутов: <span class="badge badge-success right">да</span>,
                      @else кэш маршрутов: <span class="badge badge-info right">нет</span>,
                      @endif
                      @if($innerCacheStatus['config']) кэш конфигурации: <span class="badge badge-success right">да</span>,
                      @else кэш конфигурации: <span class="badge badge-info right">нет</span>,
                      @endif
                      @if($innerCacheStatus['events']) кэш событий: <span class="badge badge-success right">да</span>
                      @else кэш событий: <span class="badge badge-info right">нет</span>
                      @endif
                    </div>

                    <div class="flex my-2 gap-2">
                  <form class="mb-2" method="post" action="{{route('admin.settings.cacheAll')}}">
                    @csrf
                    <x-bladewind::button icon="circle-stack" color="yellow" size="small" can_submit="true" class="mx-auto block"
                    onclick="(function() {
                      if(!confirm('Закэшировать внутренние данные Laravel? (включая конфиг и т.д.)')) event.preventDefault();
                    })();"
                    >Закэшировать внутрянку Laravel </x-bladewind::button>
                  </form>
                  <form class="mb-2" method="post" action="{{route('admin.settings.uncacheAll')}}">
                    @csrf
                    <x-bladewind::button icon="circle-stack" color="red" size="small" can_submit="true" class="mx-auto block"
                    onclick="(function() {
                      if(!confirm('Раскэшировать внутренние данные Laravel?')) event.preventDefault();
                    })();"
                    >Раскэшировать внутрянку Laravel </x-bladewind::button>
                  </form>

                  <form class="mb-2" method="post" action="{{route('admin.settings.cache.reset')}}">
                    @csrf
                    <x-bladewind::button icon="circle-stack" color="blue" size="small" can_submit="true" class="mx-auto block"
                    >Очистить кэш сайта</x-bladewind::button>
                  </form>
                    </div>

                    

                  <div class="flex gap-2">
                  {{--<x-bladewind::statistic number="{{$stats['today']}}" label="Отправлено постов сегодня">
                    <x-slot name="icon"><x-bladewind::icon name="paper-airplane" class="!h-14 !w-14 !text-white bg-green-500 p-4 rounded-full" /></x-slot>
                  </x-bladewind::statistic>--}}

                </div>
              </div>
          </div>
      </div>
  </div>


</x-app-layout>

<script>
  let deleteablesButtons = document.querySelectorAll('.submitable button[type="button"]')
  deleteablesButtons.forEach((btn, idx) => {
    deleteablesButtons[idx].setAttribute('type', 'submit')
  })
</script>
