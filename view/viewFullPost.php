<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/controller/viewFullPost.php'; ?>

<section id="fullpost">
	<article>

		<h1 class="titlePost title-section"><?=$POST['titlePost']?></h1>

		<div class="headerPost title-section">
			<div class="blur-bg"></div>
			<div class="infoPost" id="category">
				<p>
					Dans <a style="color: <?=$POST['colorCat']?>" href="/#!/posts?type=<?=$POST['Type']?>"><b><?=$POST['nameCat']?></b></a>
				</p>
						
				<div class="svg-calendar"></div>
				<p>
					<?=$regex->date($POST['datePost'])?>
				</p>
			</div>

			<div class="infoPost" id="work">
				<div class="svg-work"></div>
				<p>
					<?php if ($POST['Work'] != NULL): ?>
						<?=$POST['nameWork']?>
					<?php else: ?>
						Dans aucune partie de travail
					<?php endif; ?>
				</p>
			</div>
			
			<div class="infoPost" id="tools">

			<?php if ($toolsInPost != NULL): ?>
				<?php foreach ($toolsInPost as $tool ): ?>

					<div class="tool">
						<?php if ($tool['nameTool'] == NULL): ?> 
							<div class="svg-none"></div>
							<p class="nameTool">Aucun outil.</p>
						<?php else: ?>
							<img class="svg-tool" src="/public/img/tools/<?=$tool['idTool']?>.svg"></img>
							<p class="nameTool"><?=$tool['nameTool']?></p>
						<?php endif; ?>
							
						<p class="timeTool"><?=$regex->time($tool['timeTool'])?></p>
					</div>
				<?php endforeach; ?>
			<?php else: ?>

			<div class="infoPost">
				<div class="svg-none"></div>
				<p class="nameTool">Aucun outil</p>
			</div>

			<?php endif;?>

			</div>
		</div>

		<div class="post content-section">
				<?=$POST['contentPost'];?>
		</div>
	</article>
</section>

<script type='text/javascript'>
	document.title = "<?=$POST['titlePost']; ?>.";
</script>