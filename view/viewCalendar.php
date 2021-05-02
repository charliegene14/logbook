<?php  $pageTitle = 'Calendrier & Stats'; ?>
<?php  ob_start(); ?>

<section class="calendar">
    <div class="fullcal">
        <article>
            <div class="head">
                <h2>
                    <a href="?view=calendar&month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>">&lt;</a>
                    <?= $month->getMonth(); ?>
                    <a href="?view=calendar&month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>">&gt;</a>
                    &nbsp;&nbsp;
                    <a href="?view=calendar&month=<?= $month->month; ?>&year=<?= $month->previousYear()->year; ?>">&lt;</a>
                    <?= $month->getYear(); ?>
                    <a href="?view=calendar&month=<?= $month->month; ?>&year=<?= $month->nextYear()->year; ?>">&gt;</a>
                </h2>
                <a href="#stats">Voir les statistiques &darr;</a>
            </div>
            <p style="margin: 0"><i>Passez sur les pastilles pour plus de détails !</i></p>
            <table>
                <thead>
                    <tr>
                        <th>Lun.</th>
                        <th>Mar.</th>
                        <th>Mer.</th>
                        <th>Jeu.</th>
                        <th>Ven.</th>
                        <th>Sam.</th>
                        <th>Dim.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($week = 0; $week < $month->getWeeks(); $week++) : ?>
                        <tr>
                            <?php
                            for ($day = 0; $day < 7; $day++) {
                                $daydate = (clone $firstGridDay)->modify('+ ' . ($day + $week * 7) . 'days');

                                if (!$month->isInMonth($daydate)) {
                                    echo '<td class="notMonth">' . $daydate->format('d') . '</td>';
                                } else {
                                    echo '<td ';
                                    if (date('Y-m-d') == $daydate->format('Y-m-d')) {
                                        echo 'class="todayDate"';
                                    }
                                    echo '>';
                                    echo $daydate->format('d');
                                    foreach ($postsMonth as $post) {
                                        if ($post['datePost'] == $daydate->format('Y-m-d')) { ?>
                                            <a href="?view=fullpost&id=<?= $post['idPost'] ?>" class="calPost" style="background-color: <?= $post['colorCat'] ?>"></a>
                                            <div class="calPreview">
                                                <p>
                                                    <i><?= $post['titlePost'] ?></i><br />
                                                    <img src="public/css/workPost.png" />
                                                    <?php if ($post['nameWork'] != null) {
                                                        echo $post['nameWork'];
                                                    } else {
                                                        echo 'Aucune partie de travail';
                                                    } ?>
                                                    <br />
                                                    <img src="public/css/toolPost.png" />
                                                    <?php if ($post['nameTool'] != null) {
                                                        echo $post['nameTool'];
                                                    } else {
                                                        echo 'Aucun outil utilisé';
                                                    } ?>
                                                    <br />
                                                    <img src="public/css/timePost.png" /> <b><?= $regex->time($post['timePost']) ?></b>
                                                </p>
                                            </div>
                                        <?php }
                                    }
                                    echo '</td>';
                                }
                            }
                            ?>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </article>

        <aside class="cal_legends">
            <?php while ($cat = $listCats->fetch()) : ?>
                <p><span class="color" style="background-color: <?= $cat['colorCat'] ?>"></span> <?= $cat['nameCat'] ?></p>
            <?php endwhile; ?>
        </aside>
    </div>

    <div class="cal_stats" id="stats">
        <div class="this_month">
            <div class="digits">
                <h1 style="color: rgba(23, 23, 36, 0.8)">Ce mois</h1>
                <h2><?= $month->getMonth() . ' ' . $month->getYear() ?>: <?= $regex->time($totalHoursInMonth['totalStr']) ?></h2>
                <h2>Moyenne: <?= $regex->time($totalAverageHoursInMonth) ?></h2>
            </div>

            <div class="donut_chart">
                <canvas id="monthCats"></canvas>
                <div class="centerDonutChart">
                    <h3>Projets</h3>
                    <p>heure/prj</p>
                </div>
            </div>

            <div class="donut_chart">
                <canvas id="monthTools"></canvas>
                <div class="centerDonutChart">
                    <h3>Outils</h3>
                    <p>heure/outil</p>
                </div>
            </div>
        </div>

        <div class="this_year">
            <div class="digits">
                <h1 style="color: rgba(23, 23, 36, 0.8)">Cette année</h1>
                <h2><?= $month->getYear() ?>: <?= $regex->time($totalHoursInYear) ?></h2>
            </div>

            <div class="year_charts" style="display: flex">
                <div class="box">
                    <div class="cats_charts" style="display: flex">

                        <div class="donut_chart">
                            <canvas id="yearCatsDonut"></canvas>
                            <div class="centerDonutChart">
                                <h3>Projets</h3>
                                <p>heure/prj</p>
                            </div>
                        </div>

                        <div class="chart">
                            <canvas id="yearCatsBar"></canvas>
                        </div>

                    </div>
                    <div class="tools_charts" style="display: flex">

                        <div class="donut_chart">
                            <canvas id="yearToolsDonut"></canvas>
                            <div class="centerDonutChart">
                                <h3>Outils</h3>
                                <p>heure/outil</p>
                            </div>
                        </div>

                        <div class="chart">
                            <canvas id="yearToolsBar"></canvas>
                        </div>

                    </div>
                </div>
                <div class="radar">
                    <canvas id="yearRadar"></canvas>
                </div>
            </div>
        </div>

        <div class="global" style="display: flex">
            <div class="digits">
                <h1 style="color: rgba(23, 23, 36, 0.8)">Globalement</h1>
                <h2>Au total: <?= $regex->time($dbPosts->getTotalHours()) ?></h2>
            </div>

            <div class="donut_chart">
                <canvas id="globalCats"></canvas>
                <div class="centerDonutChart">
                    <h3>Projets</h3>
                    <p>heure/prj</p>
                </div>
            </div>

            <div class="donut_chart">
                <canvas id="globalTools"></canvas>
                <div class="centerDonutChart">
                    <h3>Outils</h3>
                    <p>heure/outil</p>
                </div>
            </div>
        </div>
    </div>

</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@next"></script>

<script type="text/javascript">
    Chart.register({
        ChartDataLabels,
    });

    function alphaTranform(color) {
        let colorAlphaRegx = /(, ?0\.)[0-9]/g;
        let colorWithoutAlpha = color.replace(colorAlphaRegx, ', 0.8');

        return colorWithoutAlpha;
    }

    var colorScheme = [
        'rgba(30, 50, 49,0.4)',
        'rgba(72, 86, 101,0.4)',
        'rgba(142, 124, 147,0.4)',
        'rgba(208, 165, 192,0.4)',
        'rgba(246, 192, 208,0.4)',
        'rgba(251, 196, 171,0.4)',
        'rgba(255, 218, 185,0.4)',
        'rgba(209, 227, 221,0.4)',
        'rgba(100, 166, 189,0.4)',
        'rgba(227, 210, 111,0.4)',
        'rgba(13, 0, 164,0.4)',
        'rgba(34, 0, 124,0.4)',
        'rgba(162, 37, 34,0.4)',
        'rgba(143, 133, 125,0.4)',
        'rgba(107, 109, 118,0.4)',
    ];

    var toolColor = new Object();

    var optionsBar = {
        plugins: {
            legend: {
                display: false,
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            },
        }
    };

    var options = {
        plugins: {
            legend: {
                display: false,
            },
            datalabels: {
                formatter: (value, ctx) => {
                    let total = 0;
                    let dataArr = ctx.dataset.data;
                    dataArr.forEach((data) => {
                        total += parseFloat(data);
                    });

                    let percentage = (value * 100 / total).toFixed(0);

                    if (percentage < 10) {
                        return null;
                    }

                    return percentage + "%";
                },
                color: '#000000',
                font: {
                    size: (document.getElementsByClassName('donut_chart')[0].clientWidth) / 14
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        var data = context.parsed;

                        if (data % 1 != 0) {
                            var hour = Math.floor(data);
                            var min = Math.round((data % 1).toFixed(3) * 60);

                            if (min < 10) {
                                min = '0' + min;
                            }

                            return context.label + ': ' + hour + 'h' + min;

                        } else {
                            return context.label + ': ' + data + 'h';
                        }
                    }
                }
            }
        },
    };

    var ctxMonthCats = document.getElementById('monthCats').getContext('2d');
    var ctxMonthTools = document.getElementById('monthTools').getContext('2d');
    var ctxYearCats = document.getElementById('yearCatsDonut').getContext('2d');
    var ctxYearCatsBar = document.getElementById('yearCatsBar').getContext('2d');
    var ctxYearTools = document.getElementById('yearToolsDonut').getContext('2d');
    var ctxYearToolsBar = document.getElementById('yearToolsBar').getContext('2d');
    var ctxGlobalCats = document.getElementById('globalCats').getContext('2d');
    var ctxGlobalTools = document.getElementById('globalTools').getContext('2d');

    var monthCats = new Chart(ctxMonthCats, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [],
                borderColor: [],
                hoverOffset: 3
            }]
        },
        options
    });

    var monthTools = new Chart(ctxMonthTools, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [],
                borderColor: [],
                hoverOffset: 3
            }]
        },
        options
    });

    var yearCats = new Chart(ctxYearCats, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [],
                borderColor: [],
                hoverOffset: 3
            }]
        },
        options
    });

    var yearTools = new Chart(ctxYearTools, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [],
                borderColor: [],
                hoverOffset: 3
            }]
        },
        options
    });

    var globalCats = new Chart(ctxGlobalCats, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [],
                borderColor: [],
                hoverOffset: 3
            }]
        },
        options
    });

    var globalTools = new Chart(ctxGlobalTools, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [],
                borderColor: [],
                hoverOffset: 3
            }]
        },
        options
    });

    var yearCatsBar = new Chart(ctxYearCatsBar, {
        type: 'bar',
        data: {
            labels: [
                'Jan.', 'Fev.', 'Mar.', 'Avr.', 'Mai', 'Juin', 'Jui.', 'Aou.', 'Sep.', 'Oct.', 'Nov.', 'Dec.'
            ],
            datasets: [{
                    data: [],
                    label: 'HTML',
                    backgroundColor: 'red',
                },
                {
                    data: [78, 19, 18, 174, 41, 58, 69, 57, 11, 50, 250, 74],
                    label: 'JS',
                    backgroundColor: 'yellow',
                },
                {
                    data: [15, 11, 18, 100, 45, 58, 69, 54, 11, 48, 250, 74],
                    label: 'CSS',
                    backgroundColor: 'blue',
                }
            ]
        },
        options: optionsBar
    });

    var yearToolsBar = new Chart(ctxYearToolsBar, {
        type: 'bar',
        data: {
            labels: [
                'Jan.', 'Fev.', 'Mar.', 'Avr.', 'Mai', 'Juin', 'Jui.', 'Aou.', 'Sep.', 'Oct.', 'Nov.', 'Dec.'
            ],
            datasets: [
                {
                    data: [0, 11, 18, 100, 45, 58, 69, 54, 11, 48, 250, 74],
                    label: 'HTML',
                    backgroundColor: 'red',
                },
                {
                    data: [50],
                    label: 'HTML',
                    backgroundColor: 'red',
                },
                {
                    data: [78, 19, 18, 174, 41, 58, 69, 57, 11, 50, 250, 74],
                    label: 'JS',
                    backgroundColor: 'yellow',
                },
                {
                    data: [15, 11, 18, 100, 45, 58, 69, 54, 11, 48, 250, 74],
                    label: 'CSS',
                    backgroundColor: 'blue',
                }
            ]
        },
        options: optionsBar
    });

    var dbDataMonthCats              = <?= $catsHoursInMonth ?>;
    var dbDataMonthTools             = <?= $toolsHoursInMonth ?>;
    var dbDataYearCats               = <?= $catsHoursInYear ?>;
    var dbDataYearTools              = <?= $toolsHoursInYear ?>;
    var dbDataGlobalCats             = <?= $catsHours ?>;
    var dbDataGlobalTools            = <?= $toolsHours ?>;
    var dbDataCatsHoursInAllMonths   = <?= $jsCatsInAllMonth ?>;
    var dbDataToolsHoursInAllMonths  = <?= $jsToolsInAllMonth ?>;

    var allMonthsCatData             = {};
    var allMonthsToolData            = {};

    dbDataGlobalTools.forEach((tool, index) => {
        let color = colorScheme[Math.floor(Math.random() * colorScheme.length)];
        let border = alphaTranform(color);

        globalTools.data.labels.push(tool.nameTool);
        globalTools.data.datasets[0].data.push(tool.totalFloat);
        globalTools.data.datasets[0].backgroundColor.push(color);
        globalTools.data.datasets[0].borderColor.push(border);

        toolColor[tool.nameTool] = color;
    });

    dbDataMonthCats.forEach((cat, index) => {
        monthCats.data.labels.push(cat.nameCat);
        monthCats.data.datasets[0].data.push(cat.totalFloat);
        monthCats.data.datasets[0].backgroundColor.push(cat.colorCat);
        monthCats.data.datasets[0].borderColor.push(cat.colorCat);
    });

    dbDataYearCats.forEach((cat, index) => {
        yearCats.data.labels.push(cat.nameCat);
        yearCats.data.datasets[0].data.push(cat.totalFloat);
        yearCats.data.datasets[0].backgroundColor.push(cat.colorCat);
        yearCats.data.datasets[0].borderColor.push(cat.colorCat);
    });

    dbDataGlobalCats.forEach((cat, index) => {
        globalCats.data.labels.push(cat.nameCat);
        globalCats.data.datasets[0].data.push(cat.totalFloat);
        globalCats.data.datasets[0].backgroundColor.push(cat.colorCat);
        globalCats.data.datasets[0].borderColor.push(cat.colorCat);
    });

    dbDataMonthTools.forEach((tool, index) => {
        let color = toolColor[tool.nameTool];
        let border = alphaTranform(color);

        monthTools.data.labels.push(tool.nameTool);
        monthTools.data.datasets[0].data.push(tool.totalFloat);
        monthTools.data.datasets[0].backgroundColor.push(color);
        monthTools.data.datasets[0].borderColor.push(border);
    });

    dbDataYearTools.forEach((tool, index) => {
        let color = toolColor[tool.nameTool];
        let border = alphaTranform(color);

        yearTools.data.labels.push(tool.nameTool);
        yearTools.data.datasets[0].data.push(tool.totalFloat);
        yearTools.data.datasets[0].backgroundColor.push(color);
        yearTools.data.datasets[0].borderColor.push(border)
    });

    dbDataCatsHoursInAllMonths.map(array => {
        array.map(data => {
            allMonthsCatData[data.nameCat] = {
                color: data.colorCat,
                months: {
                    1: '',
                    2: '',
                    3: '',
                    4: '',
                    5: '',
                    6: '',
                    7: '',
                    8: '',
                    9: '',
                    10: '',
                    11: '',
                    12: '',
                }
            };
        });
    });

    dbDataToolsHoursInAllMonths.map(array => {
        array.map(data => {
            allMonthsToolData[data.nameTool] = {
                color: toolColor[data.nameTool],
                months: {
                    1: '',
                    2: '',
                    3: '',
                    4: '',
                    5: '',
                    6: '',
                    7: '',
                    8: '',
                    9: '',
                    10: '',
                    11: '',
                    12: '',
                }
            };
        });
    });

    dbDataCatsHoursInAllMonths.map(array => {
        array.map(data => {
            Object.keys(allMonthsCatData[data.nameCat].months).forEach(month => {
                if (month == data.Month) {
                    allMonthsCatData[data.nameCat].months[month] = data.totalFloat;
                }
            });
        });
    });

    dbDataToolsHoursInAllMonths.map(array => {
        array.map(data => {
            Object.keys(allMonthsToolData[data.nameTool].months).forEach(month => {
                if (month == data.Month) {
                    allMonthsToolData[data.nameTool].months[month] = data.totalFloat;
                }
            });
        });
    });
 
    console.log(allMonthsToolData)

    monthCats.update();
    monthTools.update();
    yearCats.update();
    yearTools.update();
    globalCats.update();
    globalTools.update();
    yearCatsBar.update();
    yearToolsBar.update();
</script>

<?php $pageContent = ob_get_clean(); ?>
<?php require 'template.php'; ?>