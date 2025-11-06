<form class="w-full max-w-2xl mx-auto mt-8 animate-in fade-in slide-in-from-bottom-4 duration-1000 delay-200" method="POST" action="{{route('analyze')}}">
        @csrf
        <div class="relative">
          @error('keyword')
          <p class="text-base text-muted-foreground max-w-2xl mx-auto">
            {{$message}}
          </p>
          @endError
          <div class="flex gap-2">
            <div class="relative flex-1">
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
                class="lucide lucide-search absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-muted-foreground"
              >
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.3-4.3"></path></svg>
                <input
                type="text" name="keyword"
                class="flex w-full border-input bg-background px-3 py-2 ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm pl-12 h-14 text-lg rounded-xl border-2 focus:border-primary transition-all"
                placeholder="Слово или фраза. Например, {{randomElement(explode(', ', config('app.keys_examples')))}} ..."
                maxlength="100"
                value="{{old('keyword')}}"
                required
              />
            </div>
            <button
              class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-14 px-8 rounded-xl text-lg shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30 transition-all"
              type="submit"
            >
              Смотреть
            </button>
          </div>
        </div>
      </form>