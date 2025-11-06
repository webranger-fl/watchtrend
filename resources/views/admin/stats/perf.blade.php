<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight dark:[text-64px]">
          {{ __('Скорость. Статистика') }}
      </h2>

      <div class="flex my-2 gap-4">
      <x-bladewind::statistic
    number="{{$count['all_avg']}} сек"
    label="За последние 30 дней, на основе {{$count['all']}} запросов"
    label_position="bottom">

    <x-slot name="icon">
      <x-bladewind::icon name="rocket-launch" />
    </x-slot>
</x-bladewind::statistic>

<x-bladewind::statistic
    number="{{$count['today_avg']}} сек"
    label="Сегодня, на основе {{$count['today']}} запросов. <br> Попали в кэш: {{$count['today_cache']}}"
    label_position="bottom" class="!bg-green-900 !text-white">

    <x-slot name="icon">
      <x-bladewind::icon name="rocket-launch" />
    </x-slot>
</x-bladewind::statistic>
{{--<x-admin.smallbox :value="count($stats['slowReqs'])" label="Медленные запросы за сегодня (больше 0.5 сек) <br> {{$stats['slowReqsPercentToday']}}% - доля медленных запросов среди всех за день" icon="fas fa-tachometer-alt" class="bg-warning" />
--}}
<x-bladewind::statistic
    number="{{$stats['slowReqsCount']}}"
    label="Медленные запросы за сегодня (больше 0.5 сек) <br> {{$stats['slowReqsPercentToday']}}% - доля медленных запросов среди всех за день"
    label_position="bottom"
    class="!bg-yellow-500">

    <x-slot name="icon">
      <x-bladewind::icon name="clock" />
    </x-slot>
</x-bladewind::statistic>
</div>
  </x-slot>

  <div class="flex gap-6 px-20 justify-center">
    <x-bladewind.card title="Сегодня. Средняя скорость обработки запросов, по часам" class="w-[700px] max-w-7xl mt-8 !bg-slate-900/50 !border-slate-700/50 !shadow-slate-900/80">
      <div class="p-3 {{--bg-[aliceblue]--}} bg-gray-800 rounded-xl">
        <div id="line-chart" style="height: 300px"></div>
      </div> 
    </x-bladewind.card>

    <x-bladewind.card title="Сегодня. Медленные запросы, по часам" class="w-[700px] max-w-7xl mt-8 !bg-slate-900/50 !border-slate-700/50 !shadow-slate-900/80">
      <div class="p-3 bg-gray-800 rounded-xl">
        <div id="line-chart2" style="height: 300px"></div>
      </div> 
    </x-bladewind.card>

  </div>

  <x-bladewind.card title="Скорость" class="max-w-7xl mx-auto mt-8 !bg-slate-900/50 !border-slate-700/50 !shadow-slate-900/80">
      {{--<p class="my-2 text-slate-300"></p>--}}

      <div class="flex gap-2">
      
        <div class="w-1/2">
      <x-bladewind.table>
        <legend class="my-2 text-slate-300">Последние запросы</legend>
        <x-slot name="header">
            <th>Время</th>
            <th>Когда</th>
            <th>Из кэша</th>
        </x-slot>
        @foreach($reqs as $i)
        <tr>
            <td>{{$i->execution_time}}</td>
            <td>{{$i->created_at}}</td>
            <td>{{$i->cache_hit ? '+' : '-'}}</td>

        </tr>
        @endForeach
      </x-bladewind.table>
      </div>

      <div class="w-1/2">
      @if(count($stats['slowReqs']) > 0)
      <x-bladewind.table>
        <legend class="my-2 text-yellow-300">Медленные запросы</legend>
        <x-slot name="header">
            <th>Время</th>
            <th>Когда</th>
            <th>Из кэша</th>
        </x-slot>
        @foreach($stats['slowReqs'] as $i)
        <tr>
            <td>{{$i->execution_time}}</td>
            <td>{{$i->created_at}}</td>
            <td>{{$i->cache_hit ? '+' : '-'}}</td>

        </tr>
        @endForeach
      </x-bladewind.table>
      </div>
      @endif

    </div>
  </x-bladewind.card>

</x-app-layout>

{{--@push('scripts')--}}
<!-- jQuery -->
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
      @foreach ($todayByHour as $h)
        [{{$loop->index}}, {{$h->avg}}],
      @endforeach
    ];
    //console.log(sin)

    
    
    /*for (var i = 0; i < {{count($todayByHour)}}; i++) {
      //sin.push([i, {{$todayByHour[0]->avg}}])
      //cos.push([i, Math.cos(i)])
      //$i++;
    }*/
    //console.log(sin)
    var line_data1 = {
      data : sin,
      color: '#f97316',
      label: 'средняя скорость'
    }
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
        var x = item.datapoint[0]/*.toFixed(2)*/,
            y = item.datapoint[1].toFixed(2)

        $('#line-chart-tooltip').html(item.series.label + ' в ' + x + ':00  = ' + y + ' сек')
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

    // LINE CHART2
    let data2 = []
    data2 = [
      @foreach ($stats['slowReqsByHour'] as $h)
        [{{$h->hour}}, {{$h->count}}],
      @endforeach
    ];

    var line_data1 = { data : data2, color: '#ffc107', label: 'кол-во медленных запросов' }

    $.plot('#line-chart2', [line_data1], {
      grid  : { hoverable  : true, borderColor: '#000', borderWidth: 1, tickColor  : '#000' },
      series: { shadowSize: 0, lines     : { show: true }, points    : { show: true } },
      lines : { fill : false, color: ['#ffc107', '#f56954'] },
      yaxis : { show: true },
      xaxis : { show: true }
    })
    //Initialize tooltip on hover
    $('<div class="tooltip-inner" id="line-chart-tooltip2"></div>').css({
      position: 'absolute',
      display : 'none',
      opacity : 0.8
    }).appendTo('body')
    $('#line-chart2').bind('plothover', function (event, pos, item) {

      if (item) {
        var x = item.datapoint[0]/*.toFixed(2)*/,
            y = item.datapoint[1]/*.toFixed(2)*/

        $('#line-chart-tooltip2').html(item.series.label + ' в ' + x + ':00  = ' + y)
          .css({
            top : item.pageY + 5,
            left: item.pageX + 5
          })
          .fadeIn(200)
      } else {
        $('#line-chart-tooltip2').hide()
      }

    })
  })
</script>
{{--@endPush--}}

<style>
  .flot-svg text {
    fill: #fff;
  }
  #line-chart-tooltip, #line-chart-tooltip2 {
    color: #fff;
  }
  </style>

