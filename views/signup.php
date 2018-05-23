<?php
require_once 'views/common/common_top.php';
?>
<h3>Opret dig som bruger</h3>
<form action="<?php echo ROOT ?>/signup/post" method="post">
 <?php if ($login_type === 'username') { ?>    
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" class="form-control" required="">
    </div>
<?php } elseif ($login_type === 'email') { ?>    
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required="">
    </div>
<?php } ?>     
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" required="">
    </div>

    <div class="form-group">
        <input type="submit">
    </div>
</form>


<?php
require_once 'views/common/common_bottom.php';
?>

