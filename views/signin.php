<?php
require_once 'views/common/common_top.php';
?>
<h2>Login til <?php echo PROJECT_NAME ?></h2>
<div id="signin">
    <p>
	Hvis du endnu ikke er oprettet som bruger, kan du oprette dig her... 
	<a href="<?php echo ROOT ?>/signup"><button type="button" class="btn btn-primary">Signup</button></a>
    </p>

    <form action="<?php echo ROOT ?>/signin/post" method="post">
     <?php if ($login_type === 'username') { ?>    
	<div class="form-group">
	    <label for="username">Username</label>
	    <input type="text" name="username" id="username" class="form-control" required>
	</div>
    <?php } elseif ($login_type === 'email') { ?>    
	<div class="form-group">
	    <label for="email">Email</label>
	    <input type="email" name="email" id="email" class="form-control" required>
	</div>
    <?php } ?>     
	<div class="form-group">
	    <label for="password">Password</label>
	    <input type="password" name="password" id="password" class="form-control" required>
	</div>

	<div class="form-group">
	    <input type="submit">
	</div>
    </form>
    <p>
	<a href="#" id="btn_forgotten_password">
	    Har du glemt dit password?
	</a>
    </p>
</div>
<div id="frm_forgotten_password">
    <p>Indtast din email-adresse, så sender vi dig et nyt password</p>
    <form action="<?php echo ROOT ?>/signin/forgotten_password" method="post">
	<div class="form-group">
	    <label for="mail">Email</label>
	    <input type="email" name="email" id="mail" class="form-control" required>
	</div>
	<div class="form-group">
	    <input type="submit">
	</div>
    </form>
</div>

<?php
require_once 'views/common/common_bottom.php';
?>

