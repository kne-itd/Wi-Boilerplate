<?php
$page_title = PROJECT_NAME . ' | ' . 'Kontakt';
$login_btn = true;
if ($_SESSION['auth']) {
    $logout_btn = TRUE;
}
$page_script = '<script src="' . ROOT . '/js/contact.js"></script>';

$user_feedback = UserFeedback::GetUserFeedback('ul');
$page_message = $user_feedback['messages'];
$page_message_class = $user_feedback['css'];

switch ($action) {
    case 'post':
//        print_r($_POST);
//        work the post-values
        if (1 == 1) {
            UserFeedback::SetUserFeedback('Din besked er modtaget');
//            $page_message = 'Din besked er modtaget';
//	    $page_message_class = 'alert-success';
        } else {
            UserFeedback::SetUserFeedback('Din besked kunne ikke sendes', TRUE);
//            $page_message = 'Din besked kunne ikke sendes';
//	    $page_message_class = 'alert-warning';
        }
        header('location: ' . ROOT . '/contact');
//	$_SESSION['page_message'][] = $page_message;
//	$_SESSION['page_message_class'] = $page_message_class;
        break;

    default:
        break;
}

require_once 'views/contact.php';