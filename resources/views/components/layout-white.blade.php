<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}-KZ" class="@yield('html_classes')">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{$title ?? 'Laravel движок'}}</title>
        <link rel="icon" type="image/png" href="/assets/logo.png"/>
        {{--<link rel="icon" type="image/svg" href="/assets/logo1.svg"/>--}}

        <meta name="description" content="{{$desc ?? 'Laravel движок'}}">

        @if(count(request()->query()) > 0)
        <meta name="robots" content="noindex, follow"/>
        <link rel="canonical" href="{{url()->current()}}">
        @else
          <meta name="robots" content="all"/>
          <link rel="canonical" href="{{url()->current()}}">
        @endif

        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
{{--<link href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400..900&display=swap" rel="stylesheet">--}}
<link href="https://fonts.googleapis.com/css2?family=Geologica:wght@100..900&family=Golos+Text:wght@400..900&display=swap" rel="stylesheet">

        @vite('resources/css/app.css')
        {{--@vite('resources/css/app2.css')--}}

        {{--@production--}}
        @if(isset($code))
          {!!$code->head!!}
        @endif
        {{--@endProduction--}}
    </head>
    <body class="antialiased bg-[#FDFDFD] text-[#454545] font-golos @yield('body_classes')">
        <div class="p-4 {{--overflow-x-hidden--}} overflow-hidden @yield('wrap_classes')">
          <header class="max-w-[1380px] mx-auto flex gap-6 justify-between items-center @yield('header_classes')">
            <x-logo-white />
            {{--@include("blocks.menu")
            @include("blocks.menu_mobile")--}}
            @auth
              <a class="fixed top-[40%] left-2 rounded-full bg-primary block p-4" href="/dashboard">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="32"  height="32"  viewBox="0 0 24 24"  fill="none"  stroke="#dddddd"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
              </a>
            @endAuth
            
            
            <div class="flex gap-4 items-center">
              {{--<div class="bg-[#F8F8F8] rounded-[50px] p-2 md:p-3 md:px-5 font-medium text-[#454545] font-golos text-xs md:text-sm cursor-pointer">
                <svg class="icon" width="17" height="12"><use href="/assets/sprite.svg#ru"></use></svg> 
                RU
                <svg width="9" height="5" class="inline-block">
                  <image xlink:href="/assets/site2/arrow_up2.svg"/>
                </svg>
              </div>--}}
              {{--<div id="mob_menu_btn" class="md:hidden">
                <svg width="21" height="11" viewBox="0 0 21 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <line y1="0.5" x2="21" y2="0.5" stroke="#454545"/>
                  <line y1="5.5" x2="21" y2="5.5" stroke="#454545"/>
                  <line y1="10.5" x2="21" y2="10.5" stroke="#454545"/>
                  </svg>
                  
              </div>--}}
            </div>
            
          </header>
          <!-- /header -->

          {{--@if(!isset($no_social))
          <div class="w-9 h-9 rounded-full bg-[#151617] social text-center p-2 hidden 2xl:block 2xl:absolute top-[280px] right-[10px] cursor-pointer">
            <img src="/assets/tg.svg"/>
          </div>
          <div class="w-9 h-9 rounded-full bg-[#151617] social text-center p-2 hidden 2xl:block 2xl:absolute top-[330px] right-[10px] cursor-pointer">
            <img src="/assets/whatsapp.svg"/>
          </div>
          @endif --}}

          {{$slot}}

          


        </div>

        {{--@if(!Route::is('login')) @include('partials.contacts_fixed') @endif--}}

       {{--@include('partials.footer')
        @include('partials.popup')--}}

      @if(session('msg')) 
        <div class="flash fixed top-[100px] left-[0] p-4 text-lg bg-[#46AF7D] text-[#FDFDFD] rounded-[0px_60px_60px_0px]">{{session('msg')}}</div>
      @endif

        {{--@vite('resources/js/index.js')--}}
        @stack('scripts')

        @if(isset($code) && $code->body_code)
@production
    <script>
        // загрузка счетчиков по событию
    (function(){
        // events to load metrics once
        const events = ['mousemove', 'touchstart', 'scroll', 'resize', 'keydown'];      
        //runtime
        let fired = false;
        
        function loadMetrics(){
            if(fired){
                return;
            }
            
            fired = true;
            events.forEach(name => window.removeEventListener(name, loadMetrics));

            // counters code
            {!!$code->body!!}
        
        }
        
        events.forEach(name => window.addEventListener(name, loadMetrics));
    })();
    </script>
  @endProduction
    @endif
    </body>
</html>

<script>
  document.addEventListener('DOMContentLoaded', function(){
    const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry)=>{
        if(entry.isIntersecting)entry.target.classList.add('show');
    });
});
    const animatables = document.querySelectorAll('.animatable');
    animatables.forEach((el)=>observer.observe(el));

    let flash = document.querySelector('.flash')
    if(flash) {
      setTimeout(() => {
        flash.classList.add('hidden')
      }, 3000)
    }
  let menuBtn = document.querySelector('#mob_menu_btn')
  let menu = document.querySelector('#mobile_menu')
  let menuClose = document.querySelector('#mobile_menu_close')
  menuBtn.addEventListener('click', e => {
    menu.style.transform = 'translateX(0px)'
  })
  menuClose.addEventListener('click', e => {
    menu.style.transform = 'translateX(500px)'
  })

  document.addEventListener('click', function(event) {
    //console.log(event.target.classList)
    if(/*event.target.classList.contains('close_popup') ||*/ event.target.classList.contains('popup')) {
      let popup = document.querySelector('.popup')
      popup.classList.remove('active')
    }
  })

  let closePopup = document.querySelector('.close_popup')
  closePopup.addEventListener('click', function() {
    document.querySelector('.popup').classList.remove('active')
  })
})
</script>


