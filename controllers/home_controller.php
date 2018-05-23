<?php
$page_title = PROJECT_NAME . ' | ' . 'Home';
$login_btn = true;
if ($_SESSION['auth']) {
    $logout_btn = TRUE;
}

$page_content = 'Hej med jer';

$user_feedback = UserFeedback::GetUserFeedback('ul');
$page_message = $user_feedback['messages'];
$page_message_class = $user_feedback['css'];

require_once 'views/home.php';