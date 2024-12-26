<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/store/config/Database.php';

class CategoryModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    public function getAllCategories()
    {
        $sql = "SELECT * FROM categories";
        return $this->db->getData($sql);
    }
    public function getCategories($page = 1, $limit)
    {
        $total = $this->getTotalCategories();
        $page = (int)$page > 0 ? (int)$page : 1;
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM categories 
        ORDER BY created_at DESC
        LIMIT ?, ?";
        $parameters = [$offset, $limit];
        $typeParams = "ii";
        $results = $this->db->getData($sql, $parameters, $typeParams);
        return [
            'total' => (int)$total,
            'items' => $results
        ];
    }
    public function getTotalCategories()
    {
        $sql = "SELECT COUNT(*) AS total_count FROM categories";
        $results = $this->db->getData($sql);
        return $results[0]['total_count'] ?? 0;
    }
    public function insertCategory($category_name)
    {
        $sql = "INSERT INTO categories (name) VALUES (?)";
        $parameters = [$category_name];
        $typeParams = "s";
        return $this->db->executeData($sql, $parameters, $typeParams);
    }
    public function updateCategory($category_id, $category_name, $description)
    {
        $sql = "UPDATE categories SET name = ?, description = ? WHERE category_id = ?";
        $parameters = [$category_name, $description, $category_id];
        $typeParams = "ssi";
        return $this->db->executeData($sql, $parameters, $typeParams);
    }
    public function deleteCategory($category_id)
    {
        $sql = "DELETE FROM categories WHERE category_id = ?";
        $parameters = [$category_id];
        $typeParams = "i";
        return $this->db->executeData($sql, $parameters, $typeParams);
    }
    public function searchCategoryByName($category_name, $page, $limit)
    {
        
        $total = $this->getTotalSearchCategory($category_name);
        $page = (int)$page > 0 ? (int)$page : 1;
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM categories WHERE name LIKE ? LIMIT ?, ?";
        $parameters = ["%$category_name%", $offset, $limit];
        $typeParams = "s";
        return $this->db->getData($sql, $parameters, $typeParams);
    }
    public function getTotalSearchCategory($category_name)
    {
        $sql = "SELECT COUNT(*) AS total_count FROM categories WHERE name LIKE ?";
        $parameters = ["%$category_name%"];
        $typeParams = "s";
        $results = $this->db->getData($sql, $parameters, $typeParams);
        return $results[0]['total_count'] ?? 0;
    }
    public function getCategoryById($category_id)
    {
        $sql = "SELECT * FROM categories WHERE category_id = ?";
        $parameters = [$category_id];
        $typeParams = "i";
        return $this->db->getData($sql, $parameters, $typeParams);
    }


}
