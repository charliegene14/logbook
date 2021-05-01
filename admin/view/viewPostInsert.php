<?php $pageTitle='Ajouter un article'; ?>
<?php ob_start(); ?>

<section class="viewPostInsert">
	<p><a href="index.php?view=posts">Retourner aux articles</a></p>

	<?php
	echo '<h1>Ajouter un article (n° '.$newID.')</h1>

		<form method="post" action="index.php?view=postinsert&insert&token='.$_SESSION['token'].'" enctype="multipart/form-data">
			<fieldset>
				<legend>Catégorie/Projet (Oblig.)</legend>
				<select name="Type">';
					while ($CAT = $listCats->fetch())
					{
						echo '<option value="'.$CAT['Type'].'">'.$CAT['Type'].'.'.$CAT['nameCat'].'</option>';
					}

			echo'</select>
			</fieldset>

			<fieldset>
				<legend>Partie de travail (Facult.)</legend>
				<select name="Work">
					<option value=NULL>Aucune partie de travail</option>';
					while ($WORK = $listWorks->fetch())
					{
						echo '<option value="'.$WORK['idWork'].'">'.$WORK['typeCat'].'.'.$WORK['nameWork'].'</option>';
					}
					echo '
				</select>
			</fieldset>

			<fieldset>
				<legend>Outil utilisé (Facult.)</legend>
				<select name="Tool">
					<option value=NULL>Aucun outil</option>';
					while ($TOOL = $listTools->fetch())
					{
						echo '<option value="'.$TOOL['idTool'].'">'.$TOOL['nameTool'].'</option>';
					}
				echo '
				</select>
			</fieldset>

			<fieldset>
				<legend>Durée (Oblig.)</legend>
				<input type="time" name="timePost" required />
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
				<p>Accessible dans localhost/charliegene/public/img/posts/'.$newID.'-Numéro d\'ordre d\'upload.png</p>
			</fieldset>

			<fieldset>
				<legend>Contenu</legend>
					<textarea name="contentPost" rows="20" cols="130"></textarea>
			</fieldset>

			<input type="submit" value="Ajouter" />

		</form>';
	?>
</section>

<?php $pageContent = ob_get_clean(); ?>
<?php require 'template.php' ?>