<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight dark:[text-64px]">
          {{ __('Посты') }}
          <a href="{{route('admin.blog.create')}}"><x-bladewind.button class="ml-4" size="small">Добавить</x-bladewind.button></a>
      </h2>
  </x-slot>

  <x-bladewind.card title="Посты" class="max-w-7xl mx-auto mt-8 !bg-slate-900/50 !border-slate-700/50 !shadow-slate-900/80">
    <div class="overflow-x-auto">
    <x-bladewind.table>
      <x-slot name="header">
          <th>#</th>
          <th>Название</th>
          <th>URL</th>
          <th>Контент</th>
          <th>Инфо</th>
          <th></th>
      </x-slot>
      @foreach($items as $i)
      <tr>
          <td>{{$i->id}}</td>
          <td>{{$i->title}}
            {{--@if($i->thumb) <img width="200" src="/img/blog/{{$i->thumb}}" alt=""> @endif--}}
          </td>
          <td>{{$i->slug}}</td>
          <td>{{mb_strlen(strip_tags($i->content))}}</td>
          <td>
            Категория: {{$i->category->name}} <br>
            Активен: {{$i->active ? 'Да' : 'Нет' }}
          </td>
          
          <td><a href="{{route('admin.blog.edit', $i->id)}}">
            <x-bladewind.button.circle outline="true" icon="pencil-square" size="tiny" /></a>
            {{--<a href="/{{$i->url}}"><x-bladewind.button.circle outline="true" icon="eye" size="tiny" /></a>--}}
          </td>
      </tr>
      @endForeach
    </x-bladewind.table>
    </div>
  </x-bladewind.card>


</x-app-layout>
