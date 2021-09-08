<?php  $pageTitle = 'Articles'; ?>
<?php  ob_start();?>

<section class="news">
	<p><a href="index.php">Retourner à l'accueil</a></p>
	<p><a href="index.php?view=postinsert">Ajouter un article</a></p>
	<aside class="sort">
		<form method="post" action="index.php?view=posts">
			<fieldset>

				<select name="type" onChange="this.form.submit()">
					<option value="">Toute catégorie</option>

					<?php
					if ($queryTypes != null) {
					while ($CAT = $queryTypes->fetch()) {
							echo '<option value='.$CAT['Type'];

							if (!empty($_POST['type']) && $_POST['type'] == $CAT['Type'] OR !empty($_GET['type']) && $_GET['type'] == $CAT['Type']) {
								echo ' selected';
							}

							echo '>'.$CAT['nameCat'].'</option>';
						}
					}
					?>
				</select>

				<select name="work" onChange="this.form.submit()">
					<option value="">Toute partie de travail</option>

					<?php
					if ($queryWorks != null) {
						while ($WORK = $queryWorks->fetch()) {
							echo '<option value='.$WORK['idWork'].'';

							if (!empty($_POST['work']) && $_POST['work'] == $WORK['idWork']){
								echo ' selected';
							}
							echo '>'.$WORK['nameWork'].'</option>';
						}
					}
					?>
				</select>

				<select name="tool" onChange="this.form.submit()">
					<option value="">Tous les outils</option>

					<?php
					if ($queryTools != null) {
						while ($TOOL = $queryTools->fetch()) {

							echo '<option value='.$TOOL['idTool'];

							if (!empty($_POST['tool']) AND $_POST['tool'] == $TOOL['idTool']) {
								echo ' selected';
							}

							echo '>'.$TOOL['nameTool'].'</option>';
						}
					}
					?>
				</select>

			</fieldset>
		</form>
	</aside>

	<?php foreach ($posts as $POST) : ?>
		<article>

			<h1 class="titlePost"><a href="index.php?view=postupdate&amp;id=<?=$POST['idPost']?>"><?=$POST['titlePost']?></a></h1>

			<aside class="infoPost">
				(dans <a style="color: <?=$POST['colorCat']?>" href="index.php?view=posts&amp;type=<?=$POST['Type']?>"><b><?=$POST['nameCat']?></b></a>)<br />
				<img src="public/css/datePost.png" />le <?=$regex->date($POST['datePost'])?>
			</aside>

			<div class="previewPost">
				<p>
				<?php
				if (strlen($regex->previewPost($POST['contentPost'])) > $MAX_LENGTH) {
					echo substr($regex->previewPost($POST['contentPost']), 0, $MAX_LENGTH)?>
					[...].
					<br />
					<br />

					<button class="button-read" onClick="window.location.href='index.php?view=postupdate&amp;id=<?=$POST['idPost']?>'">
						Lire la suite
					</button>

				<?php
				} else {
					echo ($regex->previewPost($POST['contentPost'])) ?>
					<br />
					<br />
					<button class="button-read" onClick="window.location.href='index.php?view=postupdate&amp;id=<?=$POST['idPost']?>'">
						Lire la suite
					</button>
				
				<?php }?>
				</p>
				
			</div>
			<hr />
		</article>
	<?php endforeach; ?>

	<p class="pages">
		<?php 
		$filteredPosts->getPagination($_GET['pg']);
		?>
	</p>
</section>

<?php  $pageContent = ob_get_clean(); ?>
<?php  require('template.php'); ?>