<?php
require_once 'views/common/common_top.php';

if (empty($page_content)) {
    $page_content = '';
}
?>
<div class="row h-100">
<?php
require_once 'views/common/side_menu.php';
?>
    <div class="col-10">
        <div class="alert alert-<?php echo $page_message_class?>" user-feedback"><?php echo $page_message ?></div>
        <h3>Hello world from admin home</h3>
    </div>
</div>
<?php
require_once 'views/common/common_bottom.php';
?>