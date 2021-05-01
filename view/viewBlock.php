<?php $pageTitle = 'Connexion'; ?>
<?php ob_start(); ?>

<div class="block">
	<?php
		echo'
			<form method="post">
					<fieldset>
						<legend>
							<label for="password">Mot de passe d\'accès au site: <br /></label>
						</legend>

						<input type="password" name="password" id="password" autofocus required /><br />
						<input type="submit" value="Valider" />
					</fieldset>
			</form>';
	?>
</div>

<?php $pageContent = ob_get_clean(); ?>
<?php require 'template.php'; ?>