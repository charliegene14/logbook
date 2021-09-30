<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]). '/controller/exception.php'; ?>

<section class="exception">
	<article>
		<p><img src="/public/css/error.png" /></p>
		<p><b><?= $message ?></b></p>
	</article>
</section>