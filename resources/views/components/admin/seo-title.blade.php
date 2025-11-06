@props(['name', 'label', 'value' => null])

<div class="status_circle_{{$name}}" style="display:inline-block;background:green;width:10px;height:10px;border-radius:50%"></div> 
    {{$label}} <span style="    font-size: 12px;
    color: gray;
    margin-left: 10px;" id="{{$name}}_counter"></span></label>
  <div style="color: gray;font-size: 14px;" class="status_{{$name}}"></div>
  <input class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
type="text" id="{{$name}}"  placeholder="{{$label}}" name="{{$name}}" 
    value="{{$value}}" {{ $attributes }}
>

<script>
  (function(){
  let name = "{{$name}}"
  let status = document.querySelector(`.status_${name}`)

  function checkStatus(len, elem) {
    if(len >= 45 && len <= 65) {
      elem.style.background = 'green'
      status.textContent = ''
    }
    else if(len > 65) {
      elem.style.background = 'orange'
      status.textContent = 'Оптимальная длина seo заголовка - 45-65 символов'
    }
    else if(len >= 30) {
      elem.style.background = 'orange'
      status.textContent = 'Оптимальная длина seo заголовка - 45-65 символов'
    }
    else {
      elem.style.background = 'red'
      status.textContent = 'Оптимальная длина seo заголовка - 45-65 символов'
    }
  }
  function watch() {
  

  let counter = document.querySelector(`#${name}_counter`)
  let input = document.querySelector(`#${name}`)
  
  let statusCircle = document.querySelector(`.status_circle_${name}`)
  counter.textContent = input.value.length
  checkStatus(input.value.length, statusCircle)

  input.addEventListener('input', function(e) {
    let len = e.target.value.length
    counter.textContent = len
    checkStatus(len, statusCircle)
  })

  //console.log(name)
  }

  watch()
}())
</script>