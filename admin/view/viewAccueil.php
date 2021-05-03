<?php  $pageTitle = 'Panel'; ?>
<?php  ob_start(); ?>

<section class="viewPanel">

	<article class="choicePanel">
		<p>Bienvenue admin :)</p>
		<p><a href="index.php?view=pages">Gestionnaire de pages.</a></p>
		<p><a href="index.php?view=navigation">Gestionnaire du menu de navigation.</a></p>
		<p><a href="index.php?view=projects">Gestionnaire de projets.</a></p>
		<p><a href="index.php?view=cats">Gestionnaire des catégories, parties, outils.</a></p>
		<p><a href="index.php?view=posts">Gestionnaire d'articles.</a></p>
	</article>

	<?php 
	while ($INFO = $list_infos->fetch())
	{
		echo '
			<article class="updateInfos">
				<form method="post" action="index.php?update='.$INFO['nameInfo'].'&token='.$_SESSION['token'].'">
						<fieldset>
							<legend>' .$INFO['nameInfo']. '</legend>
								<p>
									<textarea rows="15" cols="100" name="'.$INFO['nameInfo'].'">'.$regex->toBBCode($INFO['contentInfo']).'</textarea><br />
									<input type="submit" value="Valider" />
								</p>
						</fieldset>
				</form>
			</article>';
	}
	?>
		<article class="updatePass">

			<form method="post" action="index.php?updatepass=Site&token=<?=$_SESSION['token']?>">
				<fieldset>
					<legend>Changer le mot de passe du site</legend>
					<input type="password" name="old" placeholder="Mot de passe actuel" required />
					<input type="password" name="new1" placeholder="Nouveau mdp" required />
					<input type="password" name="new2" placeholder="Repétez nouveau mdp" required />
					<input type="submit" value="Modifier" />
				</fieldset>
			</form>

			<form method="post" action="index.php?updatepass=Admin&token=<?=$_SESSION['token']?>">
				<fieldset>
					<legend>Changer le mot de passe du panel</legend>
					<input type="password" name="old" placeholder="Mot de passe actuel" required />
					<input type="password" name="new1" placeholder="Nouveau mdp" required />
					<input type="password" name="new2" placeholder="Repétez nouveau mdp" required />
					<input type="submit" value="Modifier" />
				</fieldset>
			</form>

		</article>
</section>

<?php  $pageContent = ob_get_clean(); ?>
<?php  require('template.php'); ?>