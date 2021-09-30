<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/controller/viewFullproject.php'; ?>

<section class="fullproject">
	<div class="header">
		<div class="icon">
			<img src="public/img/projects/<?= $PROJ['idProject'] ?>.png" alt="<?= $PROJ['titleProject'] ?>" />
		</div>

		<div class="info">
			<h2 style="color: <?= $PROJ['colorCat'] ?>"><b><?= $PROJ['titleProject'] ?></b></h2>
			<p>
				<b>Genre(s): </b><?= $PROJ['kindProject'] ?>
				<b>Plateforme(s): </b><?= $PROJ['platformProject'] ?><br />
				<b>Date de commencement: </b><?= $regex->date($PROJ['dateProject']) ?><br />
				<b>Version actuelle: </b>
				<?php
				if ($lastVersion = $dbProj->getLastVersion($PROJ['idProject'])) {
					echo '<a href="index.php?view=versions&id=' . $PROJ['idProject'] . '#' . $lastVersion['theVersion'] . '">' . $lastVersion['theVersion'] . '</a> - ';
					echo '<span class="liltxt">';
					echo $regex->date($lastVersion['dateVersion']) . ' (<a href="index.php?view=versions&id=' . $PROJ['idProject'] . '">historique</a>)</span>';
				} else {
					echo 'Aucune version disponible.';
				}
				?><br />
				<b>Premier article: </b>
				<?php
				if ($firstPost = $dbProj->getFirstPost($PROJ['idProject'])) {
					echo '<a href="index.php?view=fullpost&id=' . $firstPost['idPost'] . '">' . $firstPost['titlePost'] . '</a><span class="liltxt"> (le ' . $regex->date($firstPost['datePost']) . ')</span>';
				} else {
					echo 'Aucun article disponible';
				}
				?><br />
				<b>Dernier article: </b>
				<?php
				if ($lastPost = $dbProj->getLastPost($PROJ['idProject'])) {
					echo '<a href="index.php?view=fullpost&id=' . $lastPost['idPost'] . '">' . $lastPost['titlePost'] . '</a><span class="liltxt"> (le ' . $regex->date($lastPost['datePost']) . ')</span>';
				} else {
					echo 'Aucun article disponible';
				}
				?><br />
				<br />
				<i><a href="index.php?view=versions&id=<?= $PROJ['idProject'] ?>">Voir l'historique des versions</a></i>
			</p>
		</div>
	</div>


	<div class="preview">
		<p><?= $PROJ['previewProject'] ?></p>
	</div>

	<article>
		<div class="file">
			<h2>Fiche</h2>
			<p>
				<?= $PROJ['descProject'] ?>
			</p>
		</div>

		<div class="stats">
			<h2>Stats</h2>
			<p>
				<strong>Nombre d'articles: </strong><?= $totalPosts ?><br />
				<strong>Temps total passé: </strong><?= $totalTime ?><br />
			</p>

			<p>
				<strong>Découpage du projet: </strong><br />
				<i>Passez la souris pour plus de détails !</i>
			</p>

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

		</div>
	</article>
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

	const colorScheme = [
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