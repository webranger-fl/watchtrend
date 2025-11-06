@props(['header' => true])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}-KZ" class="@yield('html_classes')">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{$title ?? config('app.name')}}</title>
        {{--<link rel="icon" type="image/png" href="/assets/logo.png"/>--}}
        <link rel="icon" type="image/svg" href="/trend.svg"/>

        <meta name="description" content="{{$desc ?? config('app.name')}}">

        @if(count(request()->query()) > 0)
        <meta name="robots" content="noindex, follow"/>
        <link rel="canonical" href="{{url()->current()}}">
        @else
          <meta name="robots" content="all"/>
          <link rel="canonical" href="{{url()->current()}}">
        @endif

        @if(isset($code) && $code->head)
          {!!$code->head!!}
        @endif

        {{--<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>--}}
{{--<link href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400..900&display=swap" rel="stylesheet">--}}
{{--<link href="https://fonts.googleapis.com/css2?family=Geologica:wght@100..900&family=Golos+Text:wght@400..900&display=swap" rel="stylesheet">--}}

        @vite('resources/css/app.css')
    </head>
    <body class="{{--antialiased bg-[#FDFDFD] text-[#454545] font-golos--}} @yield('body_classes')">
          
      @if($header)
         <header class="border-b border-border bg-card/50 backdrop-blur-sm lg:sticky top-0 z-50 py-2 lg:py-0">
          @auth
              <a class="fixed top-[40%] left-2 rounded-full bg-primary block p-4" href="/dashboard">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="32"  height="32"  viewBox="0 0 24 24"  fill="none"  stroke="#dddddd"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
              </a>
            @endAuth
    <div class="container mx-auto px-4">
      <div class="flex flex-col lg:flex-row items-center justify-between lg:h-16 gap-4">
        <a class="flex items-center gap-2 hover:opacity-80 transition-opacity" href="/"
          ><div class="p-2 bg-primary/10 rounded-lg">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="lucide lucide-trending-up w-6 h-6 text-primary"
            >
              <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
              <polyline points="16 7 22 7 22 13"></polyline>
            </svg>
          </div>
          <span class="text-xl font-bold bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent"
            >WatchTrend</span
          ></a
        >
        @include('partials.form2')
       @if((!auth()->id() || auth()->user()->role === 'admin') && false)
       <button id="signup"
              class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none 
              focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none 
              [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 
              {{--h-14--}} px-2 md:px-4 py-2 rounded-xl {{--text-lg--}} shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30 transition-all"
              type="submit"
            >
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" /></svg>
              
            </button>
       @endif
        {{--<nav class="flex items-center gap-6">
          <a class="text-sm font-medium transition-colors hover:text-primary text-primary" href="/">Главная</a
          >
          <a class="text-sm font-medium transition-colors hover:text-primary text-muted-foreground" href="/analytics"
            >Аналитика</a>
        </nav>--}}
      </div>
    </div>
  </header>
  @endif


          {{$slot}}

          


        </div>

        @if(session('msg')) 
        <div class="flash fixed top-[100px] left-[0] p-4 text-lg bg-[#5048e5] text-[#FDFDFD] rounded-[0px_60px_60px_0px]">{{session('msg')}}</div>
        @endif
        <div class="flash2 hidden fixed top-[100px] left-[0] p-4 text-lg bg-[#5048e5] text-[#FDFDFD] rounded-[0px_60px_60px_0px]"></div>

        {{--@vite('resources/js/index.js')--}}
        @stack('scripts')
        

        @if(request()->limit && session()->has("guest_request_limit_analyze")) 
        @include('partials.limitModal')
        @endif
        @if(!auth()->id() || auth()->user()->role === 'admin')
        @include('partials.signupModal')
        @endif

       @if(isset($code) && $code->body)
        {!!$code->body!!}
       @endif
    </body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
      let dialogClose = document.querySelector("#dialog_close")
      if(dialogClose) {
        dialogClose.addEventListener('click', function() {
          document.querySelector("#dialog_backdrop").style.display = 'none'
          document.querySelector("#dialog_wrap").style.display = 'none'
        })
      }

      let signupBtn = document.querySelector("#signup")
      if(signupBtn) {
        signupBtn.addEventListener('click', function() {
          document.querySelector("#dialog_signup_backdrop").style.display = 'block'
          document.querySelector("#dialog_signup_wrap").style.display = 'block'
        })
        let dialogSignupClose = document.querySelector("#dialog_signup_close")
        dialogSignupClose.addEventListener('click', function() {
          document.querySelector("#dialog_signup_backdrop").style.display = 'none'
          document.querySelector("#dialog_signup_wrap").style.display = 'none'
        })
      }

      let flash = document.querySelector('.flash')
    if(flash) {
      setTimeout(() => {
        flash.classList.add('hidden')
      }, 5000)
    }

    let shareBtns = document.querySelectorAll('.share_btn')
    shareBtns.forEach((_, idx) => {
      shareBtns[idx].addEventListener('click', function() {
        navigator.clipboard.writeText(window.location.href)
        let flash = document.querySelector('.flash2')
        flash.textContent = 'Ссылка скопирована в буфер обмена'
        flash.classList.remove('hidden')
        setTimeout(() => {
          flash.classList.add('hidden')
        }, 2000)
      })
    })

    })
  </script>


