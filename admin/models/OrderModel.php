<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/store/config/Database.php';

class OrderModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Lấy tất cả các đơn hàng
    public function getAllOrders($page, $limit)
    {
        $page = (int)$page > 0 ? (int)$page : 1;
        $offset = ($page - 1) * $limit;
        $total = $this->getTotalOrders();
        $sql = "SELECT orders.order_id AS order_id, 
                       orders.user_id AS user_id,
                       orders.total_price AS total_price,
                       orders.status AS status,
                       users.username AS username
                FROM orders
                JOIN users 
                    ON orders.user_id = users.user_id
                LIMIT ?, ?";
        $parameters = [$offset, $limit];
        $typeParams = "ii";
        $results = $this->db->getData($sql, $parameters, $typeParams);
        return [
            'total' => (int)$total,
            'orders' => $results
        ];
    }

    // Lấy tổng số đơn hàng
    public function getTotalOrders()
    {
        $sql = "SELECT COUNT(*) AS total FROM orders";
        $results = $this->db->getData($sql);
        return $results[0]['total'];
    }

    // Lấy chi tiết đơn hàng
    public function getOrderDetails($orderId)
    {
        $sql = "SELECT order_details.order_detail_id AS order_detail_id, 
                       order_details.order_id AS order_id, 
                       order_details.product_id AS product_id,
                       order_details.quantity AS quantity,
                       order_details.price AS price,
                       products.name AS product_name
                FROM order_details
                JOIN products 
                    ON order_details.product_id = products.product_id
                WHERE order_details.order_id = ?";
        $parameters = [$orderId];
        $typeParams = "i";
        return $this->db->getData($sql, $parameters, $typeParams);
    }

    // Tạo đơn hàng mới
    public function createOrder($userId, $totalPrice, $status = 'chờ xử lý')
    {
        $sql = "INSERT INTO `orders` (`order_id`, `user_id`, `total_price`, `status`, `created_at`)
                VALUES (NULL,?, ?, ?, NOW())";
        $parameters = [$userId, $totalPrice, $status];
        $typeParams = "iss";
        return $this->db->executeData($sql, $parameters, $typeParams);
    }

    // Tạo chi tiết đơn hàng
    public function createOrderDetail($orderId, $productId, $quantity, $price)
    {
        $sql = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                VALUES (?, ?, ?, ?)";
        $parameters = [$orderId, $productId, $quantity, $price];
        $typeParams = "iiii";
        return $this->db->executeData($sql, $parameters, $typeParams);
    }

    // Cập nhật trạng thái đơn hàng
    public function updateOrderStatus($orderId, $status)
    {
        $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
        $parameters = [$status, $orderId];
        $typeParams = "si";
        return $this->db->executeData($sql, $parameters, $typeParams);
    }

    // Xóa đơn hàng
    public function deleteOrder($orderId)
    {
        $sql = "DELETE FROM orders WHERE order_id = ?";
        $parameters = [$orderId];
        $typeParams = "i";
        return $this->db->executeData($sql, $parameters, $typeParams);
    }
    public function searchOrder($search, $page, $limit = 1)
    {
        $page = (int)$page > 0 ? (int)$page : 1;
        $offset = ($page - 1) * $limit;
        $total = $this->getTotalSearchOrder($search);
        
        $sql = "SELECT orders.order_id AS order_id, 
                        orders.user_id AS user_id, 
                        orders.total_price AS total_price, 
                        orders.status AS status, 
                        users.username AS username
                FROM orders
                JOIN users 
                    ON orders.user_id = users.user_id
                WHERE users.username LIKE ? 
                LIMIT ?, ?";
        $parameters = ["%$search%", $offset, $limit];
        $typeParams = "sii";
        $results = $this->db->getData($sql, $parameters, $typeParams);
        
        return [
            'total' => (int)$total,
            'orders' => $results
        ];
    }

    public function getTotalSearchOrder($search)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM orders
                JOIN users 
                    ON orders.user_id = users.user_id
                WHERE users.username LIKE ?";
        $parameters = ["%$search%"];
        $typeParams = "s";
        $results = $this->db->getData($sql, $parameters, $typeParams);
        
        return $results[0]['total'];
    }
    public function getOrderById($orderId) {
        $sql = "SELECT * FROM orders WHERE order_id = ?";
        return $this->db->getData($sql, [$orderId], 'i');
    }
    public function updateOrder($orderId, $userId, $totalPrice, $status = "chờ xử lý") {
        $userId = (int)$userId;
        $totalPrice = (float)$totalPrice;
        $orderId = (int)$orderId;
        $sql = "UPDATE `orders` SET `user_id` = ?, `total_price` = ?, `status` = ? WHERE `order_id` = ?";
        return $this->db->executeData($sql, [$userId, $totalPrice, $status, $orderId], 'iisi');
    }
}
?>