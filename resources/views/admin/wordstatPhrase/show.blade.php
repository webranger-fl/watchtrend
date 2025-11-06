<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ $wordstatPhrase->phrase }} - динамика по фразе
          <x-btn-link route="{{route('admin.wordstatPhrase.index')}}" class="ml-4">{{ __('Назад') }}</x-btn-link>
      </h2>
  </x-slot>

  <div class="py-12 text-slate-400">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            {{-- у меня 2я версия bladewind и в ней нет этого компонента увы --}}
            {{--<x-bladewind::chart :labels="$labels" :data="$data" title="Кол-во запросов в месяц" />--}}
            <x-bladewind.card title="Статистика" class="shrink-0 w-[700px] max-w-7xl mt-8 !bg-slate-900/50 !border-slate-700/50 !shadow-slate-900/80">
                        <div class="p-3 {{--bg-[aliceblue]--}} bg-gray-800 rounded-xl">
                          <div id="line-chart" style="height: 300px"></div>
                        </div> 
            </x-bladewind.card>

            @if(isset($stats['desktop_percent']))
            <div class="mt-4 flex gap-2">
                      <x-bladewind::statistic
                        number="{{$stats['desktop_percent']}}%"
                        label="Десктопы">
                        <x-slot name="icon">
                          <svg class="h-16 w-16 p-2 text-white rounded-full bg-blue-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-imac"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 4a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v12a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-12z" /><path d="M3 13h18" /><path d="M8 21h8" /><path d="M10 17l-.5 4" /><path d="M14 17l.5 4" /></svg>
                        </x-slot>
                        <div class="my-2">{{$stats['desktop']}} запросов</div>
                    </x-bladewind::statistic>

                    <x-bladewind::statistic
                        number="{{$stats['phone_percent']}}%"
                        label="Телефоны">
                        <x-slot name="icon">
                          <svg class="h-16 w-16 p-2 text-white rounded-full bg-blue-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-mobile"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14z" /><path d="M11 4h2" /><path d="M12 17v.01" /></svg>                        </x-slot>
                        <div class="my-2">{{$stats['phone']}} запросов</div>
                    </x-bladewind::statistic>

                    <x-bladewind::statistic
                        number="{{$stats['tablet_percent']}}%"
                        label="Планшеты">
                        <x-slot name="icon">
                          <svg class="h-16 w-16 p-2 text-white rounded-full bg-blue-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-ipad"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 3a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2z" /><path d="M9 18h6" /></svg>                        </x-slot>
                        <div class="my-2">{{$stats['tablet']}} запросов</div>
                    </x-bladewind::statistic>

                    </div>
                    @endif

          </div>
      </div>
  </div>
</x-app-layout>

<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<script src="{{asset('/plugins/flot/jquery.flot.js')}}"></script>

<script src="{{asset('/plugins/flot/plugins/jquery.flot.resize.js')}}"></script>

<script src="{{asset('/plugins/flot/plugins/jquery.flot.pie.js')}}"></script>
<script>
  $(function () {
  /*
     * LINE CHART
     * ----------
     */
    //LINE randomly generated data

    var sin = [],
        cos = []

    sin = [
      @foreach ($wordstatPhrase->stats as $idx => $s)
        //["{{$s->date}}", {{$s->value}}],
        [{{$idx}}, {{$s->value}}],
      @endforeach
    ];
    //console.log(sin)


    var line_data1 = {
      data : sin,
      color: '#f97316',
      label: 'запросов'
    }
    //console.log(line_data1)
    /*var line_data2 = {
      data : cos,
      color: '#00c0ef'
    }*/
    $.plot('#line-chart', [line_data1], {
      grid  : {
        hoverable  : true,
        borderColor: '#000',
        borderWidth: 1,
        tickColor  : '#000'
      },
      series: {
        shadowSize: 0,
        lines     : {
          show: true
        },
        points    : {
          show: true
        }
      },
      lines : {
        fill : false,
        color: ['#3c8dbc', '#f56954']
      },
      yaxis : {
        show: true
      },
      xaxis : {
        show: true
      }
    })
    //Initialize tooltip on hover
    $('<div class="tooltip-inner" id="line-chart-tooltip"></div>').css({
      position: 'absolute',
      display : 'none',
      opacity : 0.8
    }).appendTo('body')
    $('#line-chart').bind('plothover', function (event, pos, item) {

      if (item) {
        var x = item.datapoint[0],
            y = item.datapoint[1].toFixed(2)

        $('#line-chart-tooltip').html(item.series.label + ' на ' + x + ' = ' + y)
          .css({
            top : item.pageY + 5,
            left: item.pageX + 5
          })
          .fadeIn(200)
      } else {
        $('#line-chart-tooltip').hide()
      }

    })
    /* END LINE CHART */

  })
</script>
{{--@endPush--}}

<style>
  .flot-svg text {
    fill: #fff;
  }
  #line-chart-tooltip, #line-chart-tooltip2, #line-chart-tooltip3 {
    color: #fff;
  }
  </style>