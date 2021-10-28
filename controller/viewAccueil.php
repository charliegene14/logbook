<?php
try {
    require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/model/passChecking.php'; passCheck();
    require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/model/dbTools.php';
    require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/model/regex.php';

    $regex = new Regex();
    $dbTools = new dbTools();
    $tools = $dbTools->getAll()->fetchAll();

} catch(Exception $e) {

	require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/view/exception.php';
}