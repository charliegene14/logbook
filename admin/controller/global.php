<?php 
require_once 'model/dbPasswords.php';

function isValidPass($namePass)
{
	$dbPassword = new dbPassword();
	$hashedPass =  $dbPassword->getPass($namePass);

	if (empty($_SESSION[$namePass]) OR !password_verify($_SESSION[$namePass], $hashedPass))
	{
		return false;
	}
	return true;
}

function Error($message)
{
	require('view/viewError.php');
}

function Workinprogress()
{
	require 'view/viewWorking.php';
}

function newToken() {

	if (!isset($_SESSION['token']))
	{
		$_SESSION['token'] = md5(bin2hex(openssl_random_pseudo_bytes(6)));
	}
}

function isValidToken($string)
{
	if (isset($_SESSION['token']) && $string == $_SESSION['token'])
	{
		return true;
	}
	return false;
}