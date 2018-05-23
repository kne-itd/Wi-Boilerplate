<?php
/**
 * Description of UserFeedback
 *
 * @author kaj
 */
class UserFeedback {
    
    public static function SetUserFeedback($message, $error = false)
    {
        $_SESSION['user_feedback_class'] = 'success';
        $_SESSION['user_feedback'][] = $message;
        if ($error) {
            $_SESSION['user_feedback_class'] = 'warning';
        }
        
    }
    
    public static function GetUserFeedback($html = null)
    {
        $feedback['messages'] = $_SESSION['user_feedback'];
        $feedback['css'] = $_SESSION['user_feedback_class'];
        unset($_SESSION['user_feedback']);
        unset($_SESSION['user_feedback_class']);
        
        if (is_array($feedback['messages'])) {
            switch ($html) {
                case 'ul':
                    $output = '<ul>';
                    foreach ($feedback['messages'] as $value) {
                        $output .= '<li>' . $value . '</li>';
                    }
                    $output .= '</ul>';               
                    break;
                    case 'ol':
                        $output = '<ol>';
                    foreach ($feedback['messages'] as $value) {
                        $output .= '<li>' . $value . '</li>';
                    }
                    $output .= '</ol>';  
                    break;
                default:
                    $output = $feedback['messages'];
                    break;
            }
            $feedback['messages'] = $output;
        }
        return $feedback;
    }
}
