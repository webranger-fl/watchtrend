@props(['stat'])

<div
        class="rounded-lg border text-card-foreground shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border-border bg-card/50 backdrop-blur-sm"
      >
        {{--<div class="flex flex-col space-y-1.5 p-6">
          <div class="font-semibold tracking-tight text-xl flex items-center justify-between">
            @if($stat->percent_change >= 0)
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
              class="lucide lucide-trending-up w-5 h-5 text-green-500"
            >
              <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
              <polyline points="16 7 22 7 22 13"></polyline>
            </svg>
            @else 
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
              class="lucide lucide-trending-down w-5 h-5 text-red-500"
            >
              <polyline points="22 17 13.5 8.5 8.5 13.5 2 7"></polyline>
              <polyline points="16 17 22 17 22 11"></polyline>
            </svg>
            @endif
          </div>
        </div>--}}
        <div class="p-6 {{--pt-0--}}">
          <div class="flex items-center gap-2">
            <span class="text-sm text-muted-foreground">{{$stat->date2}}</span>
            @if($stat->percent_change >= 0)
            <div
              class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-green-500/10 text-green-600 dark:text-green-400 hover:bg-green-500/20"
            >
              +{{$stat->percent_change}}%
            </div>
            @else 
            <div
              class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-red-500/10 text-red-600 dark:text-red-400 hover:bg-red-500/20"
            >
              {{$stat->percent_change}}%
            </div>
            @endif
            @if($stat->percent_change >= 0)
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
              class="lucide lucide-trending-up w-5 h-5 text-green-500"
            >
              <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
              <polyline points="16 7 22 7 22 13"></polyline>
            </svg>
            @else 
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
              class="lucide lucide-trending-down w-5 h-5 text-red-500"
            >
              <polyline points="22 17 13.5 8.5 8.5 13.5 2 7"></polyline>
              <polyline points="16 17 22 17 22 11"></polyline>
            </svg>
            @endif
          </div>
        </div>
      </div>