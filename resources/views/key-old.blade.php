<x-layout>
  <x-slot:title>
    {{$key->phrase}} - динамика запросов за последний год, статистика и популярность
  </x-slot>
  <x-slot:desc>
    {{$key->phrase}} - динамика запросов за последний год, статистика и популярность за последние 12 месяцев
  </x-slot>

  <div class="container mx-auto px-4 py-8 pt-2">
  <div class="max-w-6xl mx-auto space-y-4 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="text-center space-y-2">
      <h1
        class="py-2 text-4xl md:text-5xl font-bold bg-gradient-to-r from-primary via-primary-glow to-accent bg-clip-text text-transparent"
      >
        {{$key->phrase}}
      </h1>
      <p class="text-muted-foreground text-lg">
        Интерактивная визуализация популярности за период {{$firstMonth}} - {{$lastMonth}}
      </p>

      <div class="flex mt-2 gap-2 flex-wrap justify-center">
        @if(!$hasDevicesStats)
        <form class="flex justify-center" method="POST" action="{{route('devices', $key->slug)}}">
          @csrf
          <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 min-w-[250px]" 
          type="submit"
          onclick="(function() {
                    if(!confirm('Хотите получить данные по устройствам для этого запроса?')) event.preventDefault();
                  })();">
                  <svg class="inline-block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-mobile"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14z" /><path d="M11 4h2" /><path d="M12 17v.01" /></svg>
            Получить данные по устройствам
          </button>
        </form>
        @endif

        <button class="share_btn inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none 
        focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 
        [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 
        text-sm px-4 py-2 rounded-xl shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30 transition-all animate-in fade-in slide-in-from-bottom-12 duration-1000 delay-500">
          <svg class="inline-block" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-share"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M18 6m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M8.7 10.7l6.6 -3.4" /><path d="M8.7 13.3l6.6 3.4" /></svg>
          Поделиться
      </button>
      </div>
      
    </div>
    <div class="rounded-lg border text-card-foreground p-6 bg-card border-border shadow-lg">
      <div id="chart"></div>
      {{--<div class="mb-6">
        <h2 class="text-2xl font-bold mb-2">Тренд: "React разработка"</h2>
        <p class="text-muted-foreground">Количество поисковых запросов за последний год</p>
      </div>--}}

      <div class="mt-6 grid {{--grid-cols-2 md:grid-cols-4--}} grid-cols-2 md:grid-cols-4 gap-4">
        <div class="p-4 bg-secondary rounded-xl">
          <p class="text-sm text-muted-foreground mb-1">{{$lastMonth}} (запросы)</p>
          <p class="text-2xl font-bold text-primary">{{formatNumber($lastMonthStat->value)}}</p>
        </div>
        <div class="p-4 bg-secondary rounded-xl">
          <p class="text-sm text-muted-foreground mb-1">Всего запросов (последние {{$monthCount}} месяцев)</p>
          <p class="text-2xl font-bold text-primary">{{formatNumber($addStats['all'])}}</p>
        </div>
        {{--<div class="p-4 bg-secondary rounded-xl">
          <p class="text-sm text-muted-foreground mb-1">Средний рост</p>
          <p class="text-2xl font-bold text-chart-3">+15%</p>
        </div>--}}
        <div class="p-4 bg-secondary rounded-xl">
          <p class="text-sm text-muted-foreground mb-1">Минимум ({{formatNumber($addStats['min']->value)}} запросов)</p>
          <p class="text-2xl font-bold text-accent">{{$addStats['min_month']}}</p>
        </div>
        <div class="p-4 bg-secondary rounded-xl">
          <p class="text-sm text-muted-foreground mb-1">Максимум ({{formatNumber($addStats['max']->value)}} запросов)</p>
          <p class="text-2xl font-bold text-accent">{{$addStats['max_month']}}</p>
        </div>
        {{--<div class="p-4 bg-secondary rounded-xl">
          <p class="text-sm text-muted-foreground mb-1">Прогноз</p>
          <p class="text-2xl font-bold text-chart-4">5,200</p>
        </div>--}}
      </div>
      @if($hasDevicesStats)
      <div class="mt-6 grid {{--grid-cols-2 md:grid-cols-4--}} grid-cols-2 md:grid-cols-4 gap-4">
        <div class="p-4 bg-secondary rounded-xl flex items-center gap-4">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-desktop"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 5a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10z" /><path d="M7 20h10" /><path d="M9 16v4" /><path d="M15 16v4" /></svg>
          <div>
            <p class="text-sm text-muted-foreground mb-1">Персональные компьютеры ({{formatNumber($addStats['desktop'])}})</p>
            <p class="text-2xl font-bold text-primary">{{$addStats['desktop_percent']}}%</p>
          </div>         
        </div>
        <div class="p-4 bg-secondary rounded-xl flex items-center gap-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-mobile"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14z" /><path d="M11 4h2" /><path d="M12 17v.01" /></svg>          
            <div>
            <p class="text-sm text-muted-foreground mb-1">Телефоны ({{formatNumber($addStats['phone'])}})</p>
            <p class="text-2xl font-bold text-primary">{{$addStats['phone_percent']}}%</p>
          </div>         
        </div>
        <div class="p-4 bg-secondary rounded-xl flex items-center gap-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-tablet"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4a1 1 0 0 1 1 -1h12a1 1 0 0 1 1 1v16a1 1 0 0 1 -1 1h-12a1 1 0 0 1 -1 -1v-16z" /><path d="M11 17a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /></svg>
            <div>
            <p class="text-sm text-muted-foreground mb-1">Планшеты ({{formatNumber($addStats['tablet'])}})</p>
            <p class="text-2xl font-bold text-primary">{{$addStats['tablet_percent']}}%</p>
          </div>         
        </div>
      </div>
      @endif
    </div>

    {{--<div class="grid md:grid-cols-2 gap-6">
      <div class="p-6 bg-card rounded-2xl border border-border">
        <h3 class="text-xl font-semibold mb-3">О графике</h3>
        <p class="text-muted-foreground">
          График показывает количество поисковых запросов по выбранному тренду за последние 12 месяцев. Данные
          обновляются ежедневно и позволяют отслеживать динамику интереса пользователей.
        </p>
      </div>
      <div class="p-6 bg-card rounded-2xl border border-border">
        <h3 class="text-xl font-semibold mb-3">Как использовать</h3>
        <ul class="space-y-2 text-muted-foreground">
          <li>• Наведите курсор на график для детальной информации</li>
          <li>• Анализируйте пики и спады активности</li>
          <li>• Используйте статистику для прогнозирования</li>
          <li>• Сравнивайте периоды для выявления паттернов</li>
        </ul>
      </div>
    </div>--}}
  </div>
</div>

@push('scripts')
  {{--<script>
    document.addEventListener('DOMContentLoaded', function() {
      console.log('DOMContentLoaded')
    })
  </script>--}}
  {{--<script src="https://d3js.org/d3.v7.min.js"></script>--}}
  <script src="/js/d3.js"></script>
    <style>
         .line {
            fill: none;
            stroke: #8671F3;
            stroke-width: 3;
        }
        
        .dot {
            fill: #8671F3;
            stroke: white;
            stroke-width: 2;
        }
        
        .axis {
            color: #374151;
        }
        
        .grid line {
            stroke: #e5e7eb;
            stroke-dasharray: 3,3;
        }
        
        .tooltip {
            position: absolute;
            padding: 8px;
            background: rgba(0, 0, 0, 0.9);
            color: white;
            border-radius: 4px;
            pointer-events: none;
            font-size: 12px;
            z-index: 1000;
            max-width: 150px;
        }
        
        .max-point {
            fill: #dc2626;
            stroke: white;
            stroke-width: 3;
            filter: drop-shadow(0 0 6px rgba(220, 38, 38, 0.6));
        }
        
        .min-point {
            fill: #16a34a;
            stroke: white;
            stroke-width: 3;
            filter: drop-shadow(0 0 6px rgba(22, 163, 74, 0.6));
        }
        
        .annotation {
            font-weight: bold;
            text-anchor: middle;
        }
        
        .annotation-max { fill: #dc2626; }
        .annotation-min { fill: #16a34a; }
        
        .annotation-line {
            stroke-dasharray: 2,2;
            stroke-width: 1;
        }
        
        .annotation-line-max { stroke: #dc2626; }
        .annotation-line-min { stroke: #16a34a; }
        
        /* Адаптивные стили */
        @media (max-width: 768px) {
            body { padding: 5px; }
            .tooltip { font-size: 11px; padding: 6px; }
            .line { stroke-width: 2; }
        }
        
        @media (max-width: 480px) {
            .tooltip { font-size: 10px; padding: 4px; }
            .line { stroke-width: 2; }
        }
    </style>

    <script>
        // Данные за последний год (ноябрь 2024 - ноябрь 2025)
        const data = [
          @foreach($stats as $s)
            { month: "{{$s['month']}}", value: {{$s['value']}} },
          @endForeach
            /*{ month: "Ноя 2024", value: 150 },
            { month: "Дек 2024", value: 180 },
            { month: "Янв 2025", value: 120 },
            { month: "Фев 2025", value: 200 },
            { month: "Мар 2025", value: 250 },
            { month: "Апр 2025", value: 220 },
            { month: "Май 2025", value: 280 },
            { month: "Июн 2025", value: 300 },
            { month: "Июл 2025", value: 320 },
            { month: "Авг 2025", value: 290 },
            { month: "Сен 2025", value: 260 },
            { month: "Окт 2025", value: 240 },
            { month: "Ноя 2025", value: 210 }*/
        ];
        //console.log(data)

        // Размеры графика
        const margin = { top: 20, right: 30, bottom: 60, left: 80 };
        const width = 900 - margin.left - margin.right;
        const height = 450 - margin.top - margin.bottom;

        // Создание SVG
        const svg = d3.select("#chart")
            .append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom);

        const g = svg.append("g")
            .attr("transform", `translate(${margin.left},${margin.top})`);

        // Создание шкал
        const xScale = d3.scalePoint()
        //const xScale = d3.scaleBand()
            .domain(data.map(d => d.month))
            .range([0, width])
            //.padding(0.1);
            .padding(0);

        const yScale = d3.scaleLinear()
            .domain([0, d3.max(data, d => d.value) * 1.1])
            .range([height, 0]);

        // Создание линии
        const line = d3.line()
            .x(d => xScale(d.month) + xScale.bandwidth() / 2)
            .y(d => yScale(d.value))
            .curve(d3.curveMonotoneX);

        // Добавление сетки
        g.append("g")
            .attr("class", "grid")
            .attr("transform", `translate(0,${height})`)
            .call(d3.axisBottom(xScale)
                .tickSize(-height)
                .tickFormat("")
            );

        g.append("g")
            .attr("class", "grid")
            .call(d3.axisLeft(yScale)
                .tickSize(-width)
                .tickFormat("")
            );

        // Добавление осей
        g.append("g")
            .attr("class", "axis")
            .attr("transform", `translate(0,${height})`)
            .call(d3.axisBottom(xScale))
            .selectAll("text")
            .style("text-anchor", "end")
            .attr("dx", "-.8em")
            .attr("dy", ".15em")
            .attr("transform", "rotate(-45)");

        g.append("g")
            .attr("class", "axis")
            .call(d3.axisLeft(yScale));

        // Создание tooltip
        const tooltip = d3.select("body")
            .append("div")
            .attr("class", "tooltip")
            .style("opacity", 0);

        // Добавление линии
        g.append("path")
            .datum(data)
            .attr("class", "line")
            .attr("d", line);

        // Добавление точек
        g.selectAll(".dot")
            .data(data)
            .enter().append("circle")
            .attr("class", "dot")
            .attr("cx", d => xScale(d.month) + xScale.bandwidth() / 2)
            .attr("cy", d => yScale(d.value))
            .attr("r", 5)
            .on("mouseover", function(event, d) {
                tooltip.transition()
                    .duration(200)
                    .style("opacity", .9);
                tooltip.html(`${d.month}<br/>Запросы: ${d.value}`)
                    .style("left", (event.pageX + 10) + "px")
                    .style("top", (event.pageY - 28) + "px");
                
                d3.select(this)
                    .transition()
                    .duration(100)
                    .attr("r", 7);
            })
            .on("mouseout", function() {
                tooltip.transition()
                    .duration(500)
                    .style("opacity", 0);
                
                d3.select(this)
                    .transition()
                    .duration(100)
                    .attr("r", 5);
            });

        // Добавление подписей осей
        g.append("text")
            .attr("transform", "rotate(-90)")
            .attr("y", 0 - margin.left)
            .attr("x", 0 - (height / 2))
            .attr("dy", "1em")
            .style("text-anchor", "middle")
            .text("Кол-во запросов");

        /*g.append("text")
            .attr("transform", `translate(${width / 2}, ${height + margin.bottom})`)
            .style("text-anchor", "middle")
            .text("Месяцы");*/

        // Добавление заголовка
        /*svg.append("text")
            .attr("x", (width + margin.left + margin.right) / 2)
            .attr("y", margin.top / 2)
            .attr("text-anchor", "middle")
            .style("font-size", "16px")
            .style("font-weight", "bold")
            .text("Запросы по месяцам");*/

    </script>
@endPush

</x-layout>

