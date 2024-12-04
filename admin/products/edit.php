<?php
require_once '../../config/database.php';
spl_autoload_register(function ($className) {
    require_once "../../app/models/$className.php";
});

$categoryModel = new Category();
$categories = $categoryModel->all();

$id = $_GET['id'];
$productModel = new Product();
$product = $productModel->find($id);

if (!empty($_POST['name']) && !empty($_POST['price']) && !empty($_POST['description']) && !empty($_POST['image']) && !empty($_POST['category-id'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $categoryId = $_POST['category-id'];
    if ($productModel->update($name, $price, $description, $image, $id, $categoryId))
        header("Location: http://localhost/be1_mysql/admin/products");
}
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
        <h1>Edit Product</h1>
        <form action="edit.php?id=<?php echo $product['id'] ?>" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $product['name'] ?>">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo $product['price'] ?>">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"><?php echo $product['description'] ?></textarea>
                
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="text" class="form-control" id="image" name="image" value="<?php echo $product['image'] ?>">
            </div>

            <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                <?php
                foreach ($categories as $category) :
                    $checked = (!empty($product['category_ids']) && in_array($category['id'], explode(',', $product['category_ids']))) ? 'checked' : '';
                ?>
                <input type="checkbox" class="btn-check" id="category-<?php echo $category['id'] ?>" autocomplete="off" value="<?php echo $category['id'] ?>" name="category-id[]" <?php echo $checked ?>>
                
                
                <label class="btn btn-outline-primary" for="category-<?php echo $category['id'] ?>"><?php echo $category['name'] ?></label>
                <?php
                endforeach;
                ?>
                
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>

</html>