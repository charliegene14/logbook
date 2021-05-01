<?php $pageTitle = 'Projets'; ?>
<?php ob_start(); ?>

<section class="projects">

	<div class="slideshow">

		<button class="button-left" onclick="changeSlide(-1)"></button>

				<?while ($PROJ = $list->fetch()) {
				?>

					<article class="previewProject">
						<div class="content">
							<div class="icon">
								<img src="public/img/projects/<?=$PROJ['idProject']?>.png" alt="<?=$PROJ['titleProject']?>" />
							</div>

							<div class="text">
								<h2 style="color: <?=$PROJ['colorCat']?>"><?=$PROJ['titleProject']?></h2>
								<p>
									<b>Genre(s): </b><?=$PROJ['kindProject']?><br />
									<b>Plateforme(s): </b><?=$PROJ['platformProject']?><br />
									<b>Date de commencement: </b><?=$regex->date($PROJ['dateProject'])?><br />
									<b>Version actuelle: </b>
									<?
										if ($lastVersion = $dbProj->getLastVersion($PROJ['idProject']))
										{
											echo '<a href="index.php?view=versions&id='.$PROJ['idProject'].'#'.$lastVersion['theVersion'].'">'.$lastVersion['theVersion'].'</a> - ';
											echo '<span class="liltxt">';
											echo $regex->date($lastVersion['dateVersion']).' (<a href="index.php?view=versions&id='.$PROJ['idProject'].'">historique</a>)</span>';
										}
										else
										{
											echo 'Aucune version disponible.';
										}
									?> <br />
									<b>Premier article: </b>
									<?
										if ($firstPost = $dbProj->getFirstPost($PROJ['idProject']))
										{
											echo '<a href="index.php?view=fullpost&id='.$firstPost['idPost'].'">'.$firstPost['titlePost'].'</a><span class="liltxt"> (le '.$regex->date($firstPost['datePost']).')</span>';
										}
										else
										{
											echo 'Aucun article disponible';
										}
									?><br />
									<b>Dernier article: </b>
									<?
										if ($lastPost = $dbProj->getLastPost($PROJ['idProject']))
										{
											echo '<a href="index.php?view=fullpost&id='.$lastPost['idPost'].'">'.$lastPost['titlePost'].'</a><span class="liltxt"> (le '.$regex->date($lastPost['datePost']).')</span>';
										}
										else
										{
											echo 'Aucun article disponible';
										}
									?><br />
									<br />
									
									<?= $PROJ['previewProject']?>
								</p>
								<button class="button-read" onClick="location.href='index.php?view=fullproject&id=<?=$PROJ['idProject']?>'">En savoir plus</button>
							</div>
						</div>
					</article>

				<?}?>
					<article class="previewProject">
						<p class="content">
							<i>Pas d'autres projets pour le moment</i> <img src="public/css/smileys/smile.png" />
						</p>
					</article>

		<button class="button-right" onclick="changeSlide(+1)"></button>

	</div>

</section>

<script src="public/js/viewProjects.js"></script>
<?php $pageContent = ob_get_clean(); ?>
<?php require('template.php'); ?>