<?php 
require_once 'model/dbPosts.php';
require_once 'model/regex.php';

function viewFullPost()
{
	$regex = new Regex();
	$dbPosts = new dbPosts();

	if (!empty($_GET['id']) AND intval($_GET['id']))
	{
		$FULLPOST = $dbPosts->getPost($_GET['id']);
		require('view/viewFullPost.php');
	}
		
	else
	{	
		throw new Exception('Désolé, une erreur est survenue.');
	}
}