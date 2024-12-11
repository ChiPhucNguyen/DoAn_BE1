<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/store/config/Database.php';
    class PaginationModel
    {
        private $db;
        public function __construct()
        {
            $this->db = new Database();
        }
            // paginate
            function get_paginate($url, $total, $limit, $page, $offset)
            {
                if ($total <= 0) {
                    return "";
                }
            
                $totalPage = ceil($total / $limit);
                if ($totalPage <= 1) {
                    return "";
                }
            
                $from = $page - $offset;
                $to = $page + $offset;
            
                if ($from <= 0) {
                    $from = 1;
                    $to = $offset * 2;
                }
            
                if ($to > $totalPage) {
                    $to = $totalPage;
                }
            
                $links = '';
                $parsedUrl = parse_url($url); // Phân tích URL gốc
                $baseUrl = $parsedUrl['path']; // Lấy đường dẫn cơ bản (bỏ tham số)
                parse_str($parsedUrl['query'] ?? '', $queryParams); // Lấy các tham số hiện có, nếu có
            
                for ($i = $from; $i <= $to; $i++) {
                    $queryParams['page'] = $i; // Cập nhật hoặc thêm tham số `page`
                    $active = $i == $page ? "active" : "";
                    $fullUrl = $baseUrl . '?' . http_build_query($queryParams); // Xây dựng URL đầy đủ
                    $links .= "<a class='btn btn-primary mx-1 {$active}' href='{$fullUrl}'>$i</a>";
                }
            
                return $links;
        }
            
        function print_paginate($url, $total, $limit, $page, $offset)
        {
            echo "<div class='btn'>";
            echo $this->get_paginate($url, $total, $limit, $page, $offset);
            echo "</div>";
        }

    }
?>