<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/store/config/Database.php';

class ProductModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    public function getAllProducts($page, $limit)
    {
        $page = (int)$page > 0 ? (int)$page : 1;
        $offset = ($page - 1) * $limit;
        $total = $this->getTotalProducts();
        $sql = "SELECT products.*, categories.name as category_name FROM products
                JOIN categories
                ON products.category_id = categories.category_id LIMIT ?, ?";
        $parameters = [$offset, $limit];
        $typeParams = "ii";
        $results = $this->db->getData($sql, $parameters, $typeParams);
        return [
            'total' => (int)$total,
            'items' => $results
        ];
    }
    public function getTotalProducts()
    {
        $sql = "SELECT COUNT(*) AS total_count FROM products";
        $results = $this->db->getData($sql);
        return $results[0]['total_count'] ?? 0;
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
    public function searchProductByName($product_name, $page, $limit)
    {
        
        $page = (int)$page > 0 ? (int)$page : 1;
        $offset = ($page - 1) * $limit;
        $total = $this->getTotalSearchProduct($product_name);
        $sql = "SELECT * FROM products WHERE name LIKE ? LIMIT ?, ?";
        $parameters = ["%$product_name%", $offset, $limit];
        $typeParams = "sii";
        $results = $this->db->getData($sql, $parameters, $typeParams);
        return [
            'total' => (int)$total,
            'items' => $results
        ];
    }
    public function getTotalSearchProduct($product_name)
    {
        $sql = "SELECT COUNT(*) AS total_count FROM products WHERE name LIKE ?";
        $parameters = ["%$product_name%"];
        $typeParams = "s";
        $results = $this->db->getData($sql, $parameters, $typeParams);
        return $results[0]['total_count'];
    }
    public function getProductById($product_id)
    {
        $sql = "SELECT * FROM products WHERE product_id = ?";
        $parameters = [$product_id];
        $typeParams = "i";
        return $this->db->getData($sql, $parameters, $typeParams);
    }
    

}
