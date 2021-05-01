<?php  $pageTitle = $PAGE['titlePage']; ?>

<?php  ob_start(); ?>

<section class="index">
	<article class="viewPage">
		<?= $PAGE['contentPage']; ?>
	</article>
</section>

<?php  $pageContent = ob_get_clean(); ?>

<?php  require('template.php'); ?>