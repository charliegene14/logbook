<?php  $pageTitle = 'Accueil'; ?>

<?php  ob_start(); ?>

<section class="index">
	<article>
		<?= $contentHome ?>
	</article>
</section>

<?php  $pageContent = ob_get_clean(); ?>

<?php  require 'template.php'; ?>
