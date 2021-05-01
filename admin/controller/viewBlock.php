<?php
require_once 'model/dbPasswords.php';

function viewBlock()
{
	if (isset($_POST['password']) AND strval($_POST['password']) AND strlen($_POST['password']) < 16)
	{
		header('Location: index.php');
		$_SESSION['Admin'] = htmlspecialchars($_POST['password']);
		exit();
	}
	require 'view/viewBlock.php';
}