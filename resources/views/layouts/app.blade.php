<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
          tailwind.config = {
            darkMode: 'selector',
            theme: {
              extend: {
                colors: {
                  clifford: '#da373d',
                  //dark: colors.slate,
                  //dark: colors.gray,
                }
              }
            }
          }
        </script>
        <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
        <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    {{-- кстати добавить переключатель темы (светлая или темная) --}}
    <body class="font-sans antialiased dark">
      @if(session('stickyMsg'))
      <div class="fixed w-full text-center py-4 px-20 text-xl text-slate-200 bg-blue-950 z-10">  
          {{session('stickyMsg')}}
      </div>
      @endif
      <div class="admin_notification fixed w-full text-center {{--py-4--}} px-20 text-xl text-slate-200 bg-blue-950 z-10">
      @if(session('msg'))
        {{session('msg')}}
      @endif
    </div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @stack('scripts')
    </body>
</html>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    let notifBar = document.querySelector('.admin_notification')
    if(notifBar && notifBar.textContent.trim()) {
      notifBar.classList.add('py-4')
      setTimeout(() => {
        notifBar.style.display = 'none'
      }, 5000)
    }
  });
</script>
