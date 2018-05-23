<?php
function myautoloader($classname) {
    if (file_exists('classes/' .$classname . '.php')) {
        require_once 'classes/' .$classname . '.php';
    } elseif (file_exists('model/' .$classname . '.php')) {
        require_once 'model/' .$classname . '.php';
    } elseif (file_exists('../classes/' .$classname . '.php')) {
        require_once '../classes/' .$classname . '.php';
    } elseif (file_exists('../model/' .$classname . '.php')) {
        require_once '../model/' .$classname . '.php';
    }
    
}
spl_autoload_register('myautoloader');

/** Connection */
define(DB_SERVER, 'localhost');
define(DB_USER, 'kne.wi');
define(DB_PASSWORD, '21436587');
define(DB_DATABASE, 'kne_wi_sde_dk');
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
$conn->set_charset('utf8');
/** Connection */

define('ROOT', '/wi_boilerplate');
define('PROJECT_NAME', 'bilbixen');