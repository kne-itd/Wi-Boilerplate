<?php
?>
<h3>Produkt liste</h3>
<a href="create"><button type="button" class="btn btn-primary">Opret nyt produkt</button></a>
<table class="table table-striped" data-pagination="true" data-search="true" data-toggle="table">
    <thead>
        <tr>
            <th data-sortable="true">Mærke</th>
            <th data-sortable="true">Model</th>
            <th data-sortable="true">Årgang</th>
            <th data-sortable="true">Km-tal</th>
            <th>Døre</th>
            <th data-sortable="true">Pris</th>
            <th data-sortable="true">Kategori</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($car_list as $item) { 
    $mileage = number_format($item->mileage, 0, ',', '.');
    $price = number_format($item->price, 0, ',', '.');
?>
        <tr>
            <td><?php echo $item->brand?></td>
            <td><?php echo $item->model?></td>
            <td><?php echo $item->reg_date?></td>
            <td><?php echo $mileage?></td>
            <td><?php echo $item->doors?></td>
            <td><?php echo $price?></td>
            <td><?php echo $item->category?></td>
            <td><a href="edit/<?php echo $item->car_id?>"><i class="fas fa-edit"></i></a></td>
            <td><a href="slet/<?php echo $item->car_id?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
        </tr>
<?php } ?>
    </tbody>
</table>

