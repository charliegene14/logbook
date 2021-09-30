<?php require_once realpath($_SERVER['DOCUMENT_ROOT']). '/controller/viewProjects.php';?>

<section class="projects">

	<div class="slideshow">

				<?php while ($PROJ = $list->fetch()) : ?>

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
									<?php
										if ($lastVersion = $dbProj->getLastVersion($PROJ['idProject']))
										{
											echo '<a href="/#!/versions/'.$PROJ['idProject'].'#'.$lastVersion['theVersion'].'">'.$lastVersion['theVersion'].'</a> - ';
											echo '<span class="liltxt">';
											echo $regex->date($lastVersion['dateVersion']).' (<a href="/#!/versions/'.$PROJ['idProject'].'">historique</a>)</span>';
										}
										else
										{
											echo 'Aucune version disponible.';
										}
									?> <br />
									<b>Premier article: </b>
									<?php
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
									<?php
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
								<button class="button-read" onClick="location.href='/#!/projects/<?=$PROJ['idProject']?>'">En savoir plus</button>
							</div>
						</div>
					</article>

				<?php endwhile; ?>

				<article class="previewProject">
					<p class="content">
						<i>Pas d'autres projets pour le moment</i> <img src="public/css/smileys/smile.png" />
					</p>
				</article>
	</div>

</section>