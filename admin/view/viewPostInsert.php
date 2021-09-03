<?php  $pageTitle='Ajouter un article'; ?>
<?php  ob_start(); ?>

<section class="viewPostInsert">
	<p><a href="index.php?view=posts">Retourner aux articles</a></p>

	<h1>Ajouter un article (n°<?=$newID?>)</h1>

		<form method="post" action="index.php?view=postinsert&insert&token=<?=$_SESSION['token']?>" enctype="multipart/form-data">
			<fieldset>
				<legend>Catégorie/Projet (Oblig.)</legend>
				<select name="Type">
					<?php while ($CAT = $listCats->fetch()): ?>
						<option value="<?=$CAT['Type']?>"><?=$CAT['Type']?>. <?=$CAT['nameCat']?></option>
					<?php endwhile;?>

			</select>
			</fieldset>

			<fieldset>
				<legend>Partie de travail (Facult.)</legend>
				<select name="Work">
					<option value=NULL>Aucune partie de travail</option>
					<?php while ($WORK = $listWorks->fetch()):?>
						<option value="<?=$WORK['idWork']?>"><?=$WORK['typeCat']?>. <?=$WORK['nameWork']?></option>
					<?php endwhile;?>
				</select>
			</fieldset>

			<fieldset>
				<legend>Outil utilisé (Facult.)</legend>
				<?php for ($i=0; $i<8; $i++):?>

					<select name="tool[<?=$i?>][idTool]">
						<option value=null>Aucun outil</option>

						<?php foreach($toolsArray as $TOOL): ?>
							<option value="<?=$TOOL['idTool']?>"><?=$TOOL['nameTool']?></option>
						<?php endforeach; ?>

					</select>
					<input type="time" name="tool[<?=$i?>][timeTool]" value=NULL />
					<br />

				<?php endfor;?>

			</fieldset>

			<fieldset>
				<legend>Titre (Oblig.)</legend>
				<input type="text" name="titlePost" required />
			</fieldset>

			<fieldset>
				<legend>Date (Oblig.)</legend>
				<input type="date" name="datePost" required />
			</fieldset>

			<fieldset>
				<legend>Insertion d\'images (Facult.)</legend>
				<input type="file" name="img[]" multiple />
				<p>Accessible dans /public/img/posts/<?=$newID?>-Numéro d\'ordre d\'upload.png</p>
			</fieldset>

			<fieldset>
				<legend>Contenu</legend>
					<textarea name="contentPost" rows="20" cols="130"></textarea>
			</fieldset>

			<input type="submit" value="Ajouter" />

		</form>
</section>

<?php  $pageContent = ob_get_clean(); ?>
<?php  require 'template.php' ?>