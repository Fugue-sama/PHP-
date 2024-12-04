<?php
require_once 'config/database.php';
spl_autoload_register(function ($className) {
    require_once "app/models/$className.php";
});
$id = $_GET['id'];
$productModel = new Product();
$product = $productModel->find($id);

// Cập nhật cookie
setcookie("{$product['id']}", $product['id'], time() + 3600);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <img src="public/images/<?php echo $product['image'] ?>" alt="" class="img-fluid">
            </div>
            <div class="col-md-8">
                <h1><?php echo $product['name'] ?></h1>
                <h4><?php echo $product['price'] ?></h4>
                <?php echo $product['description'] ?>
            </div>
        </div>
    </div>
</body>
</html>