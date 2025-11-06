@props(['field', 'item' => null])

@if($field['type'] === 'summernote')
  <textarea id="summernote_{{$field['key']}}" name="{{$field['key']}}" placeholder="{{$field['title']}}"  
    @required($field['required'])>{!!$item ? $item[$field['key']] : old($field['key'])!!}</textarea>
@elseif($field['type'] === 'codemirror')
<div id="codemirror_{{$field['key']}}"></div>
{{--<textarea id="codemirror_{{$field['key']}}" name="{{$field['key']}}"></textarea>--}}
{{--<x-slbc::textarea-codemirror mode="html">
    <textarea name="{{$field['key']}}">{{$item ? $item[$field['key']] : old($field['key'])}}</textarea>
</x-slbc::textarea-codemirror>--}}
@elseif($field['type'] === 'vscode')
  {{--<textarea id="vscode_{{$field['key']}}" name="{{$field['key']}}"></textarea>--}}
  <div id="vscode_{{$field['key']}}" data-value="{{$item ? $item[$field['key']] : old($field['key'])}}" style="height:300px;"></div>

@elseif($field['type'] === 'textarea' || $field['type'] === 'markdown')
  @if(isset($field['hint'])) <small class="inline-block">{{$field['hint']}}</small> @endif
  <textarea class="w-full p-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
  id="{{$field['key']}}" name="{{$field['key']}}" placeholder="{{$field['title']}}"  rows="5"
    @required($field['required'])>{!!$item ? $item[$field['key']] : old($field['key'])!!}</textarea>
{{--@elseif($field['type'] === 'summernote')
    <textarea id="summernote" class="w-full p-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
    id="{{$field['key']}}" name="{{$field['key']}}" placeholder="{{$field['title']}}"  rows="5"
      @required($field['required'])>{!!$item ? $item[$field['key']] : old($field['key'])!!}</textarea>--}}
@elseif($field['type'] === 'select_multiple')
<select class="form-control" name="{{$field['key']}}[]" id="{{$field['key']}}" @required($field['required']) multiple>
  @foreach ($field['items'] as $i)
  <option value="{{$i->id}}" 
    @selected($item ? in_array($i->id, $item[$field['rel_key']]->pluck('id')->toArray()) : isset($field['default']) && $field['default'] == $i->id )
  >{{$i->name}}</option>
  @endforeach
</select>
@elseif($field['type'] === 'options_list')
<div id="options_list">

  @if(!isset($item))
  @foreach(range(1, 3) as $idx)
  <div class="options_list">
  <input class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
  type="text"  placeholder="{{$field['title']}}" name="{{$field['key']}}[]">
  </div>
  @endForeach
  @else
  @foreach($item[$field['rel']] as $opt)
  <div class="options_list">
    <input class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
    type="text" placeholder="{{$field['title']}}" name="{{$field['key']}}[]" value="{{$opt->option}}">
    </div>
  @endForeach
  @endif
  </div>
  <x-bladewind.button.circle id="add_input" icon="plus-circle" size="small" onclick="
    let option = document.querySelector('.options_list')
    document.querySelector('#options_list').insertAdjacentHTML('beforeend', option.outerHTML)
  " />
@elseif($field['type'] === 'bladewind_select')
<x-bladewind.select name="{{$field['key']}}" searchable="true"
  label_key="{{isset($field['label_key']) ? $field['label_key'] : 'name'}}" value_key="{{isset($field['value_key']) ? $field['value_key'] : 'id'}}" 
  multiple="true" max_selectable="10" :data="$field['items']" selected_value="{{request()->input($field['key'])}}" />
@elseif($field['type'] === 'bladewind_sel')
<x-bladewind.select name="{{$field['key']}}" searchable="true" label_key="{{isset($field['label_key']) ? $field['label_key'] : 'name'}}" value_key="{{isset($field['value_key']) ? $field['value_key'] : 'id'}}"  :data="$field['items']" 
  selected_value="{{isset($item) ? $item[$field['key']] : request()->input($field['key'])}}" />
@elseif($field['type'] === 'select')
<select class="form-control" name="{{$field['key']}}" id="{{$field['key']}}" @required($field['required'])>
  @foreach ($field['items'] as $i)
  <option value="{{$i->id}}" @selected($item ? $item[$field['key']] === $i->id : false)>{{$i->city}}</option>
  @endforeach
</select>
@elseif($field['type'] === 'file')
<x-bladewind::filepicker
name="{{$field['key']}}"
required="{{$field['required']}}"
placeholder="{{$field['title']}}"  />
@elseif($field['type'] === 'file_multiple')
@if(isset($field['hint'])) <small class="inline-block">{{$field['hint']}}</small> @endif
<input class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
type="file" id="{{$field['key']}}"  placeholder="{{$field['title']}}" name="{{$field['key']}}" 
    value="{{$item ? $item[$field['key']] : old($field['key'])}}"
    @required($field['required']) multiple
>
@elseif($field['type'] === 'multiple')
@if(isset($field['hint'])) <small class="inline-block">{{$field['hint']}}</small> @endif
<input class="multiple_inp w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
type="text" id="{{$field['key']}}"  placeholder="{{$field['title']}}" name="{{$field['key']}}[]" 
    value="{{$item ? $item[$field['key']] : old($field['key'])}}"
    @required($field['required']) multiple
>
<x-bladewind.button.circle outline="true" icon="plus" id="add_input" size="tiny"  onclick="(function() {
  let form = document.querySelector('.app_form')
  let input = document.querySelector('.multiple_inp')
  //console.log(form, input.outerHTML)
  form.insertAdjacentHTML('beforeend', input.outerHTML)
})()" /></a>
@elseif($field['type'] === 'seo_title')
<x-admin.seo-title name="{{$field['key']}}" label="{{$field['title']}}" value="{{$item ? $item[$field['key']] : old($field['key'])}}" />
@elseif($field['type'] === 'seo_desc')
<x-admin.seo-desc name="{{$field['key']}}" label="{{$field['title']}}" value="{{$item ? $item[$field['key']] : old($field['key'])}}" />
@else
@if(isset($field['hint'])) <small class="inline-block">{{$field['hint']}}</small> @endif
<input class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
type="{{$field['type']}}" id="{{$field['key']}}"  placeholder="{{$field['title']}}" name="{{$field['key']}}" 
    value="{{$item ? $item[$field['key']] : old($field['key'])}}"
    @required($field['required'])
>
@if($field['type'] === 'file' && $item) <img src="{{asset($field['path'].$item[$field['key']])}}" style="height: 150px; width: 150px; object-fit: contain">
@endif
@endif