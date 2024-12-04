<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/store/config/Database.php';
    class CategoryModel
    {
        private $db;
        public function __construct()
        {
            $this->db = new Database();
        }
        function getAllCategories()
        {
            $sql = "SELECT * FROM categories";
            return $this->db->getData($sql);
        }
        function getCategories($start, $limit)
        {
            $sql = "SELECT * FROM categories LIMIT ?, ?";
            $parameters = [$start, $limit];
            $typeParams = "ii";
            return $this->db->getData($sql, $parameters, $typeParams);
        }
    }
?>