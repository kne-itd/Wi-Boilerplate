<?php
$page_title = PROJECT_NAME . ' | ' . 'Sign up';
$login_btn = true;

// username or email?
$login_type = 'email';
//$login_type = 'username';

$user_feedback = UserFeedback::GetUserFeedback('ul');
$page_message = $user_feedback['messages'];
$page_message_class = $user_feedback['css'];

switch ($action) {
    case 'post':
	$email = filter_input(INPUT_POST, $login_type, FILTER_SANITIZE_EMAIL);
//	$username = filter_input(INPUT_POST, $login_type, FILTER_SANITIZE_SPECIAL_CHARS);
	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
	$usr = new User($conn);
	$usr->setEmail($email);
	$usr->setPassword($password);
	$usr->setLevel('dealer');
        $save_result = $usr->Save();
	if ( is_int( $save_result )) {
            
	    UserFeedback::SetUserFeedback('Du er oprettet som bruger');

	    if ($usr->Login()) {
                UserFeedback::SetUserFeedback($_SESSION['auth']['email'] . ' er logget ind som ' . $_SESSION['auth']['level']);
	    } else {
                UserFeedback::SetUserFeedback('Du kunne ikke logges ind', true);
		header('location: ' . ROOT . '/signin');
	    }
	    
	    header('location: ' . ROOT . '/home');
        } elseif (substr ($save_result, 0, 10)  == 'error(1062'){
            UserFeedback::SetUserFeedback('Du kunne ikke oprettes som bruger. Email-adressen er i brug', true);
            header('location: ' . ROOT . '/signup');
	} else {
            UserFeedback::SetUserFeedback('Du kunne ikke oprettes som bruger', true);
	    header('location: ' . ROOT . '/signup');
	}
	
        break;

    default:
        break;
}

require_once 'views/signup.php';