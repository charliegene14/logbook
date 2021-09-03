<?php 
require_once 'model/dbPosts.php';
require_once 'model/dbTools.php';
require_once 'model/dbWorks.php';
require_once 'model/dbCategories.php';
require_once 'model/regex.php';
require_once 'model/uploads.php';

function viewPostUpdate()
{
	if (!isset($_GET['id']) OR !intval($_GET['id']))
	{
		throw new Exception('Désolé, l\'article n\'existe pas');
	}
	else
	{
		$ID = $_GET['id'];

		$dbPosts = new dbPosts();
		$dbCats = new dbCategories();
		$dbWorks = new dbWorks();
		$dbTools = new dbTools();
		$regex = new Regex();
		$uploads = new UploadsPost();

		$GETPOST = $dbPosts->getPost($ID);
		$POST = $GETPOST->fetch();
		$toolsInPost = $dbPosts->getTools($ID);

		$numberOfImg = $uploads->numberOfImg($ID);

		$listCats = $dbCats->getAll();
		$listWorks = $dbWorks->getByType($POST['Type']);
		$listTools = $dbTools->getAll();

		$toolsArray = array();
		while ($toolData = $listTools->fetch()) {
			array_push($toolsArray, $toolData);
		}

		if (isset($_GET['update']) && isValidToken($_GET['token']))
		{	
			header('Location: index.php?view=postupdate&id='.$ID.'');
			$TYPE = $_POST['Type'];
			$WORK = $_POST['Work'];

			$TITLE = htmlspecialchars($_POST['titlePost']);
			$DATE = $_POST['datePost'];
			$CONTENT = $regex->fromBBCode($_POST['contentPost']);

			if (!empty($_FILES['img']))
			{
				$uploads->uploadImg($ID);
			}

			$dbPosts->update($ID, $TYPE, $WORK, $TITLE, $DATE, $CONTENT);

			foreach ($_POST['tool'] as $tool) {

				$timeTool = $tool['timeTool'];
				$idTool = intval($tool['idTool']);

				if ($idTool == 0) {$idTool = NULL; }

				if ($timeTool == NULL || $timeTool == '00:00:00' || $timeTool == '00:00') {
					
					if ($tool['idTTP'] != NULL) {
						$dbPosts->deleteTool($tool['idTTP']);
					}

				} else {
					if ($tool['idTTP'] != NULL) {
						$dbPosts->updateTool(intval($tool['idTTP']), $idTool, $ID, $timeTool);
					} else {
						$dbPosts->insertTool($idTool, $ID, $timeTool);
					}
				}
			}

			exit();
		}
		elseif (isset($_GET['del']) && isValidToken($_GET['token']))
		{
			header('Location: index.php?view=posts');
			$dbPosts->delete($ID);
			exit();
		}
		require 'view/viewPostUpdate.php';
	}
}

function viewPostInsert()
{
	$dbPosts = new dbPosts();
	$dbCats = new dbCategories();
	$dbWorks = new dbWorks();
	$dbTools = new dbTools();
	$regex = new Regex();
	$uploads = new UploadsPost();

	$listCats = $dbCats->getAll();
	$listWorks = $dbWorks->getAll();
	$listTools = $dbTools->getAll();

	$toolsArray = array();
	while ($toolData = $listTools->fetch()) {
		array_push($toolsArray, $toolData);
	}

	$newID = $dbPosts->getNumber('nextID');

	if (isset($_GET['insert']) && isValidToken($_GET['token']))
	{
		header('Location: index.php?view=posts');

		$TYPE = $_POST['Type'];
		$WORK = $_POST['Work'];
		$TITLE = htmlspecialchars($_POST['titlePost']);
		$DATE = $_POST['datePost'];
		$CONTENT = $regex->fromBBCode($_POST['contentPost']);

		if (!empty($_FILES['img']))
		{
			$uploads->uploadImg($newID);
		}

		$dbPosts->insert($newID, $TYPE, $WORK, $TITLE, $DATE, $CONTENT);

		foreach ($_POST['tool'] as $tool) {
			$timeTool = $tool['timeTool'];
				
			if ($timeTool != NULL) {
				if ($tool['idTool'] == 'null') {
					$tool['idTool'] = NULL;
				}
				$dbPosts->insertTool($tool['idTool'],$newID, $tool['timeTool']);
			}
		}
		exit();
	}

	require 'view/viewPostInsert.php';
}

function viewPosts()
{
			$regex = new Regex();
			$dbPosts = new dbPosts();
			$dbTools = new dbTools();
			$dbWorks = new dbWorks();
			$dbCategories = new dbCategories();

			if (isset($_GET['type']) AND !intval($_GET['type'])
			OR isset($_GET['work']) AND !intval($_GET['work'])
			OR isset($_GET['tool']) AND !intval($_GET['tool'])
			OR isset($_GET['pg']) AND !intval($_GET['pg']))
			{
				throw new Exception('Désolé, une erreur est survenue');
			}

			///
			if (!empty($_GET['type'])
			&& empty($_GET['work'])
			&& empty($_GET['tool']))
			{
				$SET = 'p.Type = '.$_GET['type'].'';
				$categories = $dbCategories->getAll();
				$workParts = $dbWorks->getByType($_GET['type']);
				$tools = $dbTools->getByType($_GET['type']);
			}
			elseif (!empty($_POST['type'])
			&& empty($_POST['work'])
			&& empty($_POST['tool']))
			{
				$SET = 'p.Type = '.$_POST['type'].'';
				$_GET['type'] = $_POST['type'];
				$categories = $dbCategories->getAll();
				$workParts = $dbWorks->getByType($_GET['type']);
				$tools = $dbTools->getByType($_GET['type']);
			}

			///
			elseif (empty($_GET['type'])
			&& empty($_GET['work'])
			&& !empty($_GET['tool']))
			{
				$SET = 'p.Tool = '.$_GET['tool'].'';
				$categories = $dbCategories->getByTool($_GET['tool']);
				$workParts = $dbWorks->getByType(NULL);
				$tools = $dbTools->getAll();
			}
			elseif (empty($_POST['type']) 
			&& empty($_POST['work'])
			&& !empty($_POST['tool']))
			{
				$SET = 'p.Tool = '.$_POST['tool'].'';
				$_GET['tool'] = $_POST['tool'];
				$categories = $dbCategories->getByTool($_GET['tool']);
				$workParts = $dbWorks->getByType(NULL);
				$tools = $dbTools->getAll();
			}

			///
			elseif (!empty($_GET['type'])
			&& !empty($_GET['work'])
			&& empty($_GET['tool']))
			{
				$SET = 'p.Type = '.$_GET['type'].' AND p.Work = '.$_GET['work'].'';
				$categories = $dbCategories->getByWork($_GET['work']);
				$workParts = $dbWorks->getByType($_GET['type']);
				$tools = $dbTools->getByWork($_GET['work']);
			}
			elseif (!empty($_POST['type'])
			&& !empty($_POST['work'])
			&& empty($_POST['tool']))
			{
				$SET = 'p.Type = '.$_POST['type'].' AND p.Work = '.$_POST['work'].'';
				$_GET['type'] = $_POST['type'];
				$_GET['work'] = $_POST['work'];
				$categories = $dbCategories->getByWork($_GET['work']);
				$workParts = $dbWorks->getByType($_GET['type']);
				$tools = $dbTools->getByWork($_GET['work']);
			}

			///
			elseif (!empty($_GET['type'])
			&& empty($_GET['work'])
			&& !empty($_GET['tool']))
			{
				$SET = 'p.Type = '.$_GET['type'].' AND p.Tool = '.$_GET['tool'].'';
				$categories = $dbCategories->getByTool($_GET['tool']);
				$workParts = $dbWorks->getByTool($_GET['tool']);
				$tools = $dbTools->getByType($_GET['type']);
			}
			elseif (!empty($_POST['type'])
			&& empty($_POST['work'])
			&& !empty($_POST['tool']))
			{
				$SET = 'p.Type = '.$_POST['type'].' AND p.Tool = '.$_POST['tool'].'';
				$_GET['type'] = $_POST['type'];
				$_GET['tool'] = $_POST['tool'];
				$categories = $dbCategories->getByTool($_GET['tool']);
				$workParts = $dbWorks->getByTool($_GET['tool']);
				$tools = $dbTools->getByType($_GET['type']);
			}

			///
			elseif (!empty($_GET['type'])
			&& !empty($_GET['work'])
			&& !empty($_GET['tool']))
			{
				$SET = 'p.Type = '.$_GET['type'].' AND p.Work = '.$_GET['work'].' AND p.Tool = '.$_GET['tool'].'';
				$categories = $dbCategories->getByTool($_GET['tool']);
				$workParts = $dbWorks->getByTool($_GET['tool']);
				$tools = $dbTools->getByWork($_GET['work']);
			}
			elseif (!empty($_POST['type'])
			&& !empty($_POST['work'])
			&& !empty($_POST['tool']))
			{
				$SET = 'p.Type = '.$_POST['type'].' AND p.Work = '.$_POST['work'].' AND p.Tool = '.$_POST['tool'].'';
				$_GET['type'] = $_POST['type'];
				$_GET['work'] = $_POST['work'];
				$_GET['tool'] = $_POST['tool'];
				$categories = $dbCategories->getByTool($_GET['tool']);
				$workParts = $dbWorks->getByTool($_GET['tool']);
				$tools = $dbTools->getByWork($_GET['work']);
			}
			else
			{
				$SET = 'p.Type IS NOT NULL';
				$categories = $dbCategories->getAll();
				$workParts = $dbWorks->getByType(NULL);
				$tools = $dbTools->getAll();
			}

			[$REQ_POSTS, $TOTAL_PAGE, $PAGE_NOW] = $dbPosts->getList($SET, 10);

	require 'view/viewPosts.php';
}