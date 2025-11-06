<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight dark:[text-64px]">
          {{ __('Админы') . " (" . count($items) . ")" }}
          <a href="{{route('admin.user.create')}}"><x-bladewind.button class="ml-4" size="small">Добавить</x-bladewind.button></a>
      </h2>
      <p class="mt-4 text-slate-300"></p>
  </x-slot>

  <x-bladewind.card title="Юзеры" class="max-w-7xl max-w-[1440px] mx-auto mt-8 !bg-slate-900/50 !border-slate-700/50 !shadow-slate-900/80">

    <div class="overflow-x-auto deleteables">
    <x-bladewind.table>
      <x-slot name="header">
          <th>ID</th>
          <th>name</th>
          <th>email</th>
          <th>создан</th>
          <th>Действия</th>
      </x-slot>
      @foreach($items as $i)
      <tr>
          <td>{{$i->id}}</td>
          <td>{{$i->name}}</td>
          <td>
            {{$i->email}}
          </td>
          

          <td>{{date('d M H:i', strtotime($i->created_at))}}</td>

          <td class="text-center">

            @if($i->id !== 1)
              <div class="flex gap-2">
              <form class="mb-2" method="post" action="{{route('admin.user.regen',$i->id)}}">
                @csrf
                @method('patch')
              <x-bladewind::button.circle outline="true" icon="lock-closed" title="Перегенерировать пароль" onclick="(function() {
                if(!confirm('Перегенерировать пароль?')) event.preventDefault();
              })();" />
              </form>
              <form class="mb-2" method="post" action="{{route('admin.user.destroy',$i->id)}}">
                @csrf
                @method('delete')
                <x-bladewind::button.circle outline="true" icon="trash" color="red" size="small" can_submit="true" class="mx-auto block"
                onclick="(function() {
                  if(!confirm('Удалить этого пользователя?')) event.preventDefault();
                })();"
                />
              </form>
              </div>
            @endif

            

          </td>
      </tr>
      @endForeach
    </x-bladewind.table>
    </div>
  </x-bladewind.card>


</x-app-layout>

<style>
  a.active {
    opacity: .5;
    filter: invert(1);
  }
</style>

<script>
  let deleteablesButtons = document.querySelectorAll('.deleteables button[type="button"]')
  deleteablesButtons.forEach((btn, idx) => {
    deleteablesButtons[idx].setAttribute('type', 'submit')
  })
</script>
