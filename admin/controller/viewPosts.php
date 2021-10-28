<?php 
require_once 'model/dbPosts.php';
require_once 'model/dbTools.php';
require_once 'model/dbWorks.php';
require_once 'model/dbCategories.php';
require_once 'model/regex.php';
require_once 'model/uploads.php';
require_once 'model/FilteredPosts.php';

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
	$MAX_LENGTH = 400;
	$regex = new Regex();

	if (isset($_GET['type']) AND !intval($_GET['type'])
	OR isset($_GET['work']) AND !intval($_GET['work'])
	OR isset($_GET['tool']) AND !intval($_GET['tool'])
	OR isset($_GET['pg']) AND !intval($_GET['pg']))
	{
		throw new Exception('Désolé, une erreur est survenue');
	}

	if (isset($_GET['type'])) {
		$_POST['type'] = (int)$_GET['type'];
		$type = (int)$_GET['type'];
	} else {
		$type = (int)$_POST['type'];
	}

	if (isset($_GET['work'])) {
		$_POST['work'] = (int)$_GET['work'];
		$work = (int)$_GET['work'];
	} else {
		$work = (int)$_POST['work'];
	}

	if (isset($_GET['tool'])) {
		$_POST['tool'] = (int)$_GET['tool'];
		$tool = (int)$_GET['tool'];
	} else {
		$tool = (int)$_POST['tool'];
	}

	if (empty($type) && !empty($work)) {
		$work = null;
	}

	if (empty($type) && !empty($work) && !empty($tool)) {
		$work = null;
		$tool = null;
	}

	$filteredPosts = new FilteredPosts($type, $work, $tool, 10);

	if ($_GET['pg'] > $filteredPosts->getNumberPages()) {
		$_GET['pg'] = $filteredPosts->getNumberPages();
	} elseif ($_GET['pg'] < 0 || !intval($_GET['pg'])) {
		$_GET['pg'] = 1;
	}

	$posts = $filteredPosts->getPosts($_GET['pg'] ?? 1);

	$queryTypes = $filteredPosts->queryTypes;
	$queryWorks = $filteredPosts->queryWorks;
	$queryTools = $filteredPosts->queryTools;

	require 'view/viewPosts.php';
}