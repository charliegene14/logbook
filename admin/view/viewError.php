<?php $pageTitle = 'Erreur'; ?>
<?php ob_start(); ?>

<section class="warning">
	<article>
		<p><img src="public/css/error.png" /></p>
		<p><b><?= $message; ?></b></p>
	</article>
</section>

<?php $pageContent = ob_get_clean(); ?>
<?php require('template.php'); ?>