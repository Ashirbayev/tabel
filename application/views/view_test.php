
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
                        <td></td>
                        <td class="text-navy"> 10 %</td>
                    </tr>
                    <tr>
                        <td>От 1 до 5 лет</td>
                        <td></td>
                        <td class="text-navy"> 10 %</td>
                    </tr>
                    <tr>
                        <td>От 5 до 10 лет</td>
                        <td></td>
                        <td class="text-navy">10 %</td>
                    </tr>
                    <tr>
                        <td>От 10 до 20 лет</td>
                        <td></td>
                        <td class="text-navy"> 10 %</td>
                    </tr>
                    <tr>
                        <td>Свыше 20 лет</td>
                        <td>-</td>
                        <td class="text-navy"> 10 %</td>
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
                            <span class="h4 font-bold m-t block">10 %</span>
                            <small class="text-muted m-b block">Мужчин</small>
                        </div>
                        <div class=" m-l-md">
                            <span class="h4 font-bold m-t block">10 %</span>
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
                <h1 class="no-margins">10</h1>
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
                <h1 class="no-margins">10</h1>
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
                <h1 class="no-margins">10</h1>
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
                value: '10',
                color: '#a3e1d4',
                highlight: '#1ab394',
                label: 'Мужчин'
            },
            {
                value: '10',
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