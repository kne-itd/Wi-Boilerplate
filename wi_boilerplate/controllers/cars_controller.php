<?php
$page_title = PROJECT_NAME . ' | ' . 'Cars';
$login_btn = true;
if ($_SESSION['auth']) {
    $logout_btn = TRUE;
}
$seach_bar = true;

$user_feedback = UserFeedback::GetUserFeedback('ul');
$page_message = $user_feedback['messages'];
$page_message_class = $user_feedback['css'];

switch ($action) {
    case 'search':
//        work the post-values
        $searchQuery = filter_input(INPUT_GET, 'search_query', FILTER_SANITIZE_SPECIAL_CHARS);
        if (1 == 1) {
            UserFeedback::SetUserFeedback('Din besked er modtaget');
            $page_content = 'du søgte efter ' . $searchQuery;
        } else {
            UserFeedback::SetUserFeedback('Din besked er modtaget', TRUE);
        }
        break;

    default:
        break;
} 

require_once 'views/cars.php';