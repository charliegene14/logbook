<?php require_once realpath($_SERVER['DOCUMENT_ROOT']). '/controller/viewProjects.php';?>

<section id="projects">

	<h1 class="title-section">Portfolio.</h1>

	<div class="content-section swiper">

		<div class="swiper-button-prev"></div>
		<div class="swiper-pagination"></div>
		<div class="swiper-button-next"></div>
		
		<div class="swiper-wrapper">
			<?php while ($PROJ = $list->fetch()) : ?>
				<article class="preview-project swiper-slide">
					<div class="project-container">
						<div class="blur-bg"></div>
						<div class="content-project">
							<div class="icon-project">
								<img src="public/img/projects/<?=$PROJ['idProject']?>.png" alt="<?=$PROJ['titleProject']?>" />
								<div class="button read-more" onClick="location.href='/#!/projects/<?=$PROJ['idProject']?>'">En savoir plus.</div>
							</div>

							<div class="text-project">
								<h2 style="color: <?=$PROJ['colorCat']?>"><?=$PROJ['titleProject']?></h2><br />

								<p class="infos-project">
									<b>Genre(s): </b><?=$PROJ['kindProject']?>&nbsp;<b>Plateforme(s): </b><?=$PROJ['platformProject']?><br />
									<b>Début: </b><?=$regex->date($PROJ['dateProject'])?>&nbsp;
									<b>Version actuelle: </b>
									<?php if ($lastVersion = $dbProj->getLastVersion($PROJ['idProject'])){
										echo '<a href="/#!/versions/'.$PROJ['idProject'].'#'.$lastVersion['theVersion'].'">'.$lastVersion['theVersion'].'</a> - ';
										echo $regex->date($lastVersion['dateVersion']).' (<a href="/#!/versions/'.$PROJ['idProject'].'">historique</a>)';
									} else { echo 'Aucune version disponible.';}
									?> <br />

									<b>Premier article: </b>
									<?php if ($firstPost = $dbProj->getFirstPost($PROJ['idProject'])){
										echo '<a href="/#!/posts/'.$firstPost['idPost'].'">'.$firstPost['titlePost'].'</a>(le '.$regex->date($firstPost['datePost']).')';
									} else { echo 'Aucun article disponible'; }
									?><br />

									<b>Dernier article: </b>
									<?php if ($lastPost = $dbProj->getLastPost($PROJ['idProject'])) {
										echo '<a href="/#!/posts/'.$lastPost['idPost'].'">'.$lastPost['titlePost'].'</a>(le '.$regex->date($lastPost['datePost']).')';
									} else { echo 'Aucun article disponible'; }
									?> <br /> <br />
								</p>

								<p class="description-project">			
									<?= $PROJ['previewProject']?>
								</p>
							</div>
						</div>
					</div>
				</article>
			<?php endwhile; ?>
		</div>
	</div>
</section>