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
            if($total <= 0)
            {
                return "";
            }
            $totalPage = ceil($total/$limit);
            if($totalPage <= 1)
            {
                return "";
            }
            $from = $page - $offset;
            $to = $page + $offset;
            if($from <= 0) 
            {
                $from = 1;
                $to = $offset * 2;
            }
            if($to > $totalPage) $to = $totalPage;
            $links = '';
            for($i = $from; $i <= $to; $i++)
            {
                $active = $i == $page ? "active" : "";
                $links = $links. "<a class='{$active}' href='{$url}&page=$i'>$i</a>";
            }
            return $links;
        }
        function print_paginate($url, $total, $limit, $page, $offset)
        {
            echo "<div class='product__pagination'>";
            echo $this->get_paginate($url, $total, $limit, $page, $offset);
            echo "</div>";
        }

    }
?>