<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/controller/viewPage.php'; ?>

<?php  $pageTitle = $PAGE['titlePage']; ?>

<section>
	<article class="viewPage">
		<?= $PAGE['contentPage']; ?>
	</article>
</section>