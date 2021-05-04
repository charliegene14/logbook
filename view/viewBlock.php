<?php  $pageTitle = 'Connexion'; ?>
<?php  ob_start(); ?>

<div class="block">

	<form method="post">

		<?php if(!empty($_SESSION['Site']) & !isValidPass('Site')): ?>

			<p style="color: red">Oops, mauvais mot de passe...</p>
			<?php $_SESSION['Site'] = null; ?>
			
		<?php endif; ?>

		<input type="password" name="password" id="password" placeholder="Mot de passe d'accès au site." autofocus required /><br />
		<input type="submit" value="Valider" />
	</form>

</div>

<?php  $pageContent = ob_get_clean(); ?>
<?php  require 'template.php'; ?>