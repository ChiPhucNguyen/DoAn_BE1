<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/store/config/Database.php';

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function loginUsers($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $parameters = [$username, $password];
        $typeParams = "ss";
        return $this->db->getData($sql, $parameters, $typeParams);
    }

    public function redirectWithMessage($url, $type, $message)
    {
        $url = $url ?? 'index.php';
        $_SESSION[$type] = $message;
        header("Location: $url");
        exit;
    }

    public function isUserLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public function getUsername()
    {
        return $_SESSION['username'] ?? '';
    }

    public function isAdmin($userid)
    {
        $sql = "SELECT * FROM users WHERE user_id = ? AND role = ?";
        $parameters = [$userid, 'admin'];
        $typeParams = "is";
        $results = $this->db->getData($sql, $parameters, $typeParams);
        return count($results) > 0;
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM users";
        return $this->db->getData($sql);
    }

    public function addUser($username, $password, $email, $phone, $address, $role)
    {
        //$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, email, phone, address, role) VALUES (?, ?, ?, ?, ?, ?)";
        $parameters = [$username, $password, $email, $phone, htmlspecialchars($address, ENT_QUOTES, 'UTF-8'), $role];
        $typeParams = "ssssss";
        return $this->db->executeData($sql, $parameters, $typeParams);
    }
    public function deleteUser($user_id)
    {
        $sql = "DELETE FROM users WHERE user_id = ?";
        $parameters = [$user_id];
        $typeParams = "i";
        return $this->db->executeData($sql, $parameters, $typeParams);
    }
    public function isUsernameTaken($username)
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        $parameters = [$username];
        $typeParams = "s";
        $results = $this->db->getData($sql, $parameters, $typeParams);
        return count($results) > 0;
    }
    public function isEmailTaken($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $parameters = [$email];
        $typeParams = "s";
        $results = $this->db->getData($sql, $parameters, $typeParams);
        return count($results) > 0;
    }
    public function getUserById($user_id)
    {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $parameters = [$user_id];
        $typeParams = "i";
        $results = $this->db->getData($sql, $parameters, $typeParams);
        return $results;
    }
    public function searchUserByName($username)
    {
        $sql = "SELECT * FROM users WHERE username LIKE ?";
        $parameters = ["%$username%"];
        $typeParams = "s";
        return $this->db->getData($sql, $parameters, $typeParams);
    }
    public function editUser($user_id, $username, $password, $email, $phone, $address, $role)
    {
        $sql = "UPDATE users SET username = ?, password = ?, email = ?, phone = ?, address = ?, role = ? WHERE user_id = ?";
        $parameters = [$username, $password, $email, $phone, $address, $role, $user_id];
        $typeParams = "ssssssi";
        return $this->db->executeData($sql, $parameters, $typeParams);
    }

}
