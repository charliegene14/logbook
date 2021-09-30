<?php

try {

	require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/model/passChecking.php'; passCheck();
	require_once realpath($_SERVER['DOCUMENT_ROOT']). '/model/dbProjects.php';
	require_once realpath($_SERVER['DOCUMENT_ROOT']). '/model/regex.php';

	if (empty($_GET['id']) or !intval($_GET['id'])) {

		throw new Exception('Désolé, aucun projet ici.');

	} else {
		$dbProj = new dbProjects();
		$regex = new Regex();

		$PROJ = $dbProj->getProject($_GET['id']);

		$totalTime = $regex->time($dbProj->getTotalTime($_GET['id']));
		$totalPosts = $dbProj->getNumberPosts($_GET['id']);

		$workParts = $dbProj->getHoursParts($_GET['id']);
		$tools = $dbProj->getHoursTools($_GET['id']);

		$jsArrWorkParts = json_encode($workParts);
		$jsArrTools = json_encode($tools);

	}
	
} catch(Exception $e) {

	require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/view/exception.php';
}