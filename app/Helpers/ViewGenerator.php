<?php

namespace App\Helpers;

class ViewGenerator {


  public static function generateView($resource) {
    $contents = '';
    $model = ucfirst($resource);
    $resource = lcfirst($resource);
  
    // create
    $contents = "<x-app-layout>
  <x-slot name=\"header\">
      <h2 class=\"font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight\">
          {{ __('Добавить $resource') }} <x-btn-link route=\"{{route('admin.$resource.index')}}\" class=\"ml-4\">{{ __('Назад') }}</x-btn-link>
      </h2>
  </x-slot>

  <div class=\"py-12 text-slate-400\">
      <div class=\"max-w-7xl mx-auto sm:px-6 lg:px-8\">
          <div class=\"p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg\">
            <x-admin.form :fields=\"\$fields\" :route=\"route('admin.$resource.store')\" /> 
          </div>
      </div>
  </div>
</x-app-layout>
";
    //$contents = str_replace('resource', $resource, $contents);
    
    $basePath = base_path() . '/resources/views/admin/' . $resource;
    if(!file_exists($basePath)) mkdir($basePath); 
    file_put_contents($basePath . '/create.blade.php', $contents);

    // edit
    $contents = "<x-app-layout>
  <x-slot name=\"header\">
      <h2 class=\"font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight\">
          {{ __('Редактировать $resource # ' . \$item->name) }} <x-btn-link route=\"{{route('admin.$resource.index')}}\" class=\"ml-4\">{{ __('Назад') }}</x-btn-link>
      </h2>
  </x-slot>

  <div class=\"py-12 text-slate-400\">
      <div class=\"max-w-7xl mx-auto sm:px-6 lg:px-8\">
          <div class=\"p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg\">
            <x-admin.form :fields=\"\$fields\" :item=\"\$item\" method=\"patch\" :route=\"route('admin.$resource.update', \$item)\" /> 
          </div>
      </div>
  </div>
</x-app-layout>
";

    $contents = str_replace('$item', "$" . "$resource", $contents);
    file_put_contents($basePath . '/edit.blade.php', $contents);

    // index
    $contents = "<x-app-layout>
  <x-slot name=\"header\">
      <h2 class=\"font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight dark:[text-64px]\">
          {{ __('$model') }}
          <a href=\"{{route('admin.$resource.create')}}\"><x-bladewind.button class=\"ml-4\" size=\"small\">Добавить</x-bladewind.button></a>
      </h2>
  </x-slot>

  <x-bladewind.card title=\"$model\" class=\"max-w-7xl mx-auto mt-8 !bg-slate-900/50 !border-slate-700/50 !shadow-slate-900/80\">
    <div class=\"overflow-x-auto\">
    <x-bladewind.table>
      <x-slot name=\"header\">
          <th>#</th>
          <th>Название</th>
          <th>URL</th>
          <th></th>
      </x-slot>
      @foreach(\$items as \$i)
      <tr>
          <td>{{\$i->id}}</td>
          <td>{{\$i->name}}</td>
          <td>{{\$i->url}}</td>
          
          <td><a href=\"{{route('admin.$resource.edit', \$i->id)}}\">
            <x-bladewind.button.circle outline=\"true\" icon=\"pencil-square\" size=\"tiny\" /></a>
          </td>
      </tr>
      @endForeach
    </x-bladewind.table>
    </div>
  </x-bladewind.card>

</x-app-layout>
";

    file_put_contents($basePath . '/index.blade.php', $contents);
  
  }

}

