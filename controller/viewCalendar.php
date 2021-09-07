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

    $totalHoursInMonth = $dbPosts->getHoursInMonth($_GET['month'] ?? null, $_GET['year'] ?? null);
    $totalAverageHoursInMonth = $dbPosts->getAverageHoursInMonth($_GET['month'] ?? null, $_GET['year'] ?? null);
    $totalHoursInYear = $dbPosts->getHoursInYear($_GET['year'] ?? null);
    $totalHours = $dbPosts->getTotalHours();

    $catsHoursInMonth = json_encode($dbCats->getHoursInMonth($_GET['month'] ?? null, $_GET['year'] ?? null));
    $catsHoursInYear = json_encode($dbCats->getHoursInYear($_GET['year'] ?? null));
    $catsHours = json_encode($dbCats->getTotalHours());

    $toolsHoursInMonth = json_encode($dbTools->getHoursInMonth($_GET['month'] ?? null, $_GET['year'] ?? null));
    $toolsHoursInYear = json_encode($dbTools->getHoursInYear($_GET['year'] ?? null));
    $toolsHours = json_encode($dbTools->getTotalHours());

    $catsHoursInAllMonths = [];
    $toolsHoursInAllMonths = [];
    $totalHoursInAllMonths = [];

    for ($i = 1; $i <= 12; $i++) {

        $dataCats       = $dbCats   ->getHoursInMonth($i    , $_GET['year'] ?? intval(date('Y')));
        $dataTools      = $dbTools  ->getHoursInMonth($i    , $_GET['year'] ?? intval(date('Y')));
        $dataTotal      = $dbPosts  ->getHoursInMonth($i    , $_GET['year'] ?? intval(date('Y')));

        $newCatsArray   = [];
        $newToolsArray  = [];

        foreach($dataCats as $cat){
            $cat['Month'] = $i;
            array_push($newCatsArray, $cat);
        }

        foreach($dataTools as $tool){
            $tool['Month'] = $i;
            array_push($newToolsArray, $tool);
        }

        $dataTotal['Month'] = $i;

        array_push  ($totalHoursInAllMonths , $dataTotal);
        array_push  ($catsHoursInAllMonths  , $newCatsArray);
        array_push  ($toolsHoursInAllMonths , $newToolsArray);
    }

    $jsCatsInAllMonths   = json_encode($catsHoursInAllMonths);
    $jsToolsInAllMonths  = json_encode($toolsHoursInAllMonths);
    $jsTotalInAllMonths  = json_encode($totalHoursInAllMonths);

    require 'view/viewCalendar.php';
}
