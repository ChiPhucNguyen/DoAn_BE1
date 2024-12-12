<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/store/config/Database.php';

    class CartModel
    {
        private $db;

        public function __construct()
        {
        $this->db = new Database();
        }

        public function getItemInCart($page, $limit)
        {
            $page = (int)$page > 0 ? (int)$page : 1;
            $offset = ($page - 1) * $limit;
            $total = $this->getTotalItemInCart();
            $sql = "SELECT cart_items.cart_item_id AS cart_item_id, 
                                cart_items.cart_id AS cart_id,
                                cart_items.quantity AS quantity,
                                products.name AS product_name,
                                products.price AS product_price,
                                users.username AS username
                    FROM cart_items
                    JOIN products 
                        ON cart_items.product_id = products.product_id
                    JOIN carts 
                        ON cart_items.cart_id = carts.cart_id
                    JOIN users 
                        ON carts.user_id = users.user_id
                    LIMIT ?, ?";
            $parameters = [$offset, $limit];
            $typeParams = "ii";
            $results = $this->db->getData($sql, $parameters, $typeParams);
            return [
                'total' => (int)$total,
                'items' => $results
            ];
        }
        function getTotalItemInCart()
        {
            $sql = "SELECT COUNT(*) AS total FROM cart_items";
            $results = $this->db->getData($sql);
            return $results[0]['total'];
        }
        public function getItemInCartById($cart_id)
        {
            $sql = "SELECT cart_items.cart_item_id AS cart_item_id, 
                                cart_items.cart_id AS cart_id,
                                cart_items.quantity AS quantity,
                                cart_items.product_id AS product_id,
                                products.name AS product_name,
                                products.price AS product_price,
                                users.username AS username
                    FROM cart_items
                    JOIN products 
                        ON cart_items.product_id = products.product_id
                    JOIN carts 
                        ON cart_items.cart_id = carts.cart_id
                    JOIN users 
                        ON carts.user_id = users.user_id
                    WHERE cart_items.cart_item_id = ?";
            $parameters = [$cart_id];
            $typeParams = "i";
            return $this->db->getData($sql, $parameters, $typeParams);
        }
        public function updateItemInCart($card_item_id ,$cart_id, $product_id, $quantity)
        {
            $sql = "UPDATE cart_items SET quantity = ?, cart_id = ?, product_id = ? WHERE cart_item_id = ?";
            $parameters = [$quantity, $cart_id, $product_id, $card_item_id];
            $typeParams = "iiii";
            return $this->db->executeData($sql, $parameters, $typeParams);
        }
        public function insertItemToCart($cart_id, $product_id, $quantity)
        {
            $sql = "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)";
            $parameters = [$cart_id, $product_id, $quantity];
            $typeParams = "iii";
            return $this->db->executeData($sql, $parameters, $typeParams);
        }
        public function deleteItemInCart($item_id)
        {
            $sql = "DELETE FROM cart_items WHERE cart_item_id = ?";
            $parameters = [$item_id];
            $typeParams = "i";
            return $this->db->executeData($sql, $parameters, $typeParams);
        }
        public function searchItemInCart($product_name, $page, $limit = 1)
        {
            $page = (int)$page > 0 ? (int)$page : 1;
            $offset = ($page - 1) * $limit;
            $total = $this->getTotalSearchItemInCart($product_name);
            $sql = "SELECT cart_items.cart_item_id AS cart_item_id, 
                                cart_items.cart_id AS cart_id,
                                cart_items.quantity AS quantity,
                                cart_items.product_id AS product_id,
                                products.name AS product_name,
                                products.price AS product_price,
                                users.username AS username
                    FROM cart_items
                    JOIN products 
                        ON cart_items.product_id = products.product_id
                    JOIN carts 
                        ON cart_items.cart_id = carts.cart_id
                    JOIN users 
                        ON carts.user_id = users.user_id
                    WHERE products.name LIKE ? LIMIT ?, ?";
            $parameters = ["%$product_name%", $offset, $limit];
            $typeParams = "s";
            $results = $this->db->getData($sql, $parameters, $typeParams);
            return [
                'total' => (int)$total,
                'items' => $results
            ];
        }
        public function getTotalSearchItemInCart($product_name)
        {
            $sql = "SELECT COUNT(*) AS total
                    FROM cart_items
                    JOIN products 
                        ON cart_items.product_id = products.product_id
                    WHERE products.name LIKE ?";
            $parameters = ["%$product_name%"];
            $typeParams = "s";
            $results = $this->db->getData($sql, $parameters, $typeParams);
            return $results[0]['total'];
        }
        public function getAllUserCart()
        {
            $sql = "SELECT carts.cart_id, users.username FROM carts
                    JOIN users
                        ON carts.user_id = users.user_id";
            return $this->db->getData($sql);
        }
    }
?>
