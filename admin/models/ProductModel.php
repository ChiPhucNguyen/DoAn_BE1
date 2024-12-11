<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/store/config/Database.php';

class ProductModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    public function getAllProducts()
    {
        $sql = "SELECT products.*, categories.name as category_name FROM products
                JOIN categories
                ON products.category_id = categories.category_id";
        return $this->db->getData($sql);
    }
    public function insertProduct($product_name, $product_price, $product_image, $category_id, $stock, $views, $sold)
    {
        $sql = "INSERT INTO products (name, price, img_url, category_id, stock, views, sold) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $parameters = [$product_name, $product_price, $product_image, $category_id, $stock, $views, $sold];
        $typeParams = "sisiiii";
        return $this->db->executeData($sql, $parameters, $typeParams);
    }
    public function updateProduct($product_id, $product_name, $product_price, $product_image, $category_id, $stock, $views, $sold)
    {
        $sql = "UPDATE products SET name = ?, price = ?, img_url = ?, category_id = ?, stock = ?, views = ?, sold = ? WHERE product_id = ?";
        $parameters = [$product_name, $product_price, $product_image, $category_id, $stock, $views, $sold, $product_id];
        $typeParams = "sisiiiii";
        return $this->db->executeData($sql, $parameters, $typeParams);
    }
    public function deleteProduct($product_id)
    {
        $sql = "DELETE FROM products WHERE product_id = ?";
        $parameters = [$product_id];
        $typeParams = "i";
        return $this->db->executeData($sql, $parameters, $typeParams);
    }
    public function searchProductByName($product_name)
    {
        $sql = "SELECT * FROM products WHERE name LIKE ?";
        $parameters = ["%$product_name%"];
        $typeParams = "s";
        return $this->db->getData($sql, $parameters, $typeParams);
    }
    public function getProductById($product_id)
    {
        $sql = "SELECT * FROM products WHERE product_id = ?";
        $parameters = [$product_id];
        $typeParams = "i";
        return $this->db->getData($sql, $parameters, $typeParams);
    }
    

}
