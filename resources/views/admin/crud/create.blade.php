<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __('Добавить CRUD') }}
      </h2>
      <p class="my-2 text-slate-400">Нужно сделать вручную: 1) регистрацию роутов 2) модель и миграцию. Этот CRUD генератор сгенерирует контроллер и папку с видами.
        В контроллер нужно будет вписать массив полей для формы. <br>
        Дополнительно можно выполнить команду <code>php at make:model -m Model</code> для автоматического создания
        модели и миграции, если поставить галочку
      </p>
  </x-slot>

  <div class="py-12 text-slate-400">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <x-admin.form :fields="$fields" :route="route('admin.crud.store')" /> 
          </div>
      </div>
  </div>
</x-app-layout>
