<?php
require_once 'views/common/common_top.php';

?>
<div id="address_info">
    <ul>
	<li id="address"><?php echo $address_info['address'] ?></li>
	<li id="zip"><?php echo $address_info['zip'] ?></li>
	<li id="city"><?php echo $address_info['city'] ?></li>
    </ul>
</div>
<div id="map"></div>

<?php
require_once 'views/common/common_bottom.php';
?>

