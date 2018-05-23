<?php
$page_title = PROJECT_NAME . ' | ' . 'Om os';
$login_btn = true;
if ($_SESSION['auth']) {
    $logout_btn = TRUE;
}

$user_feedback = UserFeedback::GetUserFeedback('ul');
$page_message = $user_feedback['messages'];
$page_message_class = $user_feedback['css'];

$address_info = array(
    'address' => 'Munkebjergvej 130',
    'zip' => '5020',
    'city' => 'Odense'
);

$page_script = '    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap">
    </script>' . PHP_EOL;
$page_script = '    <script src="//maps.google.com/maps/api/js?sensor=false&key=AIzaSyBohpiLc-mQRNL6nCIwojYsEjQgsh6novM"></script>' . PHP_EOL;
$page_script .= '<script src="' . ROOT . '/js/about.js"></script>';

require_once 'views/about.php';