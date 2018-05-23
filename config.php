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
define(DB_SERVER, 'YOUR-DATABSE-SERVER');
define(DB_USER, 'YOUR-DATABASE-USERNAME');
define(DB_PASSWORD, 'YOUR-DATABASE-PASSWORD');
define(DB_DATABASE, 'YOUR-DATABASE-NAME');
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

if ( $conn->connect_errno) {
    die('Kunne ikke forbinde (' . $conn->connect_errno . ') 
        ' . $conn->connect_error);
}
$conn->set_charset('utf8');
/** Connection */

define('ROOT', '/PATH-TO-WEB-SERVERS-ROOT');
define('PROJECT_NAME', 'YOUR-PROJECT-NAME-AS-IT-SHOULD-APPEAR-IN-PAGE-TITLES-ETC');