<?php

if (isset($_GET['e']) && $_GET['e'] == 404) {
    $content = '<h1>404</h1><p>Oops, la page demandée n\'existe pas.</p>';
} else {
    $content = '<h1>Erreur</h1><p>'.$e->getMessage().'</p>';
}