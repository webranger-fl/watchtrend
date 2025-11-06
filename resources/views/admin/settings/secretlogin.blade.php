<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __('URL страницы входа') }}
      </h2>
      <p class="mt-4 text-slate-300">Настройка URL страницы входа. Работает только в режиме production</p>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900 dark:text-gray-100 submitable">

                <form class="app_form" action="{{route('admin.settings.loginPatch')}}" method="POST">
                  @csrf  
                  @method('patch')

                  <div class="card-body">
                     <div class="form-group mb-4">
                           <label for="resource_name" class="block mb-2">URL</label>
                            {{--<small class="inline-block">с маленькой буквы</small> --}}
                     
                     <input class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" 
                     type="text" id="url" placeholder="URL" name="url" value="{{$loginUrl}}">
                         </div>
                 
               <!-- /.card-body -->
               
               <div class="card-footer">
                  <button type="submit" class="mt-4 btn btn-primary inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Сохранить</button>
                 </div>
         
                         </div></form>
              </div>
          </div>
      </div>
  </div>


</x-app-layout>


