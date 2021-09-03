<?php 

session_start();
require 'controller/global.php';

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
