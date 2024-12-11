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
    public function searchCategoryByName($category_name)
    {
        $sql = "SELECT * FROM categories WHERE name LIKE ?";
        $parameters = ["%$category_name%"];
        $typeParams = "s";
        return $this->db->getData($sql, $parameters, $typeParams);
    }
    public function getCategoryById($category_id)
    {
        $sql = "SELECT * FROM categories WHERE category_id = ?";
        $parameters = [$category_id];
        $typeParams = "i";
        return $this->db->getData($sql, $parameters, $typeParams);
    }


}
