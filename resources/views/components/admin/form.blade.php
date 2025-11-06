@props(['fields', 'route', 'method' => 'post', 'item' => null, 'btnName' => ''])

<form class="app_form" action="{{$route}}" method="{{$method === 'GET' ? 'GET' : 'POST'}}" @if(searchForType('file', $fields) !== null) enctype="multipart/form-data" @endif>
  @if($method !== 'GET') @csrf @endif
  @if($method !== 'POST' && $method !== 'GET') @method($method) @endif
<div class="card-body">
  @foreach($fields as $field)
    <div class="form-group mb-4">
      @if($field['type'] !== 'checkbox')
      <label for="{{$field['key']}}" @class(['block mb-2', 'switch' => $field['type'] === 'checkbox'])>{{$field['title']}}</label>
      <x-admin.input :field="$field" :item="$item" />
      @else
      {{--value="{{$item ? $item[$field['key']] == true : true}}"--}}
      <x-admin.switch value="{{resolveSwitchValue($item, $field)}}" name="{{$field['key']}}" caption="{{$field['title']}}" />
      @endif
    </div>
  @endForeach

<!-- /.card-body -->

<div class="card-footer">
  @if($btnName)
    <x-bladewind::button
    can_submit="true" icon="check-circle"
    >{{$btnName}}</x-bladewind::button>
  @elseif($method === 'GET') <button type="submit" class="mt-4 btn btn-primary inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Поиск</button>

  @else <button type="submit" class="mt-4 btn btn-primary inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">{{$method === 'post' ? 'Добавить' : 'Изменить'}}</button>
  @endif
</div>
</form>

@if(searchForType('select_multiple', $fields))
@push('customScripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const options = { itemSelectText: '', shouldSort: false }
    //const choices = new Choices(document.querySelector('#categories_ids'), options);
    new Choices(document.querySelector('#tags_ids'), options);
  })
  </script>
  <style>
    .choices__inner,.choices__list--dropdown .choices__item--selectable.is-highlighted, .choices__list[aria-expanded] .choices__item--selectable.is-highlighted
    {    background-color: rgb(30 41 59);}
    .choices__list--dropdown .choices__list, .choices__list[aria-expanded] .choices__list {
      max-height: 600px;
    }
  </style>
@endPush
@endif

@if(searchForType('summernote', $fields) !== null)
{{--@push('customScripts')--}}
<!-- include libraries(jQuery, bootstrap) -->
{{--<link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>--}}

{{-- bootstrap 4 --}}
{{--<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>--}}

{{-- bootstrap 5 --}}
{{--<!-- include libraries(jQuery, bootstrap) -->
<script type="text/javascript" src="//code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
<script type="text/javascript" src="cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- include summernote css/js-->
<link href="summernote-bs5.css" rel="stylesheet">
<script src="summernote-bs5.js"></script> --}}

{{-- summernote light without bootsrap --}}
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
  $(document).ready(function() {
    $('#summernote_content').summernote({
      followingToolbar: true,
      toolbar: [
        // [groupName, [list of button]]
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough']],
        ['view', ['fullscreen', 'codeview', 'help']]
      ]
    });
    $('#summernote_text').summernote({
      followingToolbar: true,
      /*toolbar: [
        // [groupName, [list of button]]
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough']],
        ['view', ['fullscreen', 'codeview', 'help']]
      ]*/
    });
});
</script>
<style>
  .note-frame {
    color: #ddd!important;
  }
</style>
{{--@endPush--}}
@endif

@if(searchForType('markdown', $fields) !== null)
{{-- https://github.com/sparksuite/simplemde-markdown-editor --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<script>
  var simplemde = new SimpleMDE({ 
    blockStyles: {
		bold: "*",
		italic: "_"
	  },
    element: document.getElementById("text") 
  });
  //simplemde.value("This text will appear in the editor");
  </script>
@endif

@if(searchForType('vscode', $fields) !== null)
<link rel="stylesheet" data-name="vs/editor/editor.main" href="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.20.0/min/vs/editor/editor.main.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.26.1/min/vs/loader.min.js"></script>

<script>
  // https://stackoverflow.com/questions/63179813/how-to-run-the-monaco-editor-from-a-cdn-like-cdnjs
  // require is provided by loader.min.js.
  require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.26.1/min/vs' }});
  require(["vs/editor/editor.main"], () => {
    let headEditor = monaco.editor.create(document.getElementById('vscode_head'), {
      /*value: `function x() {
        console.log("Hello world!");
      }`,*/
      value: document.getElementById('vscode_head').dataset.value,
      //language: 'javascript',
      language: 'html',
      theme: 'vs-dark',
      /*onDidChangeContent: ((event) => {
        console.log('onDidChangeContent')
      })*/
    });
    headEditor.onDidChangeModelContent(function (e) {
      //console.log('onDidChangeModelContent')
      //console.log(headEditor.getValue())
      let value = headEditor.getValue()
    });

    let bodyEditor = monaco.editor.create(document.getElementById('vscode_body'), {
      value: document.getElementById('vscode_body').dataset.value,
      language: 'html',
      theme: 'vs-dark',
    });

    let form = document.querySelector('.app_form')
    form.addEventListener('submit', e => {
      e.preventDefault()
      //console.log('prevent submit')
      let headCode = headEditor.getValue()
      let bodyCode = bodyEditor.getValue()
      //console.log(headCode, bodyCode)
      // остаётся сделать ajax запрос и вывести плашку что код сохранен
      fetch(`/admin/code`, {
        method: "post",
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{csrf_token()}}'
        },
        //make sure to serialize your JSON body
        body: JSON.stringify({ head: headCode, body: bodyCode })
      })
      .then( (response) => {
        //do something awesome that makes the world a better place
        let notifBar = document.querySelector('.admin_notification')
        notifBar.textContent = 'Код сохранен'
        notifBar.classList.add('py-4')
        notifBar.style.display = 'block'
          setTimeout(() => {
            notifBar.style.display = 'none'
          }, 3000)
      });
      
    });
  })

  

  </script>
@endif

@if(searchForType('codemirror', $fields) !== null)
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/codemirror@5.65.0/lib/codemirror.css">
<script src="https://cdn.jsdelivr.net/npm/codemirror@5.65.0/lib/codemirror.js"></script>
<script src="https://cdn.jsdelivr.net/npm/codemirror@5.65.0/mode/xml/xml.js"></script> <!-- Подходит для HTML и других языков программирования -->

<script>
  CodeMirror(document.getElementById('codemirror_head'), {
    mode: 'html', // Подстройте параметр под свой язык программирования: 'javascript', 'css' и т.д.
    lineNumbers: true, // Включение отображения номеров строк
    theme: 'argonaut' // Выбор темы оформления редактора
  });
</script>

<style>
  .cm-s-argonaut {
	font-size: 1em;
	line-height: 1.5em;
	font-family: inconsolata, monospace;
	letter-spacing: 0.3px;
	word-spacing: 1px;
	background: #151515;
	color: #B2B2B2;
}
.cm-s-argonaut .CodeMirror-lines {
	padding: 8px 0;
}
.cm-s-argonaut .CodeMirror-gutters {
	box-shadow: 1px 0 2px 0 rgba(0, 0, 0, 0.5);
	-webkit-box-shadow: 1px 0 2px 0 rgba(0, 0, 0, 0.5);
	background-color: #151515;
	padding-right: 10px;
	z-index: 3;
	border: none;
}
.cm-s-argonaut div.CodeMirror-cursor {
	border-left: 3px solid #B2B2B2;
}
.cm-s-argonaut .CodeMirror-activeline-background {
	background: #000C16;
}
.cm-s-argonaut .CodeMirror-selected {
	background: #002F53;
}
.cm-s-argonaut .cm-comment {
	font-style: italic;
	color: #00A6FF;
}
.cm-s-argonaut .cm-string {
	color: #6497C5;
}
.cm-s-argonaut .cm-number {
	color: #815DB3;
}
.cm-s-argonaut .cm-variable {
	color: #FFCA00;
}
.cm-s-argonaut .cm-def {
	font-style: italic;
}
.cm-s-argonaut .cm-property {
	color: #815DB3;
}
.cm-s-argonaut .cm-variable-2 {
	color: #0065D3;
}
.cm-s-argonaut .cm-atom {
	color: #815DB3;
}
.cm-s-argonaut .cm-keyword {
	color: null;
}
.cm-s-argonaut .cm-operator {
	color: null;
}
.cm-s-argonaut .CodeMirror-linenumber {
	color: italic;
}
</style>
@endif