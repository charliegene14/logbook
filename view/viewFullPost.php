<?php  ob_start(); ?>

<section class="news">
	<article>

		<?php  
		$POST = $FULLPOST->fetch();
		$pageTitle = $POST['titlePost'];
		?>
		
		<div class="headerPost">
			<h1 class="titlePost"><a href="index.php?view=fullpost&amp;id=<?=$POST['idPost']?>"><?=$POST['titlePost']?></a></h1>

			<?php if ($POST['Work'] != NULL) {
					echo '<img src="public/css/workPost.png" />&nbsp;'.$POST['nameWork'].'<br /><br />';
				} else {
					echo '<img src="public/css/workPost.png" />&nbsp;Dans aucune partie de travail<br /><br />';
				}
				if ($toolsInPost != NULL) {

					foreach ($toolsInPost as $tool ) {

						echo '<img src="public/css/toolPost.png" />&nbsp;';
						if ($tool['nameTool'] == NULL) {
							echo 'Aucun outil';
						} else {
							echo $tool['nameTool'];
						}
						echo '&nbsp;&nbsp; <img src="public/css/timePost.png" />&nbsp;'. $regex->time($tool['timeTool']);
						echo '<br />';
					}
					
				} else {
					echo '<img src="public/css/toolPost.png" />Aucun outil<br />';
				}
			?>

			<aside class="infoPost">
				(dans <a style="color: <?=$POST['colorCat'];?>" href="index.php?view=posts&amp;type=<?=$POST['Type']?>"><b><?= $POST['nameCat'];?></b></a>)<br />
				<img src="public/css/datePost.png" />le <?=$regex->date($POST['datePost']);?>
			</aside>
			</div>

			<div class="content_new">
					<?=$POST['contentPost'];?>
			</div>
	</article>
</section>

<?php  $pageContent = ob_get_clean(); ?>
<?php  require('template.php'); ?>