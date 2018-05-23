<?php
require_once 'views/common/common_top.php';
$options = '';
if (is_array($categoriy_list)) {
    foreach ($categoriy_list as $value) {
        $selected = '';
        if ($value->category_id == $car_info->category_id) {
            $selected = 'selected';
        }
        $options .= '<option value="' . $value->category_id . '" ' .  $selected . '>' . $value->category . '</option>';
    }
}
    
?>
<div class="row">

<?php
require_once 'views/common/side_menu.php';
?>

    <div class="col-10">
        <div class="alert alert-<?php echo $page_message_class?> user-feedback"><?php echo $page_message ?></div>
        <?php require_once 'views/produkt_' . $page_content . '.php'; ?>
    </div>
</div>
<?php
require_once 'views/common/common_bottom.php';
?>


