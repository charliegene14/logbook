<?php
require_once 'model/dbProjects.php';
require_once 'model/regex.php';

function viewVersions()
{
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

        require 'view/viewVersions.php';
    }
}