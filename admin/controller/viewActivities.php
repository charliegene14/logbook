<?php
require_once 'model/dbActivity.php';
require_once 'model/regex.php';

function viewActivities()
{
	$activityIP = new ActivityIP();
	$dbActivities = new dbActivities();
	$regex = new Regex();

	$actualIP = $activityIP->getIP();

	if (empty($_GET['ip']) OR empty($_GET['date']))
	{
		header('Location: index.php?view=activities&ip='.$actualIP.'&date='.date('Y-m-d').'');
		exit();
	}
	else
	{
		$totalVisits = $dbActivities->getVisits('total');
		$listIP = $dbActivities->getVisits('list');
		$listDates = $dbActivities->getDatesByIP($_GET['ip']);
		$listDetails = $dbActivities->getDetailsByDate($_GET['ip'], $_GET['date']);
	}

	require 'view/viewActivities.php';
}