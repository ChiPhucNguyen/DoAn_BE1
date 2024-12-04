<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/store/config/Database.php';
    class OrderModel
    {
        private $db;
        public function __construct()
        {
            $this->db = new Database();
        }
        function getOrderDetails($orderId)
        {
            $sql = "SELECT * FROM order_details WHERE order_id = ?";
            $parameters = [$orderId];
            $typeParams = "i";
            return $this->db->getData($sql, $parameters, $typeParams);
        }
        function getOrderId($userid)
        {
            $sql = "SELECT order_id FROM orders WHERE user_id = ? ORDER BY order_id DESC LIMIT 0,1";
            $parameters = [$userid];
            $typeParams = "i";
            $results = $this->db->getData($sql, $parameters, $typeParams);
            return $results[0]['order_id'];
        }
        function getOrderDetailsByUserId($userid)
        {
            $sql = "SELECT order_details.*, products.* FROM orders
            INNER JOIN order_details ON orders.order_id = order_details.order_id
            INNER JOIN products ON order_details.product_id = products.product_id
            WHERE orders.user_id = ?";

            $parameters = [$userid];
            $typeParams = "i";
            return $this->db->getData($sql, $parameters, $typeParams);
        }
        function getTotalUserOrders($userid)
        {
            $sql = "SELECT COUNT(*) AS total FROM orders WHERE user_id = ?";
            $parameters = [$userid];
            $typeParams = "i";
            $results = $this->db->getData($sql, $parameters, $typeParams);
            return $results[0]['total'];
        }

    }
?>