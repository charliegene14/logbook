<?php

if (isset($_GET['e']) && $_GET['e'] == 404) {
    $message = 'Oops... La page demandée n\'existe pas...';
} else {
    $message = $e->getMessage();
}