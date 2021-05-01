<?php
require_once 'model/dbNavigation.php';

function viewNavigation()
{
	$dbNav = new dbNavigation();
	$listNav = $dbNav->getAll();

	if (!empty($_GET['update']) && isValidToken($_GET['token']))
	{
		if (!intval($_GET['update']))
		{
			throw new Exception('Le menu n\'est pas reconnu.');
		}
		else
		{
			header('Location: index.php?view=navigation');
			$ID = $_GET['update'];
			$dbNav->updateName($ID, $_POST["name$ID"]);
			$dbNav->updateLink($ID, $_POST["link$ID"]);
			exit();
		}
	}

	elseif (isset($_GET['insert']) && isValidToken($_GET['token']))
	{
		header('Location: index.php?view=navigation');
		$dbNav->insert($_POST['id'], $_POST['name'], $_POST['link']);
		exit();
	}

	elseif (!empty($_GET['del']) && isValidToken($_GET['token']))
	{
		if (!intval($_GET['del']))
		{
			throw new Exception('Le menu n\'est pas reconnu.');
		}
		else
		{
			header('Location: index.php?view=navigation');
			$ID = $_GET['del'];
			$dbNav->delete($ID);
			exit();
		}
	}
	elseif (!empty($_GET['up']) && isValidToken($_GET['token']))
	{
		if (!intval($_GET['up']))
		{
			throw new Exception('Le menu n\'est pas reconnu.');
		}
		else
		{
			header('Location: index.php?view=navigation');
			$ID = $_GET['up'];
			$dbNav->upLine($ID);
			exit();
		}
	}
	elseif (!empty($_GET['down']) && isValidToken($_GET['token']))
	{
		if (!intval($_GET['down']))
		{
			throw new Exception('Le menu n\'est pas reconnu.');
		}
		else
		{
			header('Location: index.php?view=navigation');
			$ID = $_GET['down'];
			$dbNav->downLine($ID);
			exit();
		}
	}

	require 'view/viewNavigation.php';
}