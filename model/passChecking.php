<?php
session_start();
require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/model/dbPasswords.php';

function isValidPass($namePass)
{
	$dbPassword = new dbPassword();
	$hashedPass =  $dbPassword->getPass($namePass);

	if (empty($_SESSION[$namePass])
		OR !isset($_SESSION[$namePass])
		OR !password_verify($_SESSION[$namePass], $hashedPass)) {

		return false;
	}

	return true;
}

function passCheck() {
	if (!isValidPass('Site')) {
		header('Location: /');
		exit();
	}
}