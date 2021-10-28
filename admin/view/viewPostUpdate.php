<?php  $pageTitle='Modifier un article'; ?>
<?php  ob_start(); ?>

<section class="viewPostUpdate">
	<p><a href="index.php?view=posts">Retourner aux articles</a></p>

	<h1>Article n°<?=$ID?>, "<?=$POST['titlePost']?>" <a href="index.php?view=postupdate&id=<?=$ID?>&del&token=<?=$_SESSION['token']?>">[Supprimer]</a></h1>

		<form method="post" action="index.php?view=postupdate&id=<?=$ID?>&update&token=<?=$_SESSION['token']?>" enctype="multipart/form-data">
			<fieldset>
				<legend>Catégorie/Projet (Oblig.)</legend>
				<select name="Type" onChange="this.form.submit()">';

					<?php while ($CAT = $listCats->fetch()): ?>

						<option value="<?=$CAT['Type']?>"
						<?php if ($POST['Type'] == $CAT['Type']): ?>
							selected
						<?php endif; ?>
						><?=$CAT['Type']?>.<?=$CAT['nameCat']?></option>
					<?php endwhile; ?>

				</select>
			</fieldset>

			<fieldset>
				<legend>Partie de travail (Facult.)</legend>
				<select name="Work">
					<option value=NULL>Aucune partie de travail</option>

					<?php while ($WORK = $listWorks->fetch()): ?>

						<option value="<?=$WORK['idWork']?>"

						<?php if ($POST['Work'] == $WORK['idWork']): ?>
							selected
						<?php endif; ?>

						><?=$WORK['nameWork']?></option>

					<?php endwhile; ?>

				</select>
			</fieldset>

			<fieldset>
				<legend>Outil utilisé (Facult.)</legend>

				<?php for ($i=0; $i<8; $i++):?>

				<select name="tool[<?=$i?>][idTool]">
					<option value=NULL>Aucun outil</option>
					
					<?php foreach($toolsArray as $TOOL): ?>
						
						<option value="<?=$TOOL['idTool']?>"

						<?php if ($toolsInPost[$i]['idTool'] == $TOOL['idTool']):?>
							selected
						<?php endif; ?>

						><?=$TOOL['nameTool']?></option>

					<?php endforeach;?>

				</select>
				<input type="time" name="tool[<?=$i?>][timeTool]" value="<?= $toolsInPost[$i]['timeTool']?>" />
				<input type="hidden" name="tool[<?=$i?>][idTTP]" value="<?= $toolsInPost[$i]['id']?>" />
				<br />

				<?php endfor; ?>
			</fieldset>

			<fieldset>
				<legend>Titre (Oblig.)</legend>
				<input type="text" name="titlePost" value="<?=$POST['titlePost']?>" required />
			</fieldset>

			<fieldset>
				<legend>Date (Oblig.)</legend>
				<input type="date" name="datePost" value="<?=$POST['datePost']?>" required />
			</fieldset>

			<fieldset>
				<legend>Insertion d\'images (Facult.)</legend>
				<input type="file" name="img[]" multiple />
				<p>

				<?php if ($numberOfImg >= 1) {

					for ($i=0; $i<$numberOfImg; $i++): ?>

						<img src="../public/img/posts/<?=$ID?>-<?=$i?>.png" width="20%" height="20%" /><a href="../public/img/posts/<?=$ID?>-<?=$i?>.png">public/img/posts/<?=$ID?>-<?=$i?>.png</a>

					<?php endfor;
				}?>

				</p>
			</fieldset>

			<fieldset>
				<legend>Contenu</legend>
					<textarea name="contentPost" rows="40" cols="100"><?=$regex->toBBCode($POST['contentPost'])?></textarea>
			</fieldset>

			<input type="submit" value="Modifier" />

		</form>
</section>

<?php  $pageContent = ob_get_clean(); ?>
<?php  require 'template.php' ?>