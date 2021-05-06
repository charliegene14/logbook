<?php 
session_start();
require 'controller/global.php';
require 'controller/viewAccueil.php';
require 'controller/viewBlock.php';
require 'controller/viewNavigation.php';
require 'controller/viewCats.php';
require 'controller/viewPosts.php';
require 'controller/viewPages.php';
require 'controller/viewProjects.php';

try
{
	if (!isValidPass('Site'))
	{
		header('Location: ../index.php');
		exit();
	}

	if (!isValidPass('Admin'))
	{
		viewBlock();
	}
	else
	{
		newToken();
		
		if (!empty($_GET['view']))
		{
			$VIEWADMIN = $_GET['view'];
			switch($VIEWADMIN)
			{
				case 'navigation':
					viewNavigation();
				break;

				case 'cats':
					viewCats();
				break;

				case 'posts':
					viewPosts();
				break;

				case 'postupdate':
					viewPostUpdate();
				break;

				case 'postinsert':
					viewPostInsert();
				break;

				case 'projects':
					viewProjects();
				break;

				case 'projectupdate':
					viewProjectUpdate();
				break;

				case 'projectinsert':
					viewProjectInsert();
				break;

				case 'versioninsert':
					viewVersionInsert();
				break;

				case 'versionupdate':
					viewVersionUpdate();
				break;

				case 'pages':
					viewPages();
				break;

				case 'pagecontent':
					viewPageContent();
				break;

				case 'onwork':
					Workinprogress();
				break;

				default:
					throw new Exception('Désolé, la page demandée n\'éxiste pas.');
				break;
			}
		}
		else
		{
			viewAccueil();
		}
	}
}
catch (Exception $e)
{
	Error($e->getMessage());
}