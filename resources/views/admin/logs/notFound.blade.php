<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight dark:[text-64px]">
          {{ __('Лог 404 ошибок') }}
      </h2>
  </x-slot>

  <x-bladewind.card title="Лог 404 ошибок" class="max-w-7xl mx-auto mt-8 !bg-slate-900/50 !border-slate-700/50 !shadow-slate-900/80">
    <div class="overflow-x-auto">
    <x-bladewind.table>
      <x-slot name="header">
          <th>#</th>
          <th>Название</th>
          <th>URL</th>
          <th>Date</th>
      </x-slot>
      @foreach($items as $i)
      <tr>
          <td>{{$loop->iteration}}</td>
          <td>{{$i->path}}</td>
          <td>{{$i->ip}}</td>
          <td>{{$i->created_at}}</td>
      </tr>
      @endForeach
    </x-bladewind.table>
    </div>
    {{$items->links()}}
  </x-bladewind.card>

</x-app-layout>
