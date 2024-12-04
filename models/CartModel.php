<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/store/config/Database.php';

    class CartModel
    {
        private $db;

        public function __construct()
        {
            $this->db = new Database();
        }

        public function getUserCartId($userId)
        {
            $sql = "SELECT cart_id FROM carts WHERE user_id = ?";
            $parameters = [$userId];
            $typeParams = "i";
            $results = $this->db->getData($sql, $parameters, $typeParams);
            return $results ? $results[0]['cart_id'] : null;
        }

        public function checkUserCart($userId)
        {
            return $this->getUserCartId($userId) !== null;
        }

        public function createUserCart($userId)
        {
            $sql = "INSERT INTO carts(user_id) VALUES(?)";
            $parameters = [$userId];
            $typeParams = "i";
            return $this->db->executeData($sql, $parameters, $typeParams);
        }

        public function getCartItemByUserId($userId)
        {
            $sql = "SELECT cart_items.*, products.* FROM cart_items
                    INNER JOIN products ON cart_items.product_id = products.product_id
                    INNER JOIN carts ON cart_items.cart_id = carts.cart_id
                    WHERE carts.user_id = ?";
            $parameters = [$userId];
            $typeParams = "i";
            return $this->db->getData($sql, $parameters, $typeParams);
        }


        public function addItemToCart($userId, $productId, $quantity)
        {
            $cartId = $this->getUserCartId($userId) ?: $this->createUserCart($userId);
            
            if ($this->isProductInCart($cartId, $productId)) {
                return $this->updateProductQuantity($cartId, $productId, $quantity);
            }

            return $this->addProductToCart($cartId, $productId, $quantity);
        }

        public function isProductInCart($cartId, $productId)
        {
            $sql = "SELECT 1 FROM cart_items WHERE cart_id = ? AND product_id = ?";
            $parameters = [$cartId, $productId];
            $typeParams = "ii";
            $results = $this->db->getData($sql, $parameters, $typeParams);
            return count($results) > 0;
        }

        public function updateProductQuantity($cartId, $productId, $quantity)
        {
            $sql = "UPDATE cart_items SET quantity = quantity + ? WHERE cart_id = ? AND product_id = ?";
            $parameters = [$quantity, $cartId, $productId];
            $typeParams = "iii";
            return $this->db->executeData($sql, $parameters, $typeParams);
        }

        public function addProductToCart($cartId, $productId, $quantity)
        {
            $sql = "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)";
            $parameters = [$cartId, $productId, $quantity];
            $typeParams = "iii";
            return $this->db->executeData($sql, $parameters, $typeParams);
        }

        public function removeItemFromCart($userId, $productId)
        {
            $cartId = $this->getUserCartId($userId);
            if (!$cartId) return false; // Nếu không có giỏ hàng

            $sql = "DELETE FROM cart_items WHERE cart_id = ? AND product_id = ?";
            $parameters = [$cartId, $productId];
            $typeParams = "ii";
            return $this->db->executeData($sql, $parameters, $typeParams);
        }
    }
?>
