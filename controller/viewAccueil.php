<?php
require_once 'model/dbInfos.php';

function viewAccueil()
{
	$infoHome = new dbInfo();
	$contentHome = $infoHome->getContent('Accueil');
	require 'view/viewAccueil.php';
}