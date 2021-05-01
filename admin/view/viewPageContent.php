<?php  $pageTitle='Gérer le contenu de page'; ?>
<?php  ob_start(); ?>

<section class="viewPageContent">
	<p><a href="index.php?view=pages">Retourner au gestionnaire de pages</a></p>

	<?php 
	echo '<h1>"'.$PAGE['titlePage'].'"</h1>

		<form method="post" action="index.php?view=pagecontent&id='.$ID.'&update&token='.$_SESSION['token'].'" enctype="multipart/form-data">
			<fieldset>
				<legend>Insertion d\'images</legend>
				<input type="file" name="img[]" multiple />
				<p>';

				if ($numberOfImg >= 1)
				{
					for ($i=0; $i<$numberOfImg; $i++)
					{
						echo'<img src="../public/img/pages/'.$PAGE['idPage'].'-'.$i.'.png" width="20%" height="20%" /><a href="../public/img/pages/'.$PAGE['idPage'].'-'.$i.'.png">public/img/pages/'.$PAGE['idPage'].'-'.$i.'.png</a>';
					}
				}
				echo'</p>
			</fieldset>

			<fieldset>
				<legend>Contenu</legend>
					<textarea name="contentPage" rows="40" cols="100">'.$regex->toBBCode($PAGE['contentPage']).'</textarea>
			</fieldset>

			<input type="submit" value="Modifier" />

		</form>';
	?>
</section>

<?php  $pageContent = ob_get_clean(); ?>
<?php  require 'template.php' ?>