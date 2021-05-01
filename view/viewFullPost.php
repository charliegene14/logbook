<?php ob_start(); ?>

<section class="news">
	<article>

		<?php 
			$POST = $FULLPOST->fetch();
			$pageTitle = ''.$POST['titlePost'].'';

			echo'
			<div class="headerPost">
				<h1 class="titlePost"><a href="index.php?view=fullpost&amp;id=' .$POST['idPost'].'">' .$POST['titlePost']. '</a></h1>';
				    
				    if ($POST['Work'] != NULL)
					{
						echo '<img src="public/css/workPost.png" />'.$POST['nameWork'].'<br />';
					}
					else
					{
						echo '<img src="public/css/workPost.png" />Dans aucune partie de travail<br />';
					}
				    if ($POST['Tool'] != NULL)
					{
						echo '<img src="public/css/toolPost.png" />'.$POST['nameTool'].'<br />';
					}
					else
					{
						echo '<img src="public/css/toolPost.png" />Aucun outil<br />';
					}
				    echo'
		    			<img src="public/css/timePost.png" />'.$regex->time($POST['timePost']).'

				<aside class="infoPost">
					(dans <a style="color: ' .$POST['colorCat']. '" href="index.php?view=posts&amp;type=' .$POST['Type']. '"><b>' .$POST['nameCat']. '</b></a>)<br />
					<img src="public/css/datePost.png" />le ' .$regex->date($POST['datePost']). '
				</aside>
				</div>

				<div class="content_new">';
					echo ''.$POST['contentPost'].'
				</div>';
		?>
	</article>
</section>

<?php $pageContent = ob_get_clean(); ?>
<?php require('template.php'); ?>