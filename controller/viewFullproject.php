<?php 
require_once 'model/dbProjects.php';
require_once 'model/regex.php';

function viewFullproject()
{
	if (empty($_GET['id']) or !intval($_GET['id'])) {
		throw new Exception('Désolé, aucun projet ici.');
	} else {
		$dbProj = new dbProjects();
		$regex = new Regex();

		$list = $dbProj->getAll();

		$PROJ = $dbProj->getProject($_GET['id']);

		$totalTime = $regex->time($dbProj->getTotalTime($_GET['id']));
		$totalPosts = $dbProj->getNumberPosts($_GET['id']);

		$workParts = $dbProj->getHoursParts($_GET['id']);
		$tools = $dbProj->getHoursTools($_GET['id']);

		$jsArrWorkParts = json_encode($workParts);
		$jsArrTools = json_encode($tools);

		require 'view/viewFullproject.php';
	}
}
