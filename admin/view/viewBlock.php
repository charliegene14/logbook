<?php  $pageTitle = 'Connexion'; ?>
<?php  ob_start(); ?>

<section class="block">
	<?php 
		echo'
			<form method="post">
				<p>
					<fieldset>
						<legend>
							<label for="password">Mot de passe d\'accès au panneau d\'administration: <br /></label>
						</legend>

						<input type="password" name="password" id="password" autofocus required /><br />
						<input type="submit" value="Valider" />
					</fieldset>
				</p>
			</form>';
	?>
</section>

<?php  $pageContent = ob_get_clean(); ?>
<?php  require('template.php'); ?>