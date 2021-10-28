<?php

try {
    require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/model/passChecking.php'; passCheck();
    require_once realpath($_SERVER['DOCUMENT_ROOT']). '/model/dbProjects.php';
    require_once realpath($_SERVER['DOCUMENT_ROOT']). '/model/regex.php';

    if (empty($_GET['id']) OR !intval($_GET['id']))
    {
        throw new Exception('Oops, projet introuvable.');
    }
    else
    {
        $regex = new Regex();
        $dbProj = new dbProjects();

        $PROJ = $dbProj->getProject($_GET['id']);
        $listVersions = $dbProj->getVersions($_GET['id']);

    }
    
} catch(Exception $e) {

	require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/view/exception.php';
}