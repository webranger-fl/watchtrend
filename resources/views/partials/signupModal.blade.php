<div style="display:none" id="dialog_signup_backdrop"
          data-state="open"
          class="fixed inset-0 z-50 bg-black/80 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0"
          style="pointer-events: auto"
          data-aria-hidden="true"
          aria-hidden="true"
        ></div>
        <div style="display:none" role="dialog" id="dialog_signup_wrap" {{--id="radix-:r0:"--}} aria-describedby="radix-:r2:" aria-labelledby="radix-:r1:" data-state="open" 
        class="fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg translate-x-[-50%] translate-y-[-50%] gap-4 border bg-background p-6 shadow-lg 
        duration-200 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 
        data-[state=open]:zoom-in-95 data-[state=closed]:slide-out-to-left-1/2 data-[state=closed]:slide-out-to-top-[48%] data-[state=open]:slide-in-from-left-1/2 
        data-[state=open]:slide-in-from-top-[48%] sm:rounded-lg sm:max-w-md" tabindex="-1" style="pointer-events: auto;">
        <div class="flex flex-col space-y-1.5 text-center sm:text-left">
          <div id="radix-:r1:" class="font-semibold tracking-tight text-2xl">Личный кабинет</div>
          <p id="radix-:r2:" class="text-muted-foreground text-base pt-4 space-y-3"><p>Создайте личный кабинет для доступа к расширенным возможностям</p>
          <p class="font-semibold text-foreground">Зарегистрируйтесь и получите:</p>
          <ul class="list-disc list-inside space-y-1 text-foreground/90">
            <li>Увеличенный лимит запросов</li>
            <li>Доступ к расширенной аналитике</li>
            {{--<li>Сохранение истории поиска</li>--}}
            <li>Создание проектов и возможность делиться ими</li>
          </ul></p>
        </div>
        <div class="flex sm:justify-end sm:space-x-2 flex-col sm:flex-row gap-2">
          <button id="dialog_signup_close" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background 
          transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none 
          disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border border-input bg-background hover:bg-accent 
          hover:text-accent-foreground h-10 px-4 py-2 w-full sm:w-auto">
          Закрыть
        </button>
        <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors 
        focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 
        [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 w-full sm:w-auto">
        Войти через Яндекс</button>
      </div>
      {{--<button type="button" class="absolute right-4 top-4 rounded-sm opacity-70 ring-offset-background transition-opacity data-[state=open]:bg-accent 
      data-[state=open]:text-muted-foreground hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:pointer-events-none">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x h-4 w-4"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
      <span class="sr-only">Close</span>
      </button>--}}
    </div>