<?php

require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/model/passChecking.php';

if (isset($_POST['password']) AND strval($_POST['password']) AND strlen($_POST['password']) < 16)
{
	$_SESSION['Site'] = htmlspecialchars($_POST['password']);

	if (isValidPass('Site')) {
		$response = true;
	} else {
		$response = false;
	}

	$array = array('bool' => $response, 'pass' => $_SESSION['Site']);
	echo json_encode($array);

} else {
	header('Location: index.php/');
	exit();
}