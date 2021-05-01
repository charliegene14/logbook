<?php $pageTitle = 'Articles'; ?>
<?php ob_start(); ?>

<section class="news">

	<aside class="sort">
		<form method="post" action="index.php?view=posts">
			<fieldset>

				<select name="type" onChange="this.form.submit()">
					<option value="">Toute catégorie</option>
					<?php
						while ($CAT = $categories->fetch())
						{
							echo '<option value="'.$CAT['Type'].'"';
							if (!empty($_POST['type']) && $_POST['type'] == $CAT['Type'] OR !empty($_GET['type']) && $_GET['type'] == $CAT['Type'])
							{
								echo 'selected';
							}
							echo '>'.$CAT['nameCat'].'</option>';
						}
					?>
				</select>

				<select name="work" onChange="this.form.submit()">
					<option value="">Toute partie de travail</option>
					<?php
						while ($WORK = $workParts->fetch())
						{
							echo '<option value="'.$WORK['idWork'].'"';
							if (!empty($_POST['work']) && $_POST['work'] == $WORK['idWork'] OR !empty($_GET['work']) && $_GET['work'] == $WORK['idWork'])
							{
								echo 'selected';
							}
							echo '>'.$WORK['nameWork'].'</option>';
						}
					?>
				</select>

				<select name="tool" onChange="this.form.submit()">
					<option value="">Tous les outils</option>
					<?php
						while ($TOOL = $tools->fetch())
						{
							echo '<option value="'.$TOOL['idTool'].'"';
							if (!empty($_POST['tool']) AND $_POST['tool'] == $TOOL['idTool'] OR !empty($_GET['tool']) && $_GET['tool'] == $TOOL['idTool'])
							{
								echo 'selected';
							}
							echo '>'.$TOOL['nameTool'].'</option>';
						}
					?>
				</select>

			</fieldset>
		</form>
	</aside>

	<? while ($POST = $REQ_POSTS->fetch()) { ?>
		<article>

			<h1 class="titlePost"><a href="index.php?view=fullpost&amp;id=<?=$POST['idPost']?>"><?=$POST['titlePost']?></a></h1>

			<aside class="infoPost">
				(dans <a style="color: <?=$POST['colorCat']?>" href="index.php?view=posts&amp;type=<?=$POST['Type']?>"><b><?=$POST['nameCat']?></b></a>)<br />
				<img src="public/css/datePost.png" />le <?=$regex->date($POST['datePost'])?>
			</aside>

			<div class="previewPost">
				<p>
					<?if (strlen($regex->previewPost($POST['contentPost'])) > $MAX_LENGTH) {?>
						<?=substr($regex->previewPost($POST['contentPost']), 0, $MAX_LENGTH)?>
						[...].
						<br />
						<br />

						<button class="button-read" onClick="window.location.href='index.php?view=fullpost&amp;id=<?=$POST['idPost']?>'">
							Lire la suite
						</button>
					<?} else {

						echo ($regex->previewPost($POST['contentPost']));
					}?>
				</p>
			</div>
			<hr />
		</article>
	<?}?>

	<p class="pages">
		<?php
			for($PAGE=1; $PAGE <= $TOTAL_PAGE; $PAGE++)
			{
				if ($PAGE == $PAGE_NOW)
				{
				echo ' <strong> '.$PAGE.' </strong> ';
				}
				else
				{
					echo ' <a href="index.php?view=posts';
						if (!empty($_GET['type']))
						{
							echo '&amp;type='.$_GET['type'].'';
						}

						if (!empty($_GET['work']))
						{
							echo '&amp;work='.$_GET['work'].'';
						}

						if (!empty($_GET['tool']))
						{
							echo '&amp;tool='.$_GET['tool'].'';
						}

						echo '&amp;pg='.$PAGE.'"> '.$PAGE.' </a>';
				}
			}
		?>
	</p>
</section>

<?php $pageContent = ob_get_clean(); ?>
<?php require('template.php'); ?>