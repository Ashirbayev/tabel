<br />
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right"></span>
                <h5>Образование</h5>
            </div>
            <div class="ibox-content">
                <div id="piechart2" style="width: 900px; height: 500px;"></div>
            </div>
        </div>
    </div>
</div>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>По возрасту</h5>
    </div>
    <div class="ibox-content">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Возраст</th>
                <th>Число сотрудников на 31.12.2017</th>
                <th>Удельный вес</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>До 20 лет</td>
                <td>0</td>
                <td class="text-navy"> 0 %</td>
            </tr>
            <tr>
                <td>От 20 до 29 лет</td>
                <td>48</td>
                <td class="text-navy"> 35.036496350365 %</td>
            </tr>
            <tr>
                <td>От 30 до 39 лет</td>
                <td>62</td>
                <td class="text-navy"> 45.255474452555 %</td>
            </tr>
            <tr>
                <td>От 40 до 49 лет</td>
                <td>19</td>
                <td class="text-navy"> 13.868613138686 %</td>
            </tr>
            <tr>
                <td>От 50 до 59 лет</td>
                <td>7</td>
                <td class="text-navy"> 5.1094890510949 %</td>
            </tr>
            <tr>
                <td>От 60 и старше</td>
                <td>1</td>
                <td class="text-navy"> 0.72992700729927 %</td>
            </tr>
            
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>По стажу</h5>
            </div>
            <div class="ibox-content">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Стаж</th>
                        <th>Число сотрудников на 31.12.2017</th>
                        <th>Удельный вес</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td>До 1 года</td>
                        <td>55</td>
                        <td class="text-navy"> 40.14598540146 %</td>
                    </tr>
                    <tr>
                        <td>От 1 до 5 лет</td>
                        <td>43</td>
                        <td class="text-navy"> 31.386861313869 %</td>
                    </tr>
                    <tr>
                        <td>От 5 до 10 лет</td>
                        <td>35</td>
                        <td class="text-navy"> 25.547445255474 %</td>
                    </tr>
                    <tr>
                        <td>От 10 до 20 лет</td>
                        <td>4</td>
                        <td class="text-navy"> 2.9197080291971 %</td>
                    </tr>
                    <tr>
                        <td>Свыше 20 лет</td>
                        <td>-</td>
                        <td class="text-navy"> 0 %</td>
                    </tr>
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right"></span>
                <h5>Гендер</h5>
            </div>
            <div class="ibox-content">
                <div class="row text-center">
                    <div class="col-lg-8">
                        <canvas id="doughnutChart" width="400" height="400"></canvas>
                        <h5>Гендерное деление на сегодня</h5>
                    </div>
                    <div class="col-lg-4">
                        <div class=" m-l-md">
                            <span class="h4 font-bold m-t block"> 29.530201342282 %</span>
                            <small class="text-muted m-b block">Мужчин</small>
                        </div>
                        <div class=" m-l-md">
                            <span class="h4 font-bold m-t block"> 70.469798657718 %</span>
                            <small class="text-muted m-b block">Женщин</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right"></span>
                <h5>Средний возраст сотрудников</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">38.121951219512</h1>
                <div class="stat-percent font-bold text-success"></div>
                <small>лет</small>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right"></span>
                <h5>Средний возраст руководителей</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">38.121951219512</h1>
                <div class="stat-percent font-bold text-success"></div>
                <small>лет</small>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right"></span>
                <h5>В среднем сотрудники в компании работают</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">19.974757281553</h1>
                <div class="stat-percent font-bold text-success"></div>
                <small>месяцев</small>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var data1 = [
            [0,4],[1,8],[2,5],[3,10],[4,4],[5,16],[6,5],[7,11],[8,6],[9,11],[10,30],[11,10],[12,13],[13,4],[14,3],[15,3],[16,6]
        ];
        var data2 = [
            [0,1],[1,0],[2,2],[3,0],[4,1],[5,3],[6,1],[7,5],[8,2],[9,3],[10,2],[11,1],[12,0],[13,2],[14,8],[15,0],[16,0]
        ];
        $('#flot-dashboard-chart').length && $.plot($('#flot-dashboard-chart'), [
            data1, data2
        ],
                {
                    series: {
                        lines: {
                            show: false,
                            fill: true
                        },
                        splines: {
                            show: true,
                            tension: 0.4,
                            lineWidth: 1,
                            fill: 0.4
                        },
                        points: {
                            radius: 0,
                            show: true
                        },
                        shadowSize: 2
                    },
                    grid: {
                        hoverable: true,
                        clickable: true,
                        tickColor: '#d5d5d5',
                        borderWidth: 1,
                        color: '#d5d5d5'
                    },
                    colors: ['#1ab394', '#1C84C6'],
                    xaxis:{
                    },
                    yaxis: {
                        ticks: 4
                    },
                    tooltip: false
                }
        );

        var doughnutData = [
            {
                value: 44,
                color: '#a3e1d4',
                highlight: '#1ab394',
                label: 'Мужчин'
            },
            {
                value: 105,
                color: '#A4CEE8',
                highlight: '#1ab394',
                label: 'Женщин'
            }
        ];

        var doughnutOptions = {
            segmentShowStroke: true,
            segmentStrokeColor: '#fff',
            segmentStrokeWidth: 2,
            percentageInnerCutout: 45, // This is 0 for Pie charts
            animationSteps: 100,
            animationEasing: 'easeOutBounce',
            animateRotate: true,
            animateScale: false
        };

        var ctx = document.getElementById('doughnutChart').getContext('2d');
        var DoughnutChart = new Chart(ctx).Doughnut(doughnutData, doughnutOptions);

        var polarData = [
            {
                value: 300,
                color: '#a3e1d4',
                highlight: '#1ab394',
                label: 'App'
            },
            {
                value: 140,
                color: '#dedede',
                highlight: '#1ab394',
                label: 'Software'
            },
            {
                value: 200,
                color: '#A4CEE8',
                highlight: '#1ab394',
                label: 'Laptop'
            }
        ];

        var polarOptions = {
            scaleShowLabelBackdrop: true,
            scaleBackdropColor: 'rgba(255,255,255,0.75)',
            scaleBeginAtZero: true,
            scaleBackdropPaddingY: 1,
            scaleBackdropPaddingX: 1,
            scaleShowLine: true,
            segmentShowStroke: true,
            segmentStrokeColor: '#fff',
            segmentStrokeWidth: 2,
            animationSteps: 100,
            animationEasing: 'easeOutBounce',
            animateRotate: true,
            animateScale: false
        };
        var ctx = document.getElementById('polarChart').getContext('2d');
        var Polarchart = new Chart(ctx).PolarArea(polarData, polarOptions);

    });
</script>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {

    var data = google.visualization.arrayToDataTable([
      ['Бакалавр', 'Hours per Day'],
      ['Болашак/Назарбаев Университет',      10],
      ['Магистратура',  40],
      ['Бакалавр', 150],
      ['Среднее специальное',     110]
    ]);

    var options = {
      title: ''
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

    chart.draw(data, options);
  }
</script>

