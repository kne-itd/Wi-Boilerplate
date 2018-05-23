<?php
if ($car_info->image) {
    $car_img = $car_info->image;
} else {
    $car_img = 'no-image-available.png';
}
?>
<div class=" d-flex fl-row">
    

    <form action="" method="post" enctype="multipart/form-data" class="col-6">
        <div class="form-group">
            <label for="brand">Mærke</label>
            <input type="text" name="brand" id="brand" class="form-control" required value="<?php echo $car_info->brand ?>">
        </div>
        <div class="form-group">
            <label for="model">Model</label>
            <input type="text" name="model" id="model" class="form-control" required value="<?php echo $car_info->model ?>">
        </div>
        <div class="form-group">
            <label for="reg_date">Indregistringsdato</label>
            <input type="date" name="reg_date" id="reg_date" class="form-control" required value="<?php echo $car_info->reg_date ?>">
        </div>
        <div class="form-group">
            <label for="doors">Antal døre</label>
            <input type="number" value="4" name="doors" id="doors" class="form-control" required value="<?php echo $car_info->doors ?>">
        </div>
        <div class="form-group">
            <label for="mileage">Km. tal</label>
            <input type="number" value="100000" name="mileage" id="mileage" class="form-control" required value="<?php echo $car_info->mileage ?>">
        </div>
        <div class="form-group">
            <label for="price">Pris</label>
            <input type="number" value="100000" name="price" id="price" class="form-control" required value="<?php echo $car_info->price ?>">
        </div>
        <div class="form-group">
            <select name="category" class="form-control" >
                <?php echo $options ?>
            </select>
        </div>
        <div class="form-group">
            <label for="car_img">Foto</label>
            <input type="file" name="car_img" id="car_img">
        </div>

        <div class="form-group" class="form-control" >
            <input type="submit">
        </div>
    </form>
    <div class="col-6">
        <img src="<?php echo ROOT ?>/images/<?php echo $car_img?>" alt="<?php echo $car_info->brand ?>" width="400">
    </div>
</div>

