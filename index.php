<?php require 'functions.php'; ?>

<!DOCTYPE html>
<html lang="fr" ng-app="app">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>&mdash; <?= getHeadTitle(); ?></title>
 	<link rel="stylesheet" href="public/css/style.css" />
</head>

<body>

	<img id="wave" class="anim-drop-up" src="/public/css/images/wave.svg" />
	<?php getMenu(); ?>

	<main id="main" role="main" ng-view>
		
	</main>
	

	<?php getScripts(); ?>

</body>
</html>

<?php
/*try {

	require_once 'controller/global.php';

	if (!isValidPass('Site')) {
		viewBlock();
	} else {
		if (!empty($_GET['view'])) {
			$VIEW = $_GET['view'];
			switch ($VIEW) {
				case 'posts':
					viewPosts();
					break;

				case 'fullpost':
					viewFullPost();
					break;

				case 'calendar':
					viewCalendar();
					break;

				case 'projects':
					viewProjects();
					break;

				case 'fullproject':
					viewFullproject();
					break;

				case 'versions':
					viewVersions();
					break;

				default:
					throw new Exception('Désolé, la page demandée n\'éxiste pas.');
					break;
			}
		} elseif (!empty($_GET['page'])) {
			viewPage($_GET['page']);
		} else {
			viewAccueil();
		}
	}

} catch (Exception $e) {
	Error($e->getMessage());
}*/