<?php 
require_once 'model/dbPages.php';

function viewPage($fileName)
{
	$dbPage = new dbPages();
	$QUERY = $dbPage->getPage($fileName);
	$PAGE = $QUERY->fetch();
	require 'view/viewPage.php';
}