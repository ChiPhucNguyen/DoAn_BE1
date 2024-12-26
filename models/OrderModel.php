<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/store/config/Database.php';
    class OrderModel
    {
        private $db;
        public function __construct()
        {
            $this->db = new Database();
        }
        function getOrderDetailByOrderId($orderId , $userId)
        {
            $sql = "SELECT order_details.*, products.* FROM order_details
            INNER JOIN products ON order_details.product_id = products.product_id
            INNER JOIN orders ON order_details.order_id = orders.order_id
            WHERE orders.order_id = ? AND orders.user_id = ?";
            $parameters = [$orderId, $userId];
            $typeParams = "ii";
            return $this->db->getData($sql, $parameters, $typeParams);
        }
        function getOrderByUserId($userid)
        {
            $sql = "SELECT * FROM orders WHERE user_id = ?";
            $parameters = [$userid];
            $typeParams = "i";
            $results = $this->db->getData($sql, $parameters, $typeParams);
            return $results;
        }
        public function checkout($userId, $cartId)
        {
            // 1. Lấy thông tin sản phẩm từ giỏ hàng
            $sqlCartItems = "SELECT ci.product_id, ci.quantity, p.price 
                            FROM cart_items ci 
                            INNER JOIN products p ON ci.product_id = p.product_id 
                            INNER JOIN carts c ON ci.cart_id = c.cart_id
                            WHERE ci.cart_id = ? AND c.user_id = ?";
            $cartItems = $this->db->getData($sqlCartItems, [$cartId, $userId], "ii");

            if (empty($cartItems)) {
                return [
                    "success" => false,
                    "message" => "Giỏ hàng rỗng, không thể thanh toán."
                ];
            }

            // 2. Tính tổng tiền đơn hàng
            $totalPrice = array_reduce($cartItems, function ($sum, $item) {
                return $sum + $item['quantity'] * $item['price'];
            }, 0);

            // 3. Tạo đơn hàng
            $sqlInsertOrder = "INSERT INTO orders (user_id, total_price) VALUES (?, ?)";
            $this->db->executeData($sqlInsertOrder, [$userId, $totalPrice], "id");

            // 4. Lấy order_id sau khi tạo đơn hàng bằng cách truy vấn theo user_id và total_price
            $sqlGetOrderId = "SELECT order_id FROM orders WHERE user_id = ? AND total_price = ? ORDER BY created_at DESC LIMIT 1";
            $orderIdResult = $this->db->getData($sqlGetOrderId, [$userId, $totalPrice], "id");

            if (empty($orderIdResult)) {
                return [
                    "success" => false,
                    "message" => "Không thể lấy thông tin đơn hàng."
                ];
            }

            $orderId = $orderIdResult[0]['order_id'];

            // 5. Tạo chi tiết đơn hàng
            foreach ($cartItems as $item) {
                $sqlInsertDetail = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                                    VALUES (?, ?, ?, ?)";
                $this->db->executeData($sqlInsertDetail, [$orderId, $item['product_id'], $item['quantity'], $item['price']], "iiid");
            }

            // 6. Xóa sản phẩm khỏi giỏ hàng
            $sqlDeleteCartItems = "DELETE FROM cart_items WHERE cart_id = ?";
            $this->db->executeData($sqlDeleteCartItems, [$cartId], "i");

            return [
                "success" => true,
                "message" => "Thanh toán thành công.",
                "order_id" => $orderId,
            ];
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