<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/controller/viewFullproject.php'; ?>

<section id="fullproject">

		<div class="title-section">
			<img src="public/img/projects/<?= $PROJ['idProject'] ?>.png" alt="<?= $PROJ['titleProject'] ?>" />
			<div id="header-project">
				<h1 style="color: <?= $PROJ['colorCat'] ?>"><?= $PROJ['titleProject'] ?>.</h1>

				<div id="link-header-project">
					<a onClick="goToByScroll('preview')">Résumé.</a>
					<a onClick="goToByScroll('stats')">Statistiques.</a>
					<a onClick="goToByScroll('file')">Fiche.</a>
				</div>
			</div>
		</div>
	
	<div class="content-section">
		<article id="info">
			<div class="blur-bg"></div>
			<p><b>Genre(s): </b><?= $PROJ['kindProject'] ?></p>
			<p><b>Plateforme(s): </b><?= $PROJ['platformProject'] ?></p>
			<p><b>Date de commencement: </b><?= $regex->date($PROJ['dateProject']) ?></p>
			<p><b>Version actuelle: </b>
				<?php
				if ($lastVersion = $dbProj->getLastVersion($PROJ['idProject'])) {
					echo '<a href="/#!/versions/' . $PROJ['idProject'] . '#' . $lastVersion['theVersion'] . '">' . $lastVersion['theVersion'] . '</a> - ';
					echo $regex->date($lastVersion['dateVersion']) . ' (<a href="/#!/versions/' . $PROJ['idProject'] . '">historique</a>)';
				} else {
					echo 'Aucune version disponible.';
				}
				?>
			</p>
			<p><b>Premier article: </b>
				<?php
				if ($firstPost = $dbProj->getFirstPost($PROJ['idProject'])) {
					echo '<a href="/#!/posts/' . $firstPost['idPost'] . '">' . $firstPost['titlePost'] . '</a>(le ' . $regex->date($firstPost['datePost']) . ')';
				} else {
					echo 'Aucun article disponible.';
				}
				?>
			</p>
			<p><b>Dernier article: </b>
				<?php
				if ($lastPost = $dbProj->getLastPost($PROJ['idProject'])) {
					echo '<a href="/#!/posts/' . $lastPost['idPost'] . '">' . $lastPost['titlePost'] . '</a>(le ' . $regex->date($lastPost['datePost']) . ')';
				} else {
					echo 'Aucun article disponible.';
				}
				?>
			</p>
			<p><i><a href="/#!/versions/<?= $PROJ['idProject'] ?>">Voir l'historique des versions</a></i></p>
		</article>

		<div class="main-arrow-down" onClick="goToByScroll('preview')"></div>

		<article id="preview">
			<h2>Résumé.</h2>
			<p><?= $PROJ['previewProject'] ?></p>
		</article>

		<div id="file-stats-container">

			<article id="stats">
					<h2>Stats.</h2>
					<p><strong>Nombre d'articles: </strong><?= $totalPosts ?></p>
					<p><strong>Temps total passé: </strong><?= $totalTime ?></p>
					<p><strong><i>Passez la souris pour plus de détails !</i></strong></p>

					<div class="chart">
						<canvas id="chartParts"></canvas>
						<div class="centerDonutChart">
							<h3>Parties</h3>
							<p>heure/part</p>
						</div>
					</div>
					<div class="chart">
						<canvas id="chartTools"></canvas>
						<div class="centerDonutChart">
							<h3>Outils</h3>
							<p>heure/outil</p>
						</div>
					</div>
			</article>

			<article id="file">
					<h2>Fiche.</h2>
					<div id="file-project">
						<?= $PROJ['descProject'] ?>
					</div>
			</article>
		</div>
	</div>
</section>

<script type="text/javascript">

	document.title = 'Portfolio: <?= $PROJ['titleProject'] ?>';

	Chart.register({
		ChartDataLabels,
	});

	function alphaTranform(color) {
		let colorAlphaRegx = /(, ?0\.)[0-9]/g;
		let colorWithoutAlpha = color.replace(colorAlphaRegx, ', 0.8');

		return colorWithoutAlpha;
	}

	var colorScheme = [
		'rgba(30, 50, 49,0.65)',
		'rgba(72, 86, 101,0.65)',
		'rgba(142, 124, 147,0.65)',
		'rgba(208, 165, 192,0.65)',
		'rgba(246, 192, 208,0.65)',
		'rgba(251, 196, 171,0.65)',
		'rgba(255, 218, 185,0.65)',
		'rgba(209, 227, 221,0.65)',
		'rgba(100, 166, 189,0.65)',
		'rgba(227, 210, 111,0.65)',
		'rgba(13, 0, 164,0.65)',
		'rgba(34, 0, 124,0.65)',
		'rgba(162, 37, 34,0.65)',
		'rgba(143, 133, 125,0.65)',
		'rgba(107, 109, 118,0.65)',
	];

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
					size: (document.getElementsByClassName('chart')[0].clientWidth) / 14
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
		}
	}

	var ctxParts = document.getElementById('chartParts').getContext('2d');
	var ctxTools = document.getElementById('chartTools').getContext('2d');

	var chartParts = new Chart(ctxParts, {
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

	var chartTools = new Chart(ctxTools, {
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

	var dbDataParts = <?= $jsArrWorkParts ?>;
	var dbDataTools = <?= $jsArrTools ?>;

	dbDataParts.forEach((part, index) => {
		let color = colorScheme[Math.floor(Math.random() * colorScheme.length)];
		let border = alphaTranform(color);

		chartParts.data.labels.push(part.nameWork);
		chartParts.data.datasets[0].data.push(part.hoursFloat);
		chartParts.data.datasets[0].backgroundColor.push(color);
		chartParts.data.datasets[0].borderColor.push(border)
	});

	dbDataTools.forEach((tool, index) => {
		let color = colorScheme[Math.floor(Math.random() * colorScheme.length)];
		let border = alphaTranform(color);

		chartTools.data.labels.push(tool.nameTool);
		chartTools.data.datasets[0].data.push(tool.hoursFloat);
		chartTools.data.datasets[0].backgroundColor.push(color);
		chartTools.data.datasets[0].borderColor.push(border)
	});

	chartParts.update();
	chartTools.update();
</script>