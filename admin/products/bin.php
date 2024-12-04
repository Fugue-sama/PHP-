<?php
require_once '../../config/database.php';
spl_autoload_register(function ($className) {
    require_once "../../app/models/$className.php";
});
$productModel = new Product();


$products = $productModel->bin();
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
        <h1>
            Bin Products
            <a href="index.php" class="btn btn-outline-primary">Back</a>
            <a href="add.php" class="btn btn-outline-primary">Add</a>
            <form method="POST" action="bin.php" onsubmit="return confirm('Xóa toàn bộ ?')">
                <button type="submit" name="delete">Delete all</button>
            </form>
        </h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Categories</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($products as $product) :
                ?>
                    <tr>
                        <td><?php echo $product['id'] ?></td>
                        <td><?php echo $product['name'] ?></td>
                        <td><?php echo $product['price'] ?></td>
                        <td>
                            <?php
                            echo (!empty($product['category_name'])) ? implode(array_map(function ($e) {
                                return "<span class='badge text-bg-warning'>$e</span>";
                            }, explode(',', $product['category_name']))) : '';
                            ?>
                        </td>
                        <td><img src="../../public/images/<?php echo $product['image'] ?>" width="50"></td>
                        <td>
                            <form action="bin.php" method="post" onsubmit="return confirm ('Khôi phục lại ?')">
                                <input type="hidden" name="product-idRes" value="<?php echo $product['id'] ?>">
                                <button type="submit" class="btn btn-outline-primary">Restore</button>
                            </form>

                            <form action="bin.php" method="post" onsubmit="return confirm('Xóa không?')">
                                <input type="hidden" name="product-id" value="<?php echo $product['id'] ?>">
                                <button type="submit" class="btn btn-outline-danger ">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php
                endforeach;
                ?>

            </tbody>
        </table>
    </div>
    
    <script>
        
    </script>
</body>

</html>