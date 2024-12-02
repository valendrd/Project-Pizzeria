<?php
session_start();
if ($_SESSION['logueado']) {

include_once("config_products.php");
include_once("db.class.php");

$link=new Db();
$idUpd=$_GET["q"];
$sql="select p.id_product as id_product,p.id_category as id_category,c.category_name as category_name,p.product_name as product_name,p.price as price from products p inner join categories c on p.id_category=c.id_category where p.id_product=".$idUpd;
$stmt=$link->prepare($sql);
$stmt->execute();
$data = $stmt->fetch();
//var_dump($data);

}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="css/insert_products.css">
</head>
<body>

<div class="container">
<div class="row">
<div class="col-md-12">
				<h3 class="text-center">ACTUALIZAR PRODUCTOS</h3>
</div>
<div class="col-md-12">
<form class="form-group" accept-charset="utf-8" method="post" action="update_products.php">
<div class="form-group">
<label class="control-label">NOMBRE</label>
<input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $data['product_name'] ?>">
</div>
<div class="form-group">
<label class="control-label">PRECIO</label>
<input id="precio" name="precio" class="form-control" type="text" value="<?php echo $data['price'] ?>">
</div>
<div class="form-group">
<label class="control-label">CATEGORIA </label>
<select id="categoria" name="categoria" class="form-control">
<option value="<?php echo $data['id_category'] ?>">
<?php echo $data['category_name'] ?></option>
<?php
$sqlCategory ="select id_category as id_category ,category_name as category_name from categories order by category_name";
$stmt = $link->prepare($sqlCategory);
$stmt->execute();
$dataCategory = $stmt->fetchAll();
foreach ($dataCategory as $row) {
if ($data['category_name'] != $row['category_name'])
{
?>
<option value="<?php echo $row['id_category'] ?>"> <?php echo $row['category_name'] ?></option>

<?php
}
}

?>
</select>
</div>

<div class="text-center">
<br>
<input type="submit" class="btn btn-success" value="Guardar Producto">
</div>
<div class="form-group">
				<input type="hidden" name="id" value="<?php echo $data['id_product'] ?>">
</div>
</form>
</div>

</div>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.0/bootbox.min.js" integrity="sha512-oVbWSv2O4y1UzvExJMHaHcaib4wsBMS5tEP3/YkMP6GmkwRJAa79Jwsv+Y/w7w2Vb/98/Xhvck10LyJweB8Jsw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>