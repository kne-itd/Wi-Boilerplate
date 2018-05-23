<?php
session_start();
$page_title = PROJECT_NAME . ' | ' . 'Admin | ' . $page;

$page_css .= '<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.1/bootstrap-table.min.css">';
$page_script .= PHP_EOL . '<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.1/bootstrap-table.min.js"></script>';
$page_script .= PHP_EOL . '<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.1/locale/bootstrap-table-da-DK.min.js"></script>';
$page_script .= PHP_EOL . '<script src="' . ROOT . '/admin/js/produkt.js"></script>';

$user_feedback = UserFeedback::GetUserFeedback('ul');
$page_message = $user_feedback['messages'];
$page_message_class = $user_feedback['css'];

$car = new Car($conn);
$category = new Category($conn);

switch ($action) {
    case 'create':
        if (!empty($_POST)) {
            setProperties($car);
            $photo = $_FILES['car_img'];
            
            if ($photo['error'] == 0) {
                $photo_info = upload_and_resize($photo);
                $car->setImage($photo_info['filename']);
            }
            $car->Save();
            UserFeedback::SetUserFeedback('Produktet er oprettet');

	    header('location: ../list');
        }
        $categoriy_list = $category->Fetch();
        $page_content = 'form';

        
        break;
    case 'edit':
        $car->setCar_id($id);
        if (!empty($_POST)) {

            setProperties($car);
            $photo = $_FILES['car_img'];
            $fields_to_update = array('brand', 'model', 'reg_date', 'price', 'doors', 'mileage', 'category_id');
            if ($photo['error'] == 0) {
                $car_info = $car->Fetch($id)[0];
                $delete_image = '../images/' . $car_info->image;
                
                if (file_exists($delete_image)) {
                    unlink( $delete_image);
                }
            
                $photo_info = upload_and_resize($photo);
                $car->setImage($photo_info['filename']);
                $fields_to_update[] = 'image';
            }
            
            if ($car->Edit($fields_to_update) ) {
                UserFeedback::SetUserFeedback('Produktet er opdateret');
            } else {
                UserFeedback::SetUserFeedback('Produktet kunne ikke opdateres', true);
            }
	    header('location: ../list'); 
           
        }
        $car_info = $car->Fetch($id)[0];
        $page_content = 'form';
        $categoriy_list = $category->Fetch();
//        $page_content = 'Her kommer en formular til redigering af produkter produkter med id ' . $id;
    break;

    case 'slet':
        $car->setCar_id($id);
        $car_info = $car->Fetch($id)[0];
        $delete_image = '../images/' . $car_info->image;
        
        if ($car->Delete()) {
            UserFeedback::SetUserFeedback('Produktet er slettet.');
            
            if (file_exists($delete_image)) {
                unlink( $delete_image);
                UserFeedback::SetUserFeedback(' Og det tilhørende billede ligeså.');
            }
            
        } else {
            UserFeedback::SetUserFeedback('Produktet kunne ikke slettes.', TRUE);

        }

        header('location: ../list');
        break;
    
    case 'list':
    default:
        $car_list = $car->FetchWithCategory();
        $page_content = 'list';
        break;
}

function setProperties($car) {
    $brand      = trim(filter_input(INPUT_POST, 'brand', FILTER_SANITIZE_SPECIAL_CHARS));
    $model      = trim(filter_input(INPUT_POST, 'model', FILTER_SANITIZE_SPECIAL_CHARS));
    $reg_date   = trim(filter_input(INPUT_POST, 'reg_date', FILTER_SANITIZE_SPECIAL_CHARS));
    $price      = trim(filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT));
    $doors      = trim(filter_input(INPUT_POST, 'doors', FILTER_SANITIZE_NUMBER_INT));
    $mileage    = trim(filter_input(INPUT_POST, 'mileage', FILTER_SANITIZE_NUMBER_INT));
    $category_id =trim(filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT));

    $car->setBrand($brand);
    $car->setModel($model);
    $car->setReg_date($reg_date);
    $car->setPrice($price);
    $car->setDoors($doors);
    $car->setMileage($mileage);
    $car->setCategory_id($category_id);    
}
function upload_and_resize($photo) {
    $uploader = new Upload();
    $uploader->setFile($photo);
    $uploader->setAllowed_mime_types(array('image/jpeg', 'image/jpg', 'image/png'));
    $uploader->setMax_file_size(2);
    $uploader->setDir( '../images');
    try {
        $photo_info = $uploader->Upload();
        
        // Resize the uploaded photo
        $image = new Image();
        $image->setImageInfo($photo_info);
        $image->setMaxHeight(400);
        $image->setMaxWidth(400);
        $a = $image->resize()->saveImage();
        // thumbnail...
        /*
        $image->setImageInfo($photo_info);
        $image->setMaxHeight(200);
        $image->setMaxWidth(200);
        $image->setThumbPrefix('t_');
        $b = $image->resize()->saveImage();
        */
       return $photo_info;
    } catch (Exception $exc) {
        $page_message = $exc->getMessage();
    }
}
require_once 'views/produkt.php';
