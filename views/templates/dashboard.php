<link rel="stylesheet" type="text/css" href="styles/charts.css">
<script src="js/Chart.js"></script>
<script src="js/utils.js"></script>
<?php $la_config = get_config('block_moodlean'); ?>

<section class="analyticsection">
    <h4>
        <?php echo get_string('performance_radar_title', "block_moodlean") ?>
        <div class="tooltip">
            <span class="visibletext">?</span>
            <span class="tooltiptext"><?php echo get_string('performance_radar_help', "block_moodlean") ?></span>
        </div>
    </h4>
    <section class="radarSection">
        <div class="radarWrapper">
            <canvas id="performance_radar_chart" height="500" width="500"></canvas>
        </div>
    </section>
</section>

<section class="analyticsection">
    <h4>
        <?php echo get_string('grades_timeline_title', "block_moodlean") ?>
        <div class="tooltip">
            <span class="visibletext">?</span>
            <span class="tooltiptext"><?php echo get_string('grades_timeline_help', "block_moodlean") ?></span>
        </div>
    </h4>
    <section class="radarSection">
        <?php
        $width = sizeof($all_course_grades[0]['labels']) * 100;
        $width = $width > 500 ? $width : 500;
        ?>
        <div class="chartWrapper">
            <div class="scrollChartContainer" style="width: 100%">
                <div class="chartAreaWrapper" style="width: <?php echo $width ?>px">
                    <canvas id="gradesTimeline" height="600" width="<?php echo $width ?>"></canvas>
                </div>
            </div>
        </div>
    </section>
</section>

<?php $datasets_num = sizeof($all_course_grades); ?>
<script>
    var ctx = document.getElementById("gradesTimeline").getContext("2d");

    var data = {
        labels: [<?php echo implode(", ", $all_course_grades[0]['labels']); ?>],
        datasets: [
            <?php $i = 1; foreach($all_course_grades as $course_grades) { ?>
            {
                data: [<?php echo implode(", ", $course_grades['values']); ?>],
                backgroundColor: convertHex(<?php echo "'".$la_config->chart_primary_color."', ".$la_config->chart_background_opacity/$i ; ?>),
                borderColor: convertHex(<?php echo "'".$la_config->chart_primary_color."', ".$la_config->chart_line_opacity/$i; ?>),
                borderWidth: 1
            }
            <?php ++$i;
            if($i <= $datasets_num){
            echo ",";
            }
            ?>
            <?php } ?>
        ]
    };

    new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        max: 10,
                        min: 0
                    }
                }]
            },
            legend: {
                display: false
            }
        }
    });


    var ctx = document.getElementById("performance_radar_chart");

    var data = {
        labels: [<?php echo implode(", ", $performance_radar[0]['labels']); ?>],
        datasets: [
            <?php $i = 1; foreach($performance_radar as $course_grades) { ?>
            {
                data: [<?php echo implode(", ", $course_grades['values']); ?>],
                backgroundColor: convertHex(<?php echo "'".$la_config->chart_primary_color."', ".$la_config->chart_background_opacity/$i ; ?>),
                borderColor: convertHex(<?php echo "'".$la_config->chart_primary_color."', ".$la_config->chart_line_opacity/$i; ?>),
                borderWidth: 1
            }
            <?php ++$i;
            if($i <= $datasets_num){
            echo ",";
            }
            ?>
            <?php } ?>
        ]
    };

    var options = {
        scale: {
            ticks: {
                beginAtZero: true,
                max: 1,
                maxTicksLimit: 5,
                callback: function (value) {
                    return ('' + value).substr(0, 3);
                }
            }
        },
        legend: {
            display: false
        }
    };

    var performanceRadar = new Chart(ctx, {
        type: 'radar',
        data: data,
        options: options
    })

</script>