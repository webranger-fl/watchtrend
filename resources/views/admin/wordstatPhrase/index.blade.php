<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight dark:[text-64px]">
          {{ __('WordstatPhrase') }}
          <a href="{{route('admin.wordstatPhrase.create')}}"><x-bladewind.button class="ml-4" size="small">Добавить</x-bladewind.button></a>
      </h2>
  </x-slot>

  <x-bladewind.card title="WordstatPhrase" class="max-w-7xl mx-auto mt-8 !bg-slate-900/50 !border-slate-700/50 !shadow-slate-900/80">
    <div class="overflow-x-auto submitable">
    <x-bladewind.table>
      <x-slot name="header">
          <th>#</th>
          <th>Фраза</th>
          <th></th>
      </x-slot>
      @foreach($items as $i)
      <tr>
          <td>{{$i->id}}</td>
          <td>{{$i->phrase}}</td>
          
          <td><a href="{{route('admin.wordstatPhrase.edit', $i->id)}}">
            <x-bladewind.button.circle outline="true" icon="pencil-square" size="tiny" /></a>

            <a href="{{route('admin.wordstatPhrase.show', $i->id)}}">
            <x-bladewind.button.circle outline="true" icon="eye" color="green" size="tiny" /></a>

            @if(!$i->desktop)
              <form class="inline-block mb-2" method="post" action="{{route('admin.wordstatPhrase.getDevicesData',$i->id)}}">
                @csrf
                @method('patch')
                <x-bladewind::button.circle icon="calculator" color="yellow" size="tiny" outline="true" can_submit="true" type="submit" class="mx-auto block"
                onclick="(function() {
                  if(!confirm('Собрать данные по устройствам для ключа?')) event.preventDefault();
                })();"/>
              </form>
            @endif

            <form class="inline-block mb-2" method="post" action="{{route('admin.wordstatPhrase.destroy',$i->id)}}">
                @csrf
                @method('delete')
                <x-bladewind::button.circle icon="trash" color="red" size="tiny" outline="true" can_submit="true" type="submit" class="mx-auto block"
                onclick="(function() {
                  if(!confirm('Удалить данные по ключу?')) event.preventDefault();
                })();"/>
              </form>

          </td>
      </tr>
      @endForeach
    </x-bladewind.table>
    </div>
  </x-bladewind.card>

</x-app-layout>

<script>
  let submitables = document.querySelectorAll('.submitable button[type="button"]')
  submitables.forEach((btn, idx) => {
    submitables[idx].setAttribute('type', 'submit')
  })
</script>
