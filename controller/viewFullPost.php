<?php 

try {

	require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/model/passChecking.php'; passCheck();
	require_once realpath($_SERVER['DOCUMENT_ROOT']). '/model/dbPosts.php';
	require_once realpath($_SERVER['DOCUMENT_ROOT']). '/model/regex.php';

	$regex = new Regex();
	$dbPosts = new dbPosts();

	if (!empty($_GET['id']) AND intval($_GET['id']))
	{
		$FULLPOST = $dbPosts->getPost($_GET['id']);
		$toolsInPost = $dbPosts->getTools($_GET['id']);
		
	}
		
	else
	{	
		throw new Exception('Désolé, une erreur est survenue.');
	}

} catch(Exception $e) {

	require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/view/exception.php';
}