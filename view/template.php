<?php 
	require_once 'model/dbInfos.php';
	require_once 'model/dbNavigation.php';
	require_once 'model/dbCategories.php';
	require_once 'model/dbProjects.php';

	$info = new dbInfo();
	$table_navigation = new dbNavigation(); $navigation = $table_navigation->getAll();
	$table_categories = new dbCategories(); $categories = $table_categories->getAll();
	$table_projects = new dbProjects(); $projects = $table_projects->getAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $pageTitle ?> - <?= $info->getContent('Head') ?>, Charlie-Gene</title>
 	<link rel="stylesheet" href="public/css/style.css" />

	<script
  		src="https://code.jquery.com/jquery-3.6.0.min.js"
  		integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  		crossorigin="anonymous">
	</script>
	
</head>
<body>

<header id="menu">

	<div id="menu-content">

		<h1><a href="index.php"><?= $info->getContent('Head') ?></a></h1>

		<nav>
			<ul>

			<?php while ($MENU = $navigation->fetch()): ?>

				<li><a href="<?=$MENU['linkNav']?>"><?=$MENU['nameNav']?></a>

				<?php if ($MENU['nameNav'] == 'Articles'): ?>

					<ul>

					<?php while($MENU_CAT = $categories->fetch()): ?>
						<li><a href="index.php?view=posts&amp;type=<?=$MENU_CAT['Type']?>"><?=$MENU_CAT['nameCat']?></a></li>
					<?php endwhile; ?>

					</ul>
				<?php endif; ?>

				<?php if ($MENU['nameNav'] == 'Projets' || $MENU['nameNav'] == 'Portfolio' || $MENU['nameNav'] == 'Folio'): ?>

					<ul>

					<?php while($MENU_PROJ = $projects->fetch()): ?>
						<li><a href="index.php?view=fullproject&amp;id=<?=$MENU_PROJ['idProject']?>"><?=$MENU_PROJ['titleProject']?></a></li>
					<?php endwhile; ?>

					</ul>
				<?php endif; ?>
											
				</li>

			<?php endwhile; ?>

			</ul>	
		</nav>

		<div id="footer-menu"><?= $info->getContent('Foot') ?></div>
	</div>

	<div id="menu-opener">
		<div id="menu-image"></div>
	</div>

</header>

<main id="main" role="main"><?= $pageContent; ?></main>

	
<script type="text/javascript" src="/public/js/menu.js"></script>
</body>
</html>