<?php
$page_title = PROJECT_NAME . ' | ' . 'Sign in';
$login_btn = true;
if ($_SESSION['auth']) {
    $logout_btn = TRUE;
}
$page_script = '<script src="' . ROOT . '/js/signin.js"></script>';

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
	if ($usr->Login()) {
            UserFeedback::SetUserFeedback($_SESSION['auth']['email'] . ' er logget ind som ' . $_SESSION['auth']['level']);
	    header('location: ' . ROOT . '/home');
	} else {
            UserFeedback::SetUserFeedback('Du kunnne ikke logges ind', true);
	    header('location: ' . ROOT . '/signin');
	}

        break;

    case 'signout':
	$usr = new User($conn);
	$usr->Logout();
        UserFeedback::SetUserFeedback('Du er nu logget ud');
	header('location: ' . ROOT . '/home');
	break;;
    case 'forgotten_password':
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
	$usr = new User($conn);
	$usr->setEmail($email);
	$usr_info = $usr->FetchByEmail($email)[0];
	if (empty($usr_info)) {
            UserFeedback::SetUserFeedback('Email adressen er ikke kendt', true);

	} else {
            $new_password = $usr->GeneratePassword();
            $usr->setPassword(password_hash($new_password, PASSWORD_DEFAULT));
            $usr->setUser_id($usr_info->user_id);
            $usr->Edit(array('password'));
//            mail($usr->getEmail(), 'Nyt Password fra' . PROJECT_NAME, $new_password);
            UserFeedback::SetUserFeedback('Et nyt password(' . $new_password . ') er sendt til din email');
	}
        header('location: ' . ROOT . '/signin');
	break;
    default:
        break;
}

require_once 'views/signin.php';