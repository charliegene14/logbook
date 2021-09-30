<?php
try {

    require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/model/passChecking.php'; passCheck();
    require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/model/dbInfos.php';

    $infoHome = new dbInfo();
    $contentHome = $infoHome->getContent('Accueil');

} catch(Exception $e) {

	require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/view/exception.php';
}