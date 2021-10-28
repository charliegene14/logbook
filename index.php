<?php require 'functions.php'; ?>

<!DOCTYPE html>
<html lang="fr" ng-app="app">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Journal de bord - Charlie-Gene</title>
 	<?php getStyles(); ?>
</head>

<body>
	
	<img id="wave" class="anim-drop-up" src="/public/css/images/wave.svg" />

	<?php getMenu(); ?>
	<main id="main" role="main" ng-view></main>	
	<?php getScripts(); ?>

</body>
</html>