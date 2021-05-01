<?php $pageTitle = 'Panel'; ?>
<?php ob_start(); ?>

<section class="viewNavigation">
	<article>
		<p><a href="index.php">Retourner au panneau principal</a></p>
		<p><h1>Ajouter un menu:</h1></p>
		<form method="post" action="index.php?view=navigation&insert<?=$_SESSION['token']?>">
			<p>
				ID: <input type="text" size="1" name="id" placeholder="ID" required />
				Nom: <input type="text" name="name" placeholder="Nom du menu" required />
				Lien: <input type="text" name="link" placeholder="Lien vers la page" required />
				<input type="submit" value="Ajouter" />
			</p>
		</form>

		<p><h1>Liste des menus:</h1></p>
		<?php
			while($MENU = $listNav->fetch())
			{
				echo '
					<form method="post" action="index.php?view=navigation&update='.$MENU['idNav'].'&token='.$_SESSION['token'].'">
						<fieldset>
							<p>
								ID: '.$MENU['idNav'].'
								Nom: <input type="text" name="name'.$MENU['idNav'].'" value="'.$MENU['nameNav'].'" required />
								Lien: <input type="text" name="link'.$MENU['idNav'].'" value="'.$MENU['linkNav'].'" required />
								<input type="submit" value="Modifier" />
								<a href="index.php?view=navigation&del='.$MENU['idNav'].'&token='.$_SESSION['token'].'">Supprimer (!)</a> 
								<a href="index.php?view=navigation&up='.$MENU['idNav'].'&token='.$_SESSION['token'].'">UP</a> / <a href="index.php?view=navigation&down='.$MENU['idNav'].'&token='.$_SESSION['token'].'">DOWN</a>
							</p>
						</fieldset>
					</form>
				';
			}
		?>
	</article>
</section>

<?php $pageContent = ob_get_clean(); ?>
<?php require('template.php'); ?>