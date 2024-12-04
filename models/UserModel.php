<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/store/config/Database.php';
    class UserModel
    {
        private $db;
        public function __construct()
        {
            $this->db = new Database();
        }
        function checkUsernameAvailability($username)
        {
            $sql = "SELECT * FROM users WHERE username = ?";
            $parameters = [$username];
            $typeParams = "s";
            $results = $this->db->getData($sql, $parameters, $typeParams);
            return count($results) > 0;
        }
        function registerUsers($username, $password)
        {
            $sql = "INSERT INTO users(username, password) VALUES(?, ?)";
            $parameters = [$username, $password];
            $typeParams = "ss";
            return $this->db->executeData($sql, $parameters, $typeParams);
        }
        function loginUsers($username, $password)
        {
            $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
            $parameters = [$username, $password];
            $typeParams = "ss";
            return $this->db->getData($sql, $parameters, $typeParams);
        }
        function redirectWithMessage($url, $type, $message) {
            $url = $url ?? 'index.php';
            $_SESSION[$type] = $message;
            header("Location: $url");
            exit;
        }

        function isUserLoggedIn() {
            return isset($_SESSION['user_id']);
        }
        function getUsername() {
            return isset($_SESSION['username']) ? $_SESSION['username'] : '';
        }
        function getTotalUserCartItems($userId)
        {
            $sql = "SELECT COUNT(*) AS total FROM cart_items
                    INNER JOIN carts ON cart_items.cart_id = carts.cart_id
                    WHERE carts.user_id = ?";
            $parameters = [$userId];
            $typeParams = "i";
            $results = $this->db->getData($sql, $parameters, $typeParams);
            return $results[0]['total'];
        }
        
    }
?>