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
    <div class="rounded-lg border text-card-foreground p-3 sm:p-6 bg-card border-border shadow-lg">
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

      {{--@if(count($ups) > 0)
      <div class="mt-6 text-xl">Топ отрезки роста</div>
      <div class="mt-2 grid grid-cols-1 sm:grid-cols-3 gap-4">
        @foreach($ups as $s)
          <x-trend-card-light :stat="$s" />
        @endForeach
      </div>
      @endif

      @if(count($downs) > 0)
      <div class="mt-6 text-xl">Топ отрезки спада</div>
      <div class="mt-2 grid grid-cols-1 sm:grid-cols-3 gap-4">
        @foreach($downs as $s)
          <x-trend-card-light :stat="$s" />
        @endForeach
      </div>
      @endif--}}

      <div class="mt-6 grid sm:grid-cols-2 gap-4">

      @if($addStats['ups_count'] > 0)
      <div
        class="rounded-lg border text-card-foreground shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border-border bg-card/50 backdrop-blur-sm"
      >
        <div class="p-6 {{--pt-0--}}">
          <div class="flex items-center gap-2 mb-4">
            <span class="text-xl {{--text-muted-foreground--}}">Месяцы роста</span>
            <div
              class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-2xl font-semibold transition-colors focus:outline-none focus:ring-2 
              focus:ring-ring focus:ring-offset-2 border-transparent bg-green-500/10 text-green-600 dark:text-green-400 hover:bg-green-500/20"
            >{{$addStats['ups_count']}}</div>
          </div>

           @foreach($ups as $s)
            <x-trend-card-light-v2 :stat="$s" />
          @endForeach
        </div>
      </div>
      @endif
      @if($addStats['downs_count'] > 0)
      <div
        class="rounded-lg border text-card-foreground shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border-border bg-card/50 backdrop-blur-sm"
      >
        <div class="p-6 {{--pt-0--}}">
          <div class="flex items-center gap-2 mb-4">
            <span class="text-xl {{--text-muted-foreground--}}">Месяцы спада</span>
            <div
              class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-2xl font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-red-500/10 text-red-600 dark:text-red-400 hover:bg-red-500/20"
            >{{$addStats['downs_count']}}</div>
          </div>
           @foreach($downs as $s)
            <x-trend-card-light-v2 :stat="$s" />
          @endForeach
        </div>
       
      </div>
      @endif

      </div>

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
        
        .min-point {
            fill: #dc2626;
            stroke: white;
            stroke-width: 3;
            filter: drop-shadow(0 0 6px rgba(220, 38, 38, 0.6));
        }
        
        .max-point {
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
    @vite('resources/js/graph.js')

    {{--<script>
        // Данные за последний год
        const data = [
          @foreach($stats as $s)
            { month: "{{$s['month']}}", shortMonth: "{{$s['shortMonth']}}", value: {{$s['value']}} },
          @endForeach
        ];

      function formatNumber(value) {
    if (value === 0) return '0';
    
    const absValue = Math.abs(value);
    const sign = value < 0 ? '-' : '';
    
    if (absValue >= 1000000000) {
        // Миллиарды
        const formatted = absValue / 1000000000;
        if (formatted >= 10 || Number.isInteger(formatted)) {
            return sign + Math.round(formatted) + ' млрд';
        } else {
            return sign + formatted.toFixed(1) + ' млрд';
        }
    } else if (absValue >= 1000000) {
        // Миллионы
        const formatted = absValue / 1000000;
        if (formatted >= 10 || Number.isInteger(formatted)) {
            return sign + Math.round(formatted) + ' млн';
        } else {
            return sign + formatted.toFixed(1) + ' млн';
        }
    } else if (absValue >= 1000) {
        // Тысячи
        const formatted = absValue / 1000;
        if (formatted >= 10 || Number.isInteger(formatted)) {
            return sign + Math.round(formatted) + ' тыс';
        } else {
            return sign + formatted.toFixed(1) + ' тыс';
        }
    } else {
        // Числа меньше тысячи
        if (Number.isInteger(absValue)) {
            return sign + absValue.toString();
        } else if (absValue >= 10) {
            return sign + Math.round(absValue).toString();
        } else {
            return sign + absValue.toFixed(1);
        }
    }
}

        // Функция для получения адаптивных размеров
        function getResponsiveDimensions() {
            const containerWidth = document.getElementById('chart').offsetWidth;
            const isMobile = window.innerWidth <= 768;
            const isSmallMobile = window.innerWidth <= 480;
            const isVerySmallMobile = window.innerWidth <= 400; // Новая категория
            
            let margin, width, height;
            
            if (isVerySmallMobile) {
                  margin = { top: 15, right: 15, bottom: 50, left: 35 };
                  width = Math.min(containerWidth - margin.left - margin.right, 300);
                  height = 200;
              }
            else if (isSmallMobile) {
                margin = { top: 20, right: 20, bottom: 60, left: 40 };
                width = Math.min(containerWidth - margin.left - margin.right, 350);
                height = 250;
            } else if (isMobile) {
                margin = { top: 25, right: 25, bottom: 65, left: 45 };
                width = Math.min(containerWidth - margin.left - margin.right, 500);
                height = 300;
            } else {
                margin = { /*top: 30,*/ top: 0, /*right: 80,*/ right: 30, bottom: 60, left: 70 };
                width = Math.min(containerWidth - margin.left - margin.right, 800);
                height = 400;
            }
            
            return { margin, width, height, isMobile, isSmallMobile, isVerySmallMobile };
        }

        // Функция создания графика
        function createChart() {
            // Очистка предыдущего графика
            d3.select("#chart").selectAll("*").remove();
            
            const { margin, width, height, isMobile, isSmallMobile, isVerySmallMobile } = getResponsiveDimensions();
            
            // Создание адаптивного SVG
            const svg = d3.select("#chart")
                .append("svg")
                .attr("viewBox", `0 0 ${width + margin.left + margin.right} ${height + margin.top + margin.bottom}`)
                .attr("preserveAspectRatio", "xMidYMid meet")
                .style("width", "100%")
                .style("height", "auto");

            const g = svg.append("g")
                .attr("transform", `translate(${margin.left},${margin.top})`);

            // Создание шкал
            const xScale = d3.scalePoint()
                .domain(data.map(d => d.month))
                .range([0, width])
                .padding(0);

            const yScale = d3.scaleLinear()
                .domain([0, d3.max(data, d => d.value) * 1.1])
                .range([height, 0]);

            // Создание линии
            const line = d3.line()
                .x(d => xScale(d.month))
                .y(d => yScale(d.value))
                .curve(d3.curveMonotoneX);

            // Добавление сетки (упрощенной на мобильных)
            if (!isSmallMobile) {
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
                        .ticks(isMobile ? 5 : 8)
                        .tickSize(-width)
                        .tickFormat("")
                    );
            }

            // Добавление осей
            const xAxisCall = d3.axisBottom(xScale);
            
            // На мобильных используем сокращенные названия месяцев
            if (isSmallMobile) {
                xAxisCall.tickFormat((d, i) => data[i].shortMonth);
            }
            
            g.append("g")
                .attr("class", "axis")
                .attr("transform", `translate(0,${height})`)
                .call(xAxisCall)
                .selectAll("text")
                .style("text-anchor", isSmallMobile ? "middle" : "end")
                //.style("font-size", isSmallMobile ? "10px" : isMobile ? "11px" : "12px")
                .style("font-size", getFontSize())
                //.attr("dx", isSmallMobile ? "0" : "-.8em")
                .attr("dx", isSmallMobile ? "-2.8em" : "-.8em")
                //.attr("dx", "-.8em")
                .attr("dy", ".15em")
                //.attr("transform", isSmallMobile ? null : "rotate(-45)");
                .attr("transform", "rotate(-45)");

            function getFontSize() {
    if (isVerySmallMobile) return "7px";      // Очень мелкий шрифт
    if (isSmallMobile) return "9px";          // Мелкий шрифт  
    if (isMobile) return "11px";              // Средний шрифт
    return "12px";                            // Обычный шрифт
}


            g.append("g")
    .attr("class", "axis")
    .call(d3.axisLeft(yScale)
        .ticks(isMobile ? 5 : 8)
        .tickFormat(formatNumber)
    )
    .selectAll("text")
    .style("font-size", isSmallMobile ? "10px" : "12px");

            /*g.append("g")
                .attr("class", "axis")
                .call(d3.axisLeft(yScale).ticks(isMobile ? 5 : 8))
                .selectAll("text")
                .style("font-size", isSmallMobile ? "10px" : "12px");*/

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

            // Размер точек в зависимости от экрана
            const dotRadius = isSmallMobile ? 4 : isMobile ? 4.5 : 5;
            const extremeRadius = isSmallMobile ? 6 : isMobile ? 7 : 8;

            // Добавление точек
            g.selectAll(".dot")
                .data(data)
                .enter().append("circle")
                .attr("class", "dot")
                .attr("cx", d => xScale(d.month))
                .attr("cy", d => yScale(d.value))
                .attr("r", dotRadius)
                .on("mouseover", function(event, d) {
                    tooltip.transition()
                        .duration(200)
                        .style("opacity", .9);
                    tooltip.html(`${d.month}<br/>Запросы: ${d.value}`)
                        .style("left", Math.min(event.pageX + 10, window.innerWidth - 160) + "px")
                        .style("top", (event.pageY - 28) + "px");
                    
                    d3.select(this)
                        .transition()
                        .duration(100)
                        .attr("r", dotRadius + 2);
                })
                .on("mouseout", function() {
                    tooltip.transition()
                        .duration(500)
                        .style("opacity", 0);
                    
                    d3.select(this)
                        .transition()
                        .duration(100)
                        .attr("r", dotRadius);
                });

            // Экстремумы
            const maxValue = d3.max(data, d => d.value);
            const minValue = d3.min(data, d => d.value);
            const maxPoint = data.find(d => d.value === maxValue);
            const minPoint = data.find(d => d.value === minValue);

            // Функция для добавления аннотации (упрощенная для мобильных)
            function addAnnotation(point, type) {
                if (isSmallMobile) return; // Убираем аннотации на маленьких экранах
                
                const x = xScale(point.month);
                const y = yScale(point.value);
                const isMax = type === 'max';
                const offset = isMax ? -25 : 25;
                const label = isMax ? 'МАКС' : 'МИН';
                
                const annotationGroup = g.append("g").attr("class", "annotations");
                
                annotationGroup.append("text")
                    .attr("class", "annotation")
                    .attr("x", x)
                    .attr("y", y + offset)
                    .text(`${label}: ${point.value}`)
                    .attr("fill", isMax ? "#dc2626" : "#16a34a")
                    .attr("font-size", isMobile ? "10px" : "12px")
                    .style("opacity", 0)
                    .transition()
                    .delay(500)
                    .duration(300)
                    .style("opacity", 1);
            }

            // Выделение экстремумов
            [
                { point: maxPoint, class: "max-point", color: "#dc2626" },
                { point: minPoint, class: "min-point", color: "#16a34a" }
            ].forEach(({ point, class: className, color }, index) => {
                g.append("circle")
                    .attr("class", className)
                    .attr("cx", xScale(point.month))
                    .attr("cy", yScale(point.value))
                    .attr("r", extremeRadius)
                    .on("mouseover", function(event) {
                        tooltip.transition()
                            .duration(200)
                            .style("opacity", .9);
                        tooltip.html(`${point.month}<br/>${className.includes('max') ? 'Максимум' : 'Минимум'}: ${point.value}`)
                            .style("left", Math.min(event.pageX + 10, window.innerWidth - 160) + "px")
                            .style("top", (event.pageY - 28) + "px");
                    })
                    .on("mouseout", function() {
                        tooltip.transition()
                            .duration(500)
                            .style("opacity", 0);
                    });

                // Добавляем аннотации
                //setTimeout(() => addAnnotation(point, className.includes('max') ? 'max' : 'min'), 300);
            });

            // Легенда (позиционируем адаптивно)
            if (!isSmallMobile) {
                const legendX = isMobile ? width - 120 : width - 140;
                const legendY = 20;
                
                const legend = svg.append("g")
                    .attr("class", "legend")
                    .attr("transform", `translate(${legendX + margin.left}, ${legendY + margin.top})`);

                /*[
                    { color: "#dc2626", label: "Максимум", y: 0 },
                    { color: "#16a34a", label: "Минимум", y: 18 }
                ].forEach(({ color, label, y }) => {
                    const legendItem = legend.append("g").attr("transform", `translate(0, ${y})`);
                    legendItem.append("circle")
                        .attr("r", 4)
                        .attr("fill", color)
                        .attr("stroke", "white")
                        .attr("stroke-width", 1);
                    legendItem.append("text")
                        .attr("x", 10)
                        .attr("y", 4)
                        .text(label)
                        .style("font-size", isMobile ? "10px" : "11px")
                        .attr("fill", "#374151");
                });*/
            }

            // Заголовок (адаптивный)
            /*svg.append("text")
                .attr("x", (width + margin.left + margin.right) / 2)
                .attr("y", margin.top / 2 + 5)
                .attr("text-anchor", "middle")
                .style("font-size", isSmallMobile ? "12px" : isMobile ? "14px" : "16px")
                .style("font-weight", "bold")
                .text(isSmallMobile ? "Динамика по месяцам" : "Динамика показателя по месяцам");*/
        }

        // Создание графика
        createChart();

        // Пересоздание графика при изменении размера окна
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(createChart, 250);
        });

    </script>--}}
@endPush

</x-layout>

