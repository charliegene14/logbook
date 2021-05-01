<?php 
require_once 'model/dbPages.php';
require_once 'model/uploads.php';
require_once 'model/regex.php';

function viewPages()
{
	$dbPages = new dbPages();
	$listPages = $dbPages->getAll();

	if (!empty($_GET['update']) && isValidToken($_GET['token']))
	{
		if (!intval($_GET['update']))
		{
			throw new Exception('Désolé, la page n\'est pas reconnue');
		}
		else
		{
			header('Location: index.php?view=pages');
			$ID = $_GET['update'];

			$dbPages->updateTitle($ID, $_POST["title$ID"]);
			$dbPages->updateFilename($ID, $_POST["file$ID"]);
			exit();
		}
	}
	elseif (isset($_GET['insert']) && isValidToken($_GET['token']))
	{
		header('Location: index.php?view=pages');
		$dbPages->insert($_POST['titlePage'], $_POST['fileName']);
		exit();
	}
	elseif (!empty($_GET['del']) && isValidToken($_GET['token']))
	{
		if (!intval($_GET['del']))
		{
			throw new Exception('Désolé, la page n\'est pas reconnue');
		}
		else
		{
			header('Location: index.php?view=pages');
			$ID = $_GET['del'];
			$dbPages->delete($ID);
			exit();
		}
	}

	require 'view/viewPages.php';
}

function viewPageContent()
{
	$uploads = new UploadsPage();
	$dbPages = new dbPages();
	$regex = new Regex();

	if (!isset($_GET['id']) OR !intval($_GET['id']))
	{
		throw new Exception('Désolé, une erreur est survenue.');
	}
	else
	{
		$ID = $_GET['id'];
		$PAGE = $dbPages->getContent($ID);

		$numberOfImg = $uploads->numberOfImg($ID);

		if (isset($_GET['update']) && isValidToken($_GET['token']))
		{	
			header('Location: index.php?view=pagecontent&id='.$ID.'');

			if (!empty($_FILES['img']))
			{
				$uploads->uploadImg($ID);
			}

			$dbPages->updateContent($ID, $regex->fromBBCode($_POST['contentPage']));
			exit();
		}
	}

	require 'view/viewPageContent.php';
}