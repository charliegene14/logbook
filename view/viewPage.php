<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/controller/viewPage.php'; ?>

<section id="custom-page" class="post">
	<h1 class="title-section"><?= $PAGE['titlePage']?>.</h1>
	<article class="content-section">
		<?= $PAGE['contentPage']; ?>
	</article>
</section>

<script type="text/javascript">
	document.title = "<?= $PAGE['titlePage']; ?>."
</script>