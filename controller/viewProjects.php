<?php 
require_once 'model/dbProjects.php';
require_once 'model/regex.php';

function viewProjects()
{
	$dbProj = new dbProjects();
	$regex = new Regex();

	$list = $dbProj->getAll();
	require 'view/viewProjects.php';
}
