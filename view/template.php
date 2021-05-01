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
<html>

 	<head>
 		<meta charset="utf-8" />
 		<title><?= $pageTitle ?> - <?= $info->getContent('Head') ?>, Charlie-Gene</title>
 		<link rel="stylesheet" href="public/css/style.css" />
 	</head>


 	<body>

 		<header>
			<h1><a href="index.php"><?= $info->getContent('Head') ?></a></h1>
		</header>

		<div class="nav1">
			<nav>
				<ul>

				<?php 
				while ($MENU = $navigation->fetch())
				{

					echo'<li><a href="'.$MENU['linkNav']. '">' .$MENU['nameNav']. '</a>';

					if ($MENU['nameNav'] == 'Articles')
					{
						echo '<ul>';

						while($MENU_CAT = $categories->fetch())
						{
							echo '<li><a href="index.php?view=posts&amp;type=' .$MENU_CAT['Type']. '">' .$MENU_CAT['nameCat']. '</a></li>';
						}

						echo '</ul>';
					}
					if ($MENU['nameNav'] == 'Projets')
					{
						echo '<ul>';

						while($MENU_PROJ = $projects->fetch())
						{
							echo '<li><a href="index.php?view=fullproject&amp;id=' .$MENU_PROJ['idProject']. '">' .$MENU_PROJ['titleProject']. '</a></li>';
						}

						echo '</ul>';
					}
										
					echo'</li>';
				}
				?>

				</ul>	
			</nav>
		</div>

		<?= $pageContent ?>
	
		<footer>
			<p><?= $info->getContent('Foot') ?></p>
		</footer>

 	</body>


</html>