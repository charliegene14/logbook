<?php
define('__ROOT__', dirname(__FILE__));

/**
 * Get the website head title
 */
function getHeadTitle() {
    require_once __ROOT__.'/model/dbInfos.php';
    $info = new dbInfo();

    return $info->getContent('Head');
}

/**
 * Get the main menu
 */
function getMenu() {
    require_once __ROOT__.'/model/dbInfos.php';
    require_once __ROOT__.'/model/dbNavigation.php';
    require_once __ROOT__.'/model/dbCategories.php';
    require_once __ROOT__.'/model/dbProjects.php';

	$info = new dbInfo();
	$table_navigation = new dbNavigation(); $navigation = $table_navigation->getAll();
	$table_categories = new dbCategories(); $categories = $table_categories->getAll();
	$table_projects = new dbProjects(); $projects = $table_projects->getAll();

    require_once __ROOT__.'/view/menu.php';
}

/**
 * Get all styles files
 */
function getStyles() {
    ?>

    <link
        rel="stylesheet"
        href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <link rel="stylesheet" href="public/css/style.css" />

  <?php
}

/**
 * Get all scripts files.
 */
function getScripts() {
    ?>

    <!--    jQuery  -->
	<script
  		src="https://code.jquery.com/jquery-3.6.0.min.js"
  		integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  		crossorigin="anonymous">
	</script>

    <!--    Angular JS  -->
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>

    <!--    Angular JS Route module -->
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-route.js"></script>

    <!--    Logbook menu    -->
    <script src="/public/js/menu.js"></script>

    <!-- Some global functions -->
    <script src="/public/js/functions.js"></script>

    <!--    Swiper JS   -->
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

    <!--    Chart JS    -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@next"></script>

    <?php
        /**
		  * Angular JS Config File
		  * Contains routes
		  */
        require __ROOT__.'/public/js/app.js.php';
}