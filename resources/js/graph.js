initChart()

async function initChart() {
  let slug = window.location.pathname.replace('/key/', '')
  let response = await fetch(`/data/${slug}`)
  let data

   if (response.ok) { // если HTTP-статус в диапазоне 200-299
      // получаем тело ответа (см. про этот метод ниже)
      let json = await response.json();
      data = json.stats
      //console.log(data)
    } else {
      console.log("Ошибка HTTP: " + response.status);
      return
    }

  //return

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

      }