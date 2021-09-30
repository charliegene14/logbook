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
	<script type="text/javascript"
            src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js">
    </script>

    <!--    Angular JS Route module -->
	<script type="text/javascript"
            src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-route.js">
    </script>

    <!--    Logbook menu    -->
    <script type="text/javascript"
            src="/public/js/menu.js">
    </script>

    <?php

    /**
     * Angular JS Config File
     * Contains routes
     */
    require_once __ROOT__.'/public/js/app.js.php';
}