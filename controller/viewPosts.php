<?php

try {
	require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/model/passChecking.php'; passCheck();
	require_once realpath($_SERVER['DOCUMENT_ROOT']). '/model/regex.php';
	require_once realpath($_SERVER['DOCUMENT_ROOT']). '/model/FilteredPosts.php';
	
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

	$filteredPosts = new FilteredPosts($type, $work, $tool);

	if ($_GET['pg'] > $filteredPosts->getNumberPages()) {
		$_GET['pg'] = $filteredPosts->getNumberPages();
	} elseif ($_GET['pg'] < 0 || !intval($_GET['pg'])) {
		$_GET['pg'] = 1;
	}

	$posts = $filteredPosts->getPosts($_GET['pg'] ?? 1);

	$queryTypes = $filteredPosts->queryTypes;
	$queryWorks = $filteredPosts->queryWorks;
	$queryTools = $filteredPosts->queryTools;

} catch(Exception $e) {

	require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/view/exception.php';
}