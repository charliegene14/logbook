<?php 
require_once 'model/dbPasswords.php';
require_once 'model/dbInfos.php';
require_once 'model/regex.php';

function viewAccueil()
{
	$regex = new Regex();
	$infos = new dbInfo();
	$dbPass = new dbPassword();

	$list_infos = $infos->getList();

	if (!empty($_GET['update']) && isValidToken($_GET['token']))
	{
		header('Location: index.php');
		$nameInfo = $_GET['update'];
		$infos->updateContent($nameInfo, $regex->fromBBCode($_POST[$nameInfo]));
		exit();
	}

	if (!empty($_GET['updatepass']) && isValidToken($_GET['token']))
	{
		header('Location: index.php');
		$namePass = $_GET['updatepass'];
		$oldPass = $_POST['old'];
		$hashedDBpass = $dbPass->getPass($namePass);

		$newPass1 = $_POST['new1'];
		$newPass2 = $_POST['new2'];

		if (password_verify($oldPass, $hashedDBpass) && $newPass1 == $newPass2)
		{
			$dbPass->update($namePass, password_hash($newPass2, PASSWORD_DEFAULT));
		}
		else
		{
			throw new Exception('Désolé, une erreur s\'est produite.');
		}
		exit();
	}

	require 'view/viewAccueil.php';
}