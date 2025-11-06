<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __("Редактировать файл $filePath") }}
      </h2>
      <p class="my-2 text-slate-400">
        @if($fileName === 'env') Кажется в этом нет большого смысла так как после 1 правки env слетает авторизация. А если править через VS Code то не слетает @endif
      </p>
  </x-slot>

  <div class="py-12 text-slate-400">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            {{--<x-admin.form :fields="$fields" btnName="Сохранить" :item="$code" :route="route('admin.code.update')" /> --}}
            <form class="app_form" action="{{route('admin.settings.patchFile', ['file' => $fileName])}}" method="POST">
              @csrf  
              @method('patch')

              <div class="card-body">
                 <div class="form-group mb-4">
                       {{--<label for="resource_name" class="block mb-2">URL</label>--}}
                       <div id="vscode_body" data-value="{{$file}}" style="height:600px;"></div>
                 
                 
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
</x-app-layout>


<link rel="stylesheet" data-name="vs/editor/editor.main" href="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.20.0/min/vs/editor/editor.main.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.26.1/min/vs/loader.min.js"></script>

<script>
  // https://stackoverflow.com/questions/63179813/how-to-run-the-monaco-editor-from-a-cdn-like-cdnjs
  // require is provided by loader.min.js.
  require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.26.1/min/vs' }});
  require(["vs/editor/editor.main"], () => {

    //console.log(monaco.languages.getLanguages())
    let bodyEditor = monaco.editor.create(document.getElementById('vscode_body'), {
      value: document.getElementById('vscode_body').dataset.value,
      // ближе всего, для env как в vs code я не нашел языка
      language: 'dockerfile',
      theme: 'vs-dark',
    });

    let form = document.querySelector('.app_form')
    form.addEventListener('submit', e => {
      e.preventDefault()
      let bodyCode = bodyEditor.getValue()
      fetch(`/admin/settings/patchFile/{{$fileName}}`, {
        method: "post",
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{csrf_token()}}'
        },
        //make sure to serialize your JSON body
        body: JSON.stringify({ body: bodyCode })
      })
      .then( (response) => {
        //do something awesome that makes the world a better place
        let notifBar = document.querySelector('.admin_notification')
        notifBar.textContent = 'Файл сохранен'
        notifBar.classList.add('py-4')
        notifBar.style.display = 'block'
          setTimeout(() => {
            notifBar.style.display = 'none'
          }, 3000)
      });
      
    });
  })

  

  </script>
