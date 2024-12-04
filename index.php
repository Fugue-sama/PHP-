<?php
require_once 'config/database.php';
spl_autoload_register(function ($className) {
    require_once "app/models/$className.php";
});
$productModel = new Product();
// $products = $productModel->all();



$categoryModel = new Category();
$categories = $categoryModel->all();

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

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <?php
                    foreach ($categories as $category) :
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="category.php?id=<?php echo $category['id'] ?>"><?php echo $category['name'] ?></a>
                        </li>
                    <?php
                    endforeach;
                    ?>
                </ul>
                <form class="d-flex" role="search" action="search.php" method="get">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="q">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <?php
                foreach ($categories as $category) :
                    $products = $productModel->findByCategory($category['id'], 4);
                ?>
                    <h2><?php echo $category['name'] ?></h2>
                    <div class="border rounded p-3">
                        <div class="row row-cols-1 row-cols-md-5 g-4">

                            <?php
                            foreach ($products as $product) :
                            ?>

                                <div class="col">
                                    <div class="card">
                                        <img src="public/images/<?php echo $product['image'] ?>" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title"> <a href="product.php?id=<?php echo $product['id'] ?>"><?php echo $product['name'] ?></a> </h5>
                                            <p class="card-text"><?php echo $product['price'] ?></p>
                                        </div>
                                    </div>
                                </div>

                            <?php
                            endforeach;
                            ?>
                        </div>
                    </div>
                <?php
                endforeach;
                ?>
            </div>


            <div class="col-sm-3">
                <h1>Recently view product</h1>
                <?php
                unset($_COOKIE['PHPSESSID']);
                $limit = 4;

                // Kiểm tra nếu số lượng cookie vượt quá giới hạn
                if (count($_COOKIE) > $limit) {
                    // Lấy tên cookie đầu tiên
                    $keys = array_keys($_COOKIE);
                    $firstCookie = $keys[0];
                    // Xóa cookie đầu tiên
                    unset($_COOKIE[$firstCookie]); // Xóa khỏi mảng $_COOKIE
                }
                // Hiển thị sản phẩm dựa trên cookie
                foreach ($_COOKIE as $key => $value) :
                    $pd = $productModel->find($value);    
                ?>
                    <div class="col">
                        <div class="card">
                            <img src="public/images/<?php echo $pd['image'] ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"> <a href="product.php?id=<?php echo $pd['id'] ?>"><?php echo $pd['name'] ?></a> </h5>
                                <p class="card-text"><?php echo $pd['price'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php
                endforeach;
                ?>
            </div>
        </div>
</body>

</html>