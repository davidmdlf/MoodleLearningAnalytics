<link rel="stylesheet" type="text/css" href="styles/charts.css">
<script src="js/Chart.js"></script>
<script src="js/utils.js"></script>
<?php $la_config = get_config('block_moodlean'); ?>

<div class="chartWrapper">
    <div class="chartAreaWrapper">
        <canvas id="grade_evolution_chart" width="1200" height="500"></canvas>
    </div>
    <canvas id="myChartAxis" height="500" width="0"></canvas>
</div>

<div style="width: 50%; height: 400px">
    <canvas id="performance_radar_chart" height="500" width="500"></canvas>
</div>

<script>
    var ctx = document.getElementById("grade_evolution_chart");

    var data = {
        labels: [<?php echo implode(", ", $all_course_grades['labels']); ?>],
        datasets: [{
            data: [<?php echo implode(", ", $all_course_grades['grades']); ?>],
            backgroundColor: convertHex(<?php echo "'".$la_config->chart_primary_color."', ".$la_config->chart_background_opacity; ?>),
            borderColor: convertHex(<?php echo "'".$la_config->chart_primary_color."', ".$la_config->chart_line_opacity; ?>),
            borderWidth: 1
        }]
    }

    var options = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    max: 10
                }
            }]
        },
        legend: {
            display: false
        },
        title: {
            display: true,
            text: 'Evolución de calificaciones'
        }
    }

    var myChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: options
    });


    var ctx = document.getElementById("performance_radar_chart");

    var data = {
        labels: [<?php echo implode(", ", $performance_radar['labels']); ?>],
        datasets: [{
            data: [<?php echo implode(", ", $performance_radar['ratios']); ?>],
            backgroundColor: convertHex(<?php echo "'".$la_config->chart_primary_color."', ".$la_config->chart_background_opacity; ?>),
            borderColor: convertHex(<?php echo "'".$la_config->chart_primary_color."', ".$la_config->chart_line_opacity; ?>),
            borderWidth: 1
        }]
    }

    var options = {
        scale: {
            ticks: {
                beginAtZero: true,
                max: 1,
                maxTicksLimit: 5,
                callback: function(value) { return ('' + value).substr(0, 3); }
            }
        },
        legend: {
            display: false
        },
        title: {
            display: true,
            text: 'Ratio de rendimiento por tipo de prueba'
        }
    }

    var performanceRadar = new Chart(ctx, {
        type: 'radar',
        data: data,
        options: options
    })

</script>
