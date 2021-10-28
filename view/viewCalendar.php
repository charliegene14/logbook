<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/controller/viewCalendar.php'; ?>

<section id="calendar">

    <div class="title-section" id="header">
        <h1>Calendrier & Stats.</h1>
        <div id="header-link">
            <a onClick="goToByScroll('calendar-container')">Calendrier.</a>
            <a onClick="goToByScroll('stats-container')">Statistiques.</a>
        </div>
    </div>

    <div class="content-section">
        <div id="calendar-container">
            <div class="page-calendar-head" id="calendar-header">
                <div class="blur-bg"></div>
                <h2 class="calendar-change">
                    <a href="/#!/stats?month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>">&lt;</a>
                    <?= $month->getMonth(); ?>
                    <a href="/#!/stats?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>">&gt;</a>
                    <a href="/#!/stats?month=<?= $month->month; ?>&year=<?= $month->previousYear()->year; ?>">&lt;</a>
                    <?= $month->getYear(); ?>
                    <a href="/#!/stats?month=<?= $month->month; ?>&year=<?= $month->nextYear()->year; ?>">&gt;</a>
                </h2>
                <p>Passez sur les pastilles et les graphiques pour plus de détails.</p>
            </div>
                
            <table id="calendar-body">
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
                <?php for ($week = 0; $week < $month->getWeeks(); $week++):?>
                    <tr>
                    <?php
                    for ($day = 0; $day < 7; $day++) {
                        $daydate = (clone $firstGridDay)->modify('+ ' . ($day + $week * 7) . 'days');

                        if (!$month->isInMonth($daydate)) {
                            echo '<td class="not-month">' . $daydate->format('d') . '</td>';
                        } else {
                            echo '<td ';
                            if (date('Y-m-d') == $daydate->format('Y-m-d')) {
                                echo 'class="today-date"';
                            }
                            echo '>';
                            echo $daydate->format('d');

                            foreach ($postsMonth as $post) {
                                if ($post['datePost'] == $daydate->format('Y-m-d')) { ?>
                                    <div class="calendar-post-container">

                                        <div
                                            class="calendar-chip-post"
                                            style="background-color: <?= $post['colorCat'] ?>">
                                        </div>
                                        
                                        <div class="calendar-post">
                                            <div class="blur-bg"></div>
                                            <div class="calendar-title-post">
                                                <a href="/#!/posts/<?= $post['idPost'] ?>"><?= $post['titlePost'] ?></a>
                                            </div>

                                            <div class="calendar-work-post">
                                                <div class="svg-work"></div>
                                                <p>
                                                <?php
                                                if ($post['nameWork'] != null) {
                                                    echo $post['nameWork'];
                                                } else {
                                                    echo 'Aucune partie de travail';
                                                }?>
                                                </p>
                                            </div>
                                            
                                            <div class="calendar-tools-post-container">
                                                <?php
                                                $tools = $dbPosts->getTools($post['idPost']);

                                                if ($tools != NULL) {
                                                    foreach ($tools as $tool ) {
                                                        echo '<div class="calendar-tool-post">';
                                                        if ($tool['nameTool'] == NULL) {
                                                            echo '<div class="svg-none"></div>';
                                                        } else {
                                                            echo '<img class="svg-tool" src="/public/img/tools/' .$tool['idTool']. '.svg" />';
                                                        }
                                                        echo '<p>' .$regex->time($tool['timeTool']). '</p>';
                                                        echo '</div>';
                                                    }                 
                                                } else {
                                                    echo '<div class="calendar-tool-post>';
                                                    echo '<div class="svg-none"></div>';
                                                    echo '<p>Aucun outil</p>';
                                                    echo '</div>';
                                                }?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            </td>
                        <?php } ?>
                    <?php } ?>        
                    </tr>
                <?php endfor; ?>


                    </tbody>
                </table>
            </article>

            <aside id="calendar-legend">
                <?php while ($cat = $listCats->fetch()) : ?>
                    <p><span class="color-legend" style="background-color: <?= $cat['colorCat'] ?>"></span> <?= $cat['nameCat'] ?></p>
                <?php endwhile; ?>
            </aside>
        </div>

        <div class="main-arrow-down" onClick="goToByScroll('stats-container')"></div>

        <div id="stats-container">
            <div class="this_month">
                <div class="page-calendar-head">
                    <div class="blur-bg"></div>
                    <h2>Ce mois-ci</h2>
                    <p><b><?= $month->getMonth() . ' ' . $month->getYear() ?>:</b> <?= $regex->time($totalHoursInMonth['totalStr']) ?> (total).</p>
                    <p><b>Moyenne:</b> <?= $regex->time($totalAverageHoursInMonth) ?>.</p>
                </div>

                <div class="charts-container">
                    <div class="donut_chart chart">
                        <?php if (!empty(json_decode($catsHoursInMonth))):?>
                        <canvas id="monthCats"></canvas>
                        <div class="centerDonutChart">
                            <h3>Projets</h3>
                            <p>heures/prj</p>
                        </div>
                        <?php else: ?>
                            <canvas id="monthCats" style="display: none;"></canvas>
                            <p>Heures/Projet: graphique indisponible, aucune donnée.</p>
                        <?php endif; ?>
                    </div>

                    <div class="donut_chart chart">
                        <?php if (!empty(json_decode($toolsHoursInMonth))):?>
                        <canvas id="monthTools"></canvas>
                        <div class="centerDonutChart">
                            <h3>Outils</h3>
                            <p>heures/outil</p>
                        </div>
                        <?php else: ?>
                            <canvas id="monthTools" style="display: none;"></canvas>
                            <p>Heures/Outil: graphique indisponible, aucune donnée.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="this_year">
                <div class="page-calendar-head">
                    <div class="blur-bg"></div>
                    <h2>Cette année</h2>
                    <p><b><?= $month->getYear() ?>:</b> <?= $regex->time($totalHoursInYear) ?>.</p>
                </div>

                <div class="cats_charts charts-container">
                    <div class="donut_chart chart">
                        <?php if (!empty(json_decode($catsHoursInYear))):?>
                        <canvas id="yearCatsDonut"></canvas>
                        <div class="centerDonutChart">
                            <h3>Projets</h3>
                            <p>heure/prj</p>
                        </div>
                        <?php else: ?>
                        <canvas id="yearCatsDonut" style="display: none;"></canvas>
                        <p>Heures/Projet: graphique indisponible, aucune donnée.</p>
                        <?php endif; ?>
                    </div>

                    

                    <div class="bar_chart chart">
                        <?php if (!empty(json_decode($jsCatsInAllMonths))):?>
                        <canvas id="yearCatsBar"></canvas>
                        <?php else : ?>
                        <canvas id="yearCatsBar" style="display: none;"></canvas>
                        <p>Heures/Projet/Mois: graphique indisponible, aucune donnée.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="tools_charts charts-container">
                    <div class="donut_chart chart">
                        <?php if (!empty(json_decode($toolsHoursInYear))):?>
                        <canvas id="yearToolsDonut"></canvas>
                        <div class="centerDonutChart">
                            <h3>Outils</h3>
                            <p>heure/outil</p>
                        </div>
                        <?php else: ?>
                        <canvas id="yearToolsDonut" style="display: none;"></canvas>
                        <p>Heures/Outil: graphique indisponible, aucune donnée.</p>
                        <?php endif; ?>
                    </div>

                    <div class="bar_chart chart">
                        <?php if (!empty(json_decode($jsToolsInAllMonths))):?>
                        <canvas id="yearToolsBar"></canvas>
                        <?php else: ?>
                        <canvas id="yearToolsBar" style="display: none;"></canvas>
                        <p>Heures/Outil/Mois: graphique indisponible, aucune donnée.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="charts-container">
                    <div class="radar_chart chart">
                        <?php if (!empty(json_decode($jsTotalInAllMonths))):?>
                        <canvas id="yearRadar"></canvas>
                        <?php else: ?>
                        <canvas id="yearRadar" style="display: none;"></canvas>
                        <p>Heures/Mois: graphique indisponible, aucune donnée.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="global">
                <div class="page-calendar-head">
                    <div class="blur-bg"></div>
                    <h2>Globalement</h2>
                    <p><b>Au total:</b> <?= $regex->time($dbPosts->getTotalHours()) ?>.</p>
                </div>

                <div class="charts-container">
                    <div class="donut_chart chart">
                        <?php if (!empty(json_decode($catsHours))):?>
                            <canvas id="globalCats"></canvas>
                            <div class="centerDonutChart">
                                <h3>Projets</h3>
                                <p>heure/prj</p>
                            </div>
                        <?php else: ?>
                                <canvas id="globalCats" style="display: none;"></canvas>
                                <p>Heures/Projet (total): graphique indisponible, aucune donnée.</p>
                        <?php endif; ?>
                    </div>

                    <div class="donut_chart chart">
                        <?php if (!empty(json_decode($toolsHours))):?>
                            <canvas id="globalTools"></canvas>
                            <div class="centerDonutChart">
                                <h3>Outils</h3>
                                <p>heure/outil</p>
                            </div>
                        <?php else: ?>
                                <canvas id="globalTools" style="display: none;"></canvas>
                                <p>Heures/Outil (total): graphique indisponible, aucune donnée.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    var dbDataMonthCats              = <?= $catsHoursInMonth ?>;
    var dbDataMonthTools             = <?= $toolsHoursInMonth ?>;
    var dbDataYearCats               = <?= $catsHoursInYear ?>;
    var dbDataYearTools              = <?= $toolsHoursInYear ?>;
    var dbDataGlobalCats             = <?= $catsHours ?>;
    var dbDataGlobalTools            = <?= $toolsHours ?>;
    var dbDataCatsHoursInAllMonths   = <?= $jsCatsInAllMonths ?>;
    var dbDataToolsHoursInAllMonths  = <?= $jsToolsInAllMonths ?>;
    var dbDataTotalHoursInAllMonths  = <?= $jsTotalInAllMonths ?>;

    document.title = 'Calendrier & Stats.';
</script>

<script src="/public/js/viewCalendar.js"></script>
</section>