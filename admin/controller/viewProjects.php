<?php 
require_once 'model/dbCategories.php';
require_once 'model/dbProjects.php';
require_once 'model/dbVersions.php';
require_once 'model/uploads.php';

function viewProjects()
{
    $dbProj = new dbProjects();
    $listProj = $dbProj->getAll();

    require 'view/viewProjects.php';
}

function viewProjectInsert()
{
    $dbCat = new dbCategories();
    $dbProj = new dbProjects();
    $regex = new Regex();
    $uploads = new UploadsProject();

    $nextID = $dbProj->getNumber('nextID');
    $listCats = $dbCat->getAll();

    if (isset($_GET['insert']) && isValidToken($_GET['token']))
    {
        header('Location: index.php?view=projectupdate&id='.$nextID.'');
        $typeCat = $_POST['typeCat'];
        $title = htmlspecialchars($_POST['titleProject']);
        $kind = htmlspecialchars($_POST['kindProject']);
        $platform = htmlspecialchars($_POST['platformProject']);
        $date = $_POST['dateProject'];
        $preview = $regex->fromBBCode($_POST['previewProject']);
        $desc = $regex->fromBBCode($_POST['descProject']);

        if (is_dir('../public/files/'.$title.'/'))
        {
            throw new Exception('Oops, un projet porte déjà ce nom.');
        }
        else
        {
            mkdir('../public/files/'.$title.'');
            mkdir('../public/files/'.$title.'/versions');
        }

        $uploads->uploadIcon($nextID);
        $dbProj->insert($nextID, $typeCat, $title, $kind, $platform, $date, $preview, $desc);
        exit();
    }

    require 'view/viewProjectInsert.php';
}

function viewProjectUpdate()
{
    if (empty($_GET['id']) OR !intval($_GET['id']))
    {
        throw new Exception('Oops, projet introuvable.');
    }
    else
    {
        $dbCat = new dbCategories();
        $dbProj = new dbProjects();
        $dbVersion = new dbVersions();
        $regex = new Regex();
        $uploads = new UploadsProject();

        $PROJ = $dbProj->getProject($_GET['id']);
        $listVersions = $dbVersion->getVersions($_GET['id']);
        $listCats = $dbCat->getAll();

        if (isset($_GET['del']) && !empty($_GET['id']) && isValidToken($_GET['token']))
        {   
            header('Location: index.php?view=projects');
            $dbProj->delete($_GET['id']);
            exit();
        }
        elseif (isset($_GET['update']) && !empty($_GET['id']) && isValidToken($_GET['token']))
        {   
            header('Location: index.php?view=projectupdate&id='.$_GET['id'].'');
            $id = $_GET['id'];
            $typeCat = $_POST['typeCat'];
            $title = htmlspecialchars($_POST['titleProject']);
            $kind = htmlspecialchars($_POST['kindProject']);
            $platform = htmlspecialchars($_POST['platformProject']);
            $date = $_POST['dateProject'];
            $preview = $regex->fromBBCode($_POST['previewProject']);
            $desc = $regex->fromBBCode($_POST['descProject']);

            $oldTitle = $_POST['oldTitle'];

            if (!empty($_FILES['icon']))
            {
                $uploads->uploadIcon($id);
            }

            if ($oldTitle != $title)
            {
                if (is_dir('../public/files/'.$title.'/'))
                {
                    throw new Exception('Oops, un projet porte déjà ce nom');
                }
                else
                {
                    rename('../public/files/'.$oldTitle.'/', '../public/files/'.$title.'/');
                }
            }

            $dbProj->update($id, $typeCat, $title, $kind, $platform, $date, $preview, $desc);
            exit();
        }
        require 'view/viewProjectUpdate.php';
    }
}

function viewVersionInsert()
{
    if (empty($_GET['project']) OR !intval($_GET['project']))
    {
        throw new Exception('Oops, projet introuvable.');
    }
    else
    {
        $dbVersion = new dbVersions();
        $regex = new Regex();
        $uploads = new UploadsProject();
        $dbProj = new dbProjects();

        $idProject = $_GET['project'];
        $PROJ = $dbProj->getProject($idProject);

        if (isset($_GET['insert']) && isValidToken($_GET['token']))
        {
            header('Location: index.php?view=projectupdate&id='.$idProject.'');
            $date = $_POST['dateVersion'];
            $theVersion = htmlspecialchars($_POST['theVersion']);
            $changelog = $regex->fromBBCode($_POST['changeLog']);
            $zip = $_FILES['zip'];

            $uploads->uploadVersion($theVersion, $PROJ['titleProject']);
            $dbVersion->insert($idProject, $date, $theVersion, $changelog);
            exit();
        }
    }

    require 'view/viewVersionInsert.php';
}

function viewVersionUpdate()
{
    if (empty($_GET['id']) OR !intval($_GET['id']))
    {
        throw new Exception('Oops, version introuvable.');
    }
    else
    {
        $dbVersion = new dbVersions();
        $regex = new Regex();
        $uploads = new UploadsProject();

        $QUERY_VERSION = $dbVersion->getVersion($_GET['id']);
        $VERSION = $QUERY_VERSION->fetch();

        if (isset($_GET['del']) && !empty($_GET['id']) && isValidToken($_GET['token']))
        {
            header('Location: index.php?view=projectupdate&id='.$VERSION['idProject'].'');
            $dbVersion->delete($_GET['id']);
            exit();
        }
        elseif (isset($_GET['update']) && !empty($_GET['id']) && isValidToken($_GET['token']))
        {
            header('Location: index.php?view=versionupdate&id='.$_GET['id'].'');
            $id = $_GET['id'];
            $date = $_POST['dateVersion'];
            $theVersion = htmlspecialchars($_POST['theVersion']);
            $changelog = $regex->fromBBCode($_POST['changeLog']);

            $oldversion = $_POST['oldVersion'];
            $titleProject = $VERSION['titleProject'];

            if ($theVersion != $oldversion)
            {
                if (file_exists('../public/files/'.$titleProject.'/versions/'.$theVersion.'.zip'))
                {
                    throw new Exception('Oops, cette version existe déjà.');
                }
                else
                {
                    rename('../public/files/'.$titleProject.'/versions/'.$oldVersion.'.zip', '../public/files/'.$titleProject.'/versions/'.$theVersion.'.zip');
                }
            }
            
            if (!empty($_FILES['zip']))
            {
                $uploads->uploadVersion($theVersion, $titleProject);
            }

            $dbVersion->update($id, $date, $theVersion, $changelog);
            exit();
        }

        require 'view/viewVersionUpdate.php';
    }

}