<?php  $pageTitle = 'Connexion'; ?>
<?php  ob_start(); ?>

<section class="block">

	<form method="post">

		<?php if(!empty($_SESSION['Admin']) & !isValidPass('Admin')): ?>

			<p style="color: red">Oops, mauvais mot de passe...</p>
			<?php $_SESSION['Admin'] = null; ?>

		<?php endif; ?>

		<input type="password" name="password" id="password" placeholder="Mot de passe d'accès admin." autofocus required /><br />
		<input type="submit" value="Valider" />

	</form>

</section>

<?php  $pageContent = ob_get_clean(); ?>
<?php  require('template.php'); ?>