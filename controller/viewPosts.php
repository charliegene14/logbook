<?php
require_once 'model/dbPosts.php';
require_once 'model/dbTools.php';
require_once 'model/dbWorks.php';
require_once 'model/dbCategories.php';
require_once 'model/regex.php';

function viewPosts()
{
			$MAX_LENGTH = 400;

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

			[$REQ_POSTS, $TOTAL_PAGE, $PAGE_NOW] = $dbPosts->getList($SET, 4);

	require 'view/viewPosts.php';
}