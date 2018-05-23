<?php
session_start();
require_once 'config.php';
//print_r($_GET);
/** Routing */
if (empty($_GET['page'])){
    $page = 'home';
} else {
    $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS);
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
}
if (file_exists('controllers/' . $page .'_controller.php')) {
    require_once 'controllers/' . $page .'_controller.php';
} else {
    require_once 'views/404.php';
}