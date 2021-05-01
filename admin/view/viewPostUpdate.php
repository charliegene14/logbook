<?php $pageTitle='Modifier un article'; ?>
<?php ob_start(); ?>

<section class="viewPostUpdate">
	<p><a href="index.php?view=posts">Retourner aux articles</a></p>

	<?php
	echo '<h1>Article n°'.$ID.', "'.$POST['titlePost'].'" <a href="index.php?view=postupdate&id='.$ID.'&del&token='.$_SESSION['token'].'">[Supprimer]</a></h1>

		<form method="post" action="index.php?view=postupdate&id='.$ID.'&update&token='.$_SESSION['token'].'" enctype="multipart/form-data">
			<fieldset>
				<legend>Catégorie/Projet (Oblig.)</legend>
				<select name="Type" onChange="this.form.submit()">';
					while ($CAT = $listCats->fetch())
					{
						echo '<option value="'.$CAT['Type'].'"';
						if ($POST['Type'] == $CAT['Type'])
						{
							echo 'selected';
						}
						echo '>'.$CAT['Type'].'.'.$CAT['nameCat'].'</option>';
					}

			echo'</select>
			</fieldset>

			<fieldset>
				<legend>Partie de travail (Facult.)</legend>
				<select name="Work">
					<option value=NULL>Aucune partie de travail</option>';
					while ($WORK = $listWorks->fetch())
					{
						echo '<option value="'.$WORK['idWork'].'"';
						if ($POST['Work'] == $WORK['idWork'])
						{
							echo 'selected';
						}
						echo '>'.$WORK['nameWork'].'</option>';
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
						echo '<option value="'.$TOOL['idTool'].'"';
						if ($POST['Tool'] == $TOOL['idTool'])
						{
							echo 'selected';
						}
						echo '>'.$TOOL['nameTool'].'</option>';
					}
				echo '
				</select>
			</fieldset>

			<fieldset>
				<legend>Durée (Oblig.)</legend>
				<input type="time" name="timePost" value="'.$POST['timePost'].'" required />
			</fieldset>

			<fieldset>
				<legend>Titre (Oblig.)</legend>
				<input type="text" name="titlePost" value="'.$POST['titlePost'].'" required />
			</fieldset>

			<fieldset>
				<legend>Date (Oblig.)</legend>
				<input type="date" name="datePost" value="'.$POST['datePost'].'" required />
			</fieldset>

			<fieldset>
				<legend>Insertion d\'images (Facult.)</legend>
				<input type="file" name="img[]" multiple />
				<p>';

				if ($numberOfImg >= 1)
				{
					for ($i=0; $i<$numberOfImg; $i++)
					{
						echo'<img src="../public/img/posts/'.$ID.'-'.$i.'.png" width="20%" height="20%" /><a href="../public/img/posts/'.$ID.'-'.$i.'.png">public/img/posts/'.$ID.'-'.$i.'.png</a>';
					}
				}
				echo'</p>
			</fieldset>

			<fieldset>
				<legend>Contenu</legend>
					<textarea name="contentPost" rows="40" cols="100">'.$regex->toBBCode($POST['contentPost']).'</textarea>
			</fieldset>

			<input type="submit" value="Modifier" />

		</form>';
	?>
</section>

<?php $pageContent = ob_get_clean(); ?>
<?php require 'template.php' ?>