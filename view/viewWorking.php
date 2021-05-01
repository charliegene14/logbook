<?php  $pageTitle = 'En travaux'; ?>
<?php  ob_start(); ?>

<section class="warning">
	<article>
		<p><img src="public/css/onworking.png" /></p>
		<p><b>Désolé, cette partie du site est en construction.</b></p>
	</article>
</section>

<?php  $pageContent = ob_get_clean(); ?>
<?php  require('template.php'); ?>