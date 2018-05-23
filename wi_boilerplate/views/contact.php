<?php
require_once 'views/common/common_top.php';
?>
<form action="<?php echo ROOT ?>/contact/post" method="post">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" required="">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required="">
    </div>
    <div class="form-group">
        <label for="message">Message</label>
        <textarea name="message" id="message" class="form-control" required=""></textarea>
    </div>
    <div class="form-group">
        <input type="submit">
    </div>
</form>


<?php
require_once 'views/common/common_bottom.php';
?>

