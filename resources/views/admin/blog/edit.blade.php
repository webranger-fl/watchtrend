<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __('Редактировать пост # ' . $blog->id) }} <x-btn-link route="{{route('admin.blog.index')}}" class="ml-4">{{ __('Назад') }}</x-btn-link>
      </h2>
  </x-slot>

  <div class="py-12 text-slate-400">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <x-admin.form :fields="$fields" :item="$blog" method="patch" :route="route('admin.blog.update', $blog)" /> 
          </div>
      </div>
  </div>
</x-app-layout>
