<?php

try {
	//require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/model/passChecking.php'; passCheck();
	require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/model/dbPages.php';

	$dbPage = new dbPages();
	$QUERY = $dbPage->getPage($_GET['page']);
	$PAGE = $QUERY->fetch();


} catch(Exception $e) {

	require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/view/exception.php';
}