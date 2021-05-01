<?php
require_once 'model/calendar.php';
require_once 'model/dbPosts.php';
require_once 'model/dbCategories.php';
require_once 'model/dbTools.php';
require_once 'model/regex.php';

function viewCalendar()
{
    if (isset($_GET['month']) && !intval($_GET['month']) || isset($_GET['year']) && !intval($_GET['year'])) {
        throw new Exception('Oops, une erreur est survenue.');
    } else {
        $month = new Month($_GET['month'] ??  null, $_GET['year'] ?? null);
    }

    $weeks = $month->getWeeks();

    if ($month->getFirstDay()->modify('last monday')->modify('+7 days')->format('d') != 01) {
        $firstGridDay = $month->getFirstDay()->modify('last monday');
    } else {
        $firstGridDay = $month->getFirstDay();
    }

    $regex = new Regex();
    $dbPosts = new dbPosts();
    $dbCats = new dbCategories();
    $dbTools = new dbTools();

    $postsMonth = $dbPosts->getMonthList($_GET['month'] ?? null, $_GET['year'] ?? null);
    $listCats = $dbCats->getAll();
    //$listTools = json_encode($dbTools->getAll()->fetchAll());

    $totalHoursInMonth = $dbPosts->getHoursInMonth($_GET['month'] ?? null, $_GET['year'] ?? null);
    $totalAverageHoursInMonth = $dbPosts->getAverageHoursInMonth($_GET['month'] ?? null, $_GET['year'] ?? null);
    $totalHoursInYear = $dbPosts->getHoursInYear($_GET['year'] ?? null);
    $totalHours = $dbPosts->getTotalHours();

    $catsHoursInMonth = json_encode($dbCats->getHoursInMonth($_GET['month'] ?? null, $_GET['year'] ?? null));
    $catsHoursInYear = json_encode($dbCats->getHoursInYear($_GET['year'] ?? null));
    $catsHours = json_encode($dbCats->getTotalHours());

    $toolsHoursInMonth = json_encode($dbTools->getHoursInMonth($_GET['month'] ?? null, $_GET['year'] ?? null));;
    $toolsHoursInYear = json_encode($dbTools->getHoursInYear($_GET['year'] ?? null));
    $toolsHours = json_encode($dbTools->getTotalHours());

    require 'view/viewCalendar.php';
}
