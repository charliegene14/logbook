<?php
	require_once 'model/dbInfos.php';
	$info = new dbInfo();
?>

<!DOCTYPE html>
<html>
 	<head>
 		<meta charset="utf-8" />
 		<title><?= $pageTitle ?> - Administration  - Cahier de bord, Charlie-Gene</title>
 		<link rel="stylesheet" href="public/css/style.css" />
 	</head>

 	<body>
 		<header>
			<h1><?= $info->getContent('Head') ?></h1>
		</header>

		<?= $pageContent ?>
	
		<footer>
			<p><?= $info->getContent('Foot') ?></p>
		</footer>
 	</body>
</html>