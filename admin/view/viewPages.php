<?php  $pageTitle = 'Gestionnaire de pages'; ?>
<?php  ob_start(); ?>

<section class="viewPages">

	<article>
		<p><a href="index.php">Retourner au panneau principal</a></p>
		<p><h1>Ajouter une page:</h1></p>
		<form method="post" action="index.php?view=pages&insert&token=<?=$_SESSION['token']?>">
			<p>
				Titre: <input type="text" name="titlePage" placeholder="Titre de la page" required />
				Fichier: <input type="text" name="fileName" placeholder="Filename" required />
				<input type="submit" value="Ajouter" />
			</p>
		</form>

		<p><h1>Liste des pages:</h1></p>
		<?php 
			while($PAGE = $listPages->fetch())
			{
				echo '
					<form method="post" action="index.php?view=pages&update='.$PAGE['idPage'].'&token='.$_SESSION['token'].'">
						<fieldset>
							<p>
								ID: '.$PAGE['idPage'].'
								Titre: <input type="text" name="title'.$PAGE['idPage'].'" value="'.$PAGE['titlePage'].'" required />
								Fichier: <input type="text" name="file'.$PAGE['idPage'].'" value="'.$PAGE['fileName'].'" required />
								<input type="submit" value="Modifier" />
								<a href="index.php?view=pagecontent&id='.$PAGE['idPage'].'">Gérer le contenu</a>
								(<a href="index.php?view=pages&del='.$PAGE['idPage'].'&token='.$_SESSION['token'].'"> X </a>)
								Lien: /index.php?page='.$PAGE['fileName'].'
							</p>
						</fieldset>
					</form>
				';
			}
		?>

	</article>

</section>

<?php  $pageContent = ob_get_clean(); ?>
<?php  require('template.php'); ?>