<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight dark:[text-64px]">
          {{ __('Активные сессии') }}
      </h2>
      <p class="mt-4 text-slate-300">Здесь вы можете просматривать свои активные сессии, деактивировать сеансы</p>
  </x-slot>

  <div class="flex gap-8 px-20 max-w-[1440px] mx-auto submitables">
  @foreach($sessions as $session)
  <x-bladewind.card title="IP: {{$session->ip_address}}" class="{{--max-w-7xl max-w-[1440px]--}} mx-auto mt-8 !bg-slate-900/50 !border-slate-700/50 !shadow-slate-900/80">
    <div class="flex gap-4">
    <x-bladewind::icon name="user-circle" class="text-slate-300 !w-16 !h-16" />
    <div>
    @if($session->id === $activeSessionId) <span class="text-green-500">Текущий сеанс</span> <br> @endif
    {{--IP: {{$session->ip_address}} <br>--}}
    <p class="mt-4 text-slate-300">
    Юзер агент: {{$session->user_agent}} <br>
    Последняя активность: {{date('d M Y H:i:s', $session->last_activity)}} <br>
    </p>
    @if($session->id !== $activeSessionId)
      <form class="mb-2" method="post" action="{{route('profile.destroySession',$session->id)}}">
        @csrf
        @method('delete')
        <x-bladewind::button.circle outline="true" icon="eye-slash" color="yellow" size="small" can_submit="true" class="mx-auto block"
        onclick="(function() {
          if(!confirm('Деактивировать этот сеанс?')) event.preventDefault();
        })();"
        />
      </form>
    @endif
    </div>
  </div>
    
  </x-bladewind.card>
  @endForeach
</div>


</x-app-layout>

<script>
  let submitables = document.querySelectorAll('.submitables button[type="button"]')
  submitables.forEach((btn, idx) => {
    submitables[idx].setAttribute('type', 'submit')
  })
</script>



