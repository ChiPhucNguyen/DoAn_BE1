<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/store/config/Database.php';

class ConfigModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Hàm cập nhật cấu hình
    public function updateConfig($key, $value)
    {
        $sql = "INSERT INTO config (config_key, config_value) VALUES (?, ?)
                ON DUPLICATE KEY UPDATE config_value = VALUES(config_value)";
        return $this->db->executeData($sql, [$key, $value], "ss");
    }

    // Hàm lấy toàn bộ cấu hình
    public function getAllConfig()
    {
        $sql = "SELECT * FROM config";
        $result = $this->db->getData($sql);
        $config = [];
        foreach ($result as $row) {
            $config[$row['config_key']] = $row['config_value'];
        }
        return $config;
    }
}
?>
