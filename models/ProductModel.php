<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/store/config/Database.php';
    class ProductModel
    {
        private $db;
        public function __construct()
        {
            $this->db = new Database();
        }
        
        function getAllProducts()
        {
            $sql = "SELECT * FROM products";
            return $this->db->getData($sql);
        }
        // Product
        function getProducts($start, $limit)
        {
            $sql = "SELECT * FROM products LIMIT ?, ?";
            $parameters = [$start, $limit];
            $typeParams = "ii";
            return $this->db->getData($sql, $parameters, $typeParams);
        }
        function getProductsByCategory($categoryId, $page, $limit)
        {
            $page = (int)$page > 0 ? (int)$page : 1;
            $offset = ($page - 1) * $limit;
            // lấy danh sách các sản phẩm
            $sql = "SELECT products.* FROM products
            INNER JOIN categories ON categories.category_id = products.category_id
            WHERE products.category_id = ? LIMIT ?, ?";
            $params = [$categoryId, $offset, $limit];
            $typeParams = "iii";
            $results = $this->db->getData($sql, $params, $typeParams);
            // Đếm số lượng sản phẩm
            $countSql = "SELECT COUNT(*) AS total_count FROM products WHERE category_id = ?";
            $countResults = $this->db->getData($countSql, [$categoryId], "i");
            $total = $countResults[0]['total_count'] ?? 0;
            return [
                'total' => (int)$total,
                'items' => $results
            ];
        }
        function getProductsByKeyword($keyword, $page, $limit)
        {
            $page = (int)$page > 0 ? (int)$page : 1;
            $offset = ($page - 1) * $limit;
            $keyword = "%".$keyword."%";
            $sql = "SELECT * FROM products WHERE products.name LIKE ? LIMIT ?,?";
            $params = [$keyword, $offset, $limit];
            $typeParams = "sii";
            $results = $this->db->getData($sql, $params, $typeParams);
            $countSql = "SELECT COUNT(*) AS total_count FROM products WHERE products.name LIKE ?";
            $countResults = $this->db->getData($countSql, [$keyword], "s");
            $total =  $total = $countResults[0]['total_count'] ?? 0;
            return [
                'total' => (int)$total,
                'items' => $results
            ];
        }
        function getProductsById($productId)
        {
            $productId = (int)$productId;
            $sql = "SELECT * FROM products 
            WHERE products.product_id = ? LIMIT 0,1";
            $params = [$productId];
            $typeParams = "i";
            $results = $this->db->getData($sql, $params, $typeParams);
            return $results;
        }
        function getLastestProducts($start, $limit)
        {
            global $db;
            $sql = "SELECT * FROM products ORDER BY created_at DESC LIMIT ?, ?";
            $parameters = [$start, $limit];
            $typeParams = "ii";
            $products = $this->db->getData($sql, $parameters, $typeParams);
            return $products;
        }
    }
?>