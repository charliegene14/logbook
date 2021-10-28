<?php

try {
    require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/model/passChecking.php'; passCheck();
    require_once realpath($_SERVER['DOCUMENT_ROOT']).'/model/dbProjects.php';
    require_once realpath($_SERVER['DOCUMENT_ROOT']).'/model/regex.php';

    $dbProj = new dbProjects();
    $regex = new Regex();

    $list = $dbProj->getAll();

} catch(Exception $e) {

	require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/view/exception.php';
}