<?php
class Product extends Database
{

    //* admin Manager
    public function all()
    {
        // 2. Tạo câu query
        // $sql = parent::$connection->prepare('SELECT * from `products`');
        $sql = parent::$connection->prepare('SELECT `products`.*, GROUP_CONCAT(`categories`.`name`) AS category_name
                                            FROM `products`
                                            LEFT JOIN `category_product`
                                            ON `products`.`id` = `category_product`.`product_id`
                                            LEFT JOIN `categories`
                                            ON `categories`.`id` = `category_product`.`category_id`
                                            WHERE products.status = 1
                                            GROUP BY `products`.`id`');
        // 3 & 4
        return parent::select($sql);
    }

    //* description
    public function find($id)
    {
       
        // 2. Tạo câu query
        $sql = parent::$connection->prepare("SELECT `products`.*, GROUP_CONCAT(`category_product`.`category_id`) AS 'category_ids'
                                            FROM `products`
                                            LEFT JOIN `category_product`
                                            ON `products`.`id` = `category_product`.`product_id`
                                            WHERE `id`=?
                                            GROUP BY `products`.`id`");
        $sql->bind_param('i', $id);
        // 3 & 4
        return parent::select($sql)[0];
    }
    //*  product limit
    public function findByCategory($id, $limit = '')
    {
        $limit = ($limit != '') ? "LIMIT $limit" : '';
        // 2. Tạo câu query
        $sql = parent::$connection->prepare("SELECT *
                                            FROM `category_product`
                                            INNER JOIN `products`
                                            ON `category_product`.`product_id` = `products`.`id`
                                            WHERE `category_id`=?
                                            $limit");
        $sql->bind_param('i', $id);
        // 3 & 4
        return parent::select($sql);
    }

    //* search
    public function findByKeyWord($keyword)
    {
        // 2. Tạo câu query
        $sql = parent::$connection->prepare("SELECT * FROM `products` WHERE `name` LIKE ?");
        $keyword = "%{$keyword}%";
        $sql->bind_param('s', $keyword);
        // 3 & 4
        return parent::select($sql);
    }

    //* add form
    public function add($name, $price, $description, $image, $categoryIds)
    {
        // 2. Tạo câu query
        $sql = parent::$connection->prepare("INSERT INTO `products`(`name`, `price`, `description`, `image`) VALUES (?, ?, ?, ?)");
        $sql->bind_param('siss', $name, $price, $description, $image);
        // 3 & 4
        $sql->execute();

        // 2. Tạo câu query
        $productId = parent::$connection->insert_id;

        // Tạo chuỗi kiểu (?, id), (?, id), (?, id)
        $insertPlace = str_repeat("(?, $productId),", count($categoryIds) - 1) . "(?, $productId)";
        // Tạo chuỗi iiiiiiii
        $insertType = str_repeat('i', count($categoryIds));

        $sql = parent::$connection->prepare("INSERT INTO `category_product`(`category_id`, `product_id`) VALUES $insertPlace");

        $sql->bind_param($insertType, ...$categoryIds);
        return $sql->execute();
    }

//* edit
public function update($name, $price, $description, $image, $productId, $categoryIds)
{
    // 2. Tạo câu query
    $sql = parent::$connection->prepare("UPDATE `products` SET `name`=?,`price`=?,`description`=?,`image`=? WHERE `id`=?");
    $sql->bind_param('sissi', $name, $price, $description, $image, $productId);
    // 3 & 4
    $sql->execute();


    // Xóa categories cũ
    $sql = parent::$connection->prepare("DELETE FROM `category_product` WHERE `product_id`=?");
    $sql->bind_param('i', $productId);
    // 3 & 4
    $sql->execute();


    // Thêm categories mới
    // 2. Tạo câu query
    // Tạo chuỗi kiểu (?, id), (?, id), (?, id)
    $insertPlace = str_repeat("(?, $productId),", count($categoryIds) - 1) . "(?, $productId)";
    // Tạo chuỗi iiiiiiii
    $insertType = str_repeat('i', count($categoryIds));

    $sql = parent::$connection->prepare("INSERT INTO `category_product`(`category_id`, `product_id`) VALUES $insertPlace");

    $sql->bind_param($insertType, ...$categoryIds);
    return $sql->execute();
}

    //* bin Manager
    public function bin()
    {
        // 2. Tạo câu query
        // $sql = parent::$connection->prepare('SELECT * from `products`');
        $sql = parent::$connection->prepare('SELECT `products`.*, GROUP_CONCAT(`categories`.`name`) AS category_name
                                            FROM `products`
                                            LEFT JOIN `category_product`
                                            ON `products`.`id` = `category_product`.`product_id`
                                            LEFT JOIN `categories`
                                            ON `categories`.`id` = `category_product`.`category_id`
                                            WHERE products.status = 0
                                            GROUP BY `products`.`id`');
        // 3 & 4
        return parent::select($sql);
    }

    //* update bin
    public function updateBin($product_id)
    {

        //todo insert to bin_product table
        $sql = parent::$connection->prepare("UPDATE `products` SET `status`= 0  WHERE id = ? ");
        $sql->bind_param('i', $product_id);
        $sql->execute();
    }

    //* delete in database
    public function delete($product_id) {
        //todo delete the category where id  = ...
        $sql = parent::$connection->prepare('DELETE FROM `categories` WHERE id = ?');

        //todo delete the product out of the databse
        $sql = parent::$connection->prepare('DELETE FROM `products` WHERE id = ?');

        //Todo bind_param 
        $sql->bind_param('i', $product_id);
        $sql->execute();
    }

    ///* delete all in bin 
    public function deleteBin() {

        
    }

}
