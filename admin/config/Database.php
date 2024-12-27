<?php
    class Database
    {
        private $host = "localhost";
        private $username = "u552874732_ltphuoc";
        private $password = "G*9b^9>Mr";
        private $dbName = "u552874732_ltphuoc";
        private $conn;
        public function __construct()
        {
            $this->connect();
        }
        private function connect()
        {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbName);
            if($this->conn->connect_error)
            {
                die("Connection failed");
            }
        }
        public function getData($sql, $parameters = [], $typeParams = "")
        {
            try
            {
                // Chuẩn bị câu truy vấn
                $stmt = $this->conn->prepare($sql);
                if ($stmt === false) {
                    throw new Exception("Lỗi chuẩn bị truy vấn: " . $this->conn->error);
                }

                // Gắn tham số nếu có
                if (!empty($parameters)) {
                    $stmt->bind_param($typeParams, ...$parameters);
                }

                // Thực thi câu truy vấn
                $stmt->execute();
                if ($stmt === false) {
                    throw new Exception("Lỗi thực thi truy vấn: " . $this->conn->error);
                }

                // Lấy kết quả và kiểm tra
                $result = $stmt->get_result();
                if ($result === false) {
                    throw new Exception("Lỗi lấy kết quả truy vấn: " . $this->conn->error);
                }

                // Trả về dữ liệu dưới dạng mảng kết hợp
                return $result->fetch_all(MYSQLI_ASSOC);
            }
            catch (Exception $ex)
            {
                // In thông báo lỗi chi tiết để dễ dàng xử lý trong quá trình debug
                die("Lỗi truy vấn getData: " . $ex->getMessage());
            }
        }
        public function executeData($sql, $parameters = [], $typeParams="")
        {
            try
            {
                $stmt = $this->conn->prepare($sql);
                if ($stmt === false) {
                    throw new Exception("Lỗi chuẩn bị truy vấn: " . $this->conn->error);
                }
                if(!empty($parameters))
                {
                    $stmt->bind_param($typeParams, ...$parameters);
                }
                $results = $stmt->execute();
                $stmt->close();
                return $results;
            }
            catch(Exception $ex)
            {
                die("Lỗi truy vấn executeData : ". $ex->getMessage());
            }
        }
    }
?>