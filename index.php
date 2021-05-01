<?php 

session_start();
require 'controller/global.php';
require 'controller/viewBlock.php';
require 'controller/viewPage.php';
require 'controller/viewAccueil.php';
require 'controller/viewPosts.php';
require 'controller/viewFullPost.php';
require 'controller/viewProjects.php';
require 'controller/viewFullproject.php';
require 'controller/viewVersions.php';
require 'controller/viewCalendar.php';
newActivity();

try {
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
}
