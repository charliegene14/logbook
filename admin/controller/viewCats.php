<?php 
require_once 'model/dbCategories.php';
require_once 'model/dbTools.php';
require_once 'model/dbWorks.php';

function viewCats()
{
	if (empty($_GET['works']))
	{
		header('Location: index.php?view=cats&works=1');
		exit();
	}

	$dbTools = new dbTools();
	$dbCats = new dbCategories();
	$dbWorks = new dbWorks();

	$listTools = $dbTools->getAll();
	$listCats = $dbCats->getAll();
	$listWorks = $dbWorks->getByType($_GET['works']);
	
///
	if (!empty($_GET['updateTools']) && isValidToken($_GET['token']))
	{
		if (!intval($_GET['updateTools']))
		{
			throw new Exception('Désolé, l\'outil n\'est pas reconnu.');
		}
		else
		{
			header('Location: index.php?view=cats&works='.$_GET['works'].'');
			$ID = $_GET['updateTools'];
			$dbTools->updateName($ID, $_POST["name$ID"]);
			exit();
		}
	}
	elseif (isset($_GET['insertTools']) && isValidToken($_GET['token']))
	{
		header('Location: index.php?view=cats&works='.$_GET['works'].'');
		$ID = $_GET['insertTools'];
		$dbTools->insert($_POST['nameTool']);
		exit();
	}
	elseif (!empty($_GET['delTools']) && isValidToken($_GET['token']))
	{
		if (!intval($_GET['delTools']))
		{
			throw new Exception('Désolé, l\'outil n\'est pas reconnu.');
		}
		else
		{
			header('Location: index.php?view=cats&works='.$_GET['works'].'');
			$ID = $_GET['delTools'];
			$dbTools->delete($_GET['delTools']);
			exit();
		}
	}

///
	if (!empty($_GET['updateCats']) && isValidToken($_GET['token']))
	{
		if (!intval($_GET['updateCats']))
		{
			throw new Exception('Désolé, la catégorie n\'est pas reconnue.');
		}
		else
		{
			header('Location: index.php?view=cats&works='.$_GET['works'].'');
			$ID = $_GET['updateCats'];

			$dbCats->updateName($ID, $_POST["name$ID"]);
			$dbCats->updateColor($ID, $_POST["clr$ID"]);
			exit();
		}
	}
	elseif (isset($_GET['insertCats']) && isValidToken($_GET['token'])) 
	{
		header('Location: index.php?view=cats&works='.$_GET['works'].'');
		$ID = $_POST['typeCat'];
		
		$dbCats->insert($ID, $_POST['nameCat'], $_POST['colorCat']);
		exit();
	}
	elseif (!empty($_GET['delCats']) && isValidToken($_GET['token']))
	{
		if (!intval($_GET['delCats']))
		{
			throw new Exception('Désolé, la catégorie n\'est pas reconnue.');
		}
		else
		{
			header('Location: index.php?view=cats&works='.$_GET['works'].'');
			$ID = $_GET['delCats'];
			$dbCats->delete($ID);
			exit();
		}

	}
	elseif (!empty($_GET['upCats']) && isValidToken($_GET['token']))
	{
		if (!intval($_GET['upCats']))
		{
			throw new Exception('Désolé, la catégorie n\'est pas reconnue.');
		}
		else
		{
			header('Location: index.php?view=cats&works='.$_GET['works'].'');
			$ID = $_GET['upCats'];
			$dbCats->upLine($ID);
			exit();
		}
	}
	elseif (!empty($_GET['downCats']) && isValidToken($_GET['token']))
	{
		if (!intval($_GET['downCats']))
		{
			throw new Exception('Désolé, la catégorie n\'est pas reconnue.');
		}
		else
		{
			header('Location: index.php?view=cats&works='.$_GET['works'].'');
			$ID = $_GET['downCats'];
			$dbCats->downLine($ID);
			exit();
		}
	}

///
	
	if (!empty($_GET['updateWorks']) && isValidToken($_GET['token']))
	{
		if (!intval($_GET['updateWorks']))
		{
			throw new Exception('Désolé, la partie n\'est pas reconnue.');
		}
		else
		{
			header('Location: index.php?view=cats&works='.$_GET['works'].'');
			$ID = $_GET['updateWorks'];
			$dbWorks->updateName($ID, $_POST["name$ID"]);
			exit();
		}
	}
	elseif (isset($_GET['insertWorks']) && isValidToken($_GET['token'])) 
	{
		header('Location: index.php?view=cats&works='.$_GET['works'].'');
		$ID = $_POST['idWork'];
		$dbWorks->insert($ID, $_GET['works'], $_POST['nameWork']);
		exit();
	}
	elseif (!empty($_GET['delWorks']) && isValidToken($_GET['token']))
	{
		if (!intval($_GET['delWorks']))
		{
			throw new Exception('Désolé, la partie n\'est pas reconnue.');
		}
		else
		{
			header('Location: index.php?view=cats&works='.$_GET['works'].'');
			$ID = $_GET['delWorks'];
			$dbWorks->delete($ID);
			exit();
		}
	}
	elseif (!empty($_GET['upWorks']) && isValidToken($_GET['token']))
	{
		if (!intval($_GET['upWorks']))
		{
			throw new Exception('Désolé, la partie n\'est pas reconnue.');
		}
		else
		{
			header('Location: index.php?view=cats&works='.$_GET['works'].'');
			$ID = $_GET['upWorks'];
			$dbWorks->upLine($ID);
			exit();
		}
	}
	elseif (!empty($_GET['downWorks']) && isValidToken($_GET['token']))
	{
		if (!intval($_GET['downWorks']))
		{
			throw new Exception('Désolé, la partie n\'est pas reconnue.');
		}
		else
		{
			header('Location: index.php?view=cats&works='.$_GET['works'].'');
			$ID = $_GET['downWorks'];
			$dbWorks->downLine($ID);
			exit();
		}
	}
	require 'view/viewCats.php';
}