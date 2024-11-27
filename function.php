<?php
    require_once "Database.php";
    $db = new Database();

    // Category
    function getAllCategories()
    {
        global $db;
        $sql = "SELECT * FROM categories";
        return $db->getData($sql);
    }
    function getCategories($start, $limit)
    {
        global $db;
        $sql = "SELECT * FROM categories LIMIT ?, ?";
        $parameters = [$start, $limit];
        $typeParams = "ii";
        return $db->getData($sql, $parameters, $typeParams);
    }
    function getAllProducts()
    {
        global $db;
        $sql = "SELECT * FROM products";
        return $db->getData($sql);
    }
    // Product
    function getProducts($start, $limit)
    {
        global $db;
        $sql = "SELECT * FROM products LIMIT ?, ?";
        $parameters = [$start, $limit];
        $typeParams = "ii";
        return $db->getData($sql, $parameters, $typeParams);
    }
    function getProductsByCategory($categoryId, $page, $limit)
    {
        global $db;
        $page = (int)$page > 0 ? (int)$page : 1;
        $offset = ($page - 1) * $limit;
        $sql = "SELECT products.* FROM products
        INNER JOIN categories ON categories.category_id = products.category_id
        WHERE products.category_id = ? LIMIT ?, ?";
        $params = [$categoryId, $offset, $limit];
        $typeParams = "iii";
        $results = $db->getData($sql, $params, $typeParams);
        $countSql = "SELECT COUNT(*) AS total_count FROM products WHERE category_id = ?";
        $countResults = $db->getData($countSql, [$categoryId], "i");
        $total =   $total = $countResults[0]['total_count'] ?? 0;
        return [
            'total' => (int)$total,
            'items' => $results
        ];
    }
    function getProductsByKeyword($keyword, $page, $limit)
    {
        global $db;
        $page = (int)$page > 0 ? (int)$page : 1;
        $offset = ($page - 1) * $limit;
        $keyword = "%".$keyword."%";
        $sql = "SELECT * FROM products WHERE products.name LIKE ? LIMIT ?,?";
        $params = [$keyword, $offset, $limit];
        $typeParams = "sii";
        $results = $db->getData($sql, $params, $typeParams);
        $countSql = "SELECT COUNT(*) AS total_count FROM products WHERE products.name LIKE ?";
        $countResults = $db->getData($countSql, [$keyword], "s");
        $total =  $total = $countResults[0]['total_count'] ?? 0;
        return [
            'total' => (int)$total,
            'items' => $results
        ];
    }
    function getProductsById($productId)
    {
        global $db;
        $productId = (int)$productId;
        $sql = "SELECT * FROM products 
        WHERE products.product_id = ? LIMIT 0,1";
        $params = [$productId];
        $typeParams = "i";
        $results = $db->getData($sql, $params, $typeParams);
        return $results;
    }
    function getLastestProducts($start, $limit)
    {
        global $db;
        $sql = "SELECT * FROM products ORDER BY created_at DESC LIMIT ?, ?";
        $parameters = [$start, $limit];
        $typeParams = "ii";
        $products = $db->getData($sql, $parameters, $typeParams);
        return $products;
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
        echo get_paginate($url, $total, $limit, $page, $offset);
        echo "</div>";
    }
    // Cart Function
    function getTotalUserOrders($userid)
    {
        global $db;
        $sql = "SELECT COUNT(*) AS total FROM orders WHERE user_id = ?";
        $parameters = [$userid];
        $typeParams = "i";
        $results = $db->getData($sql, $parameters, $typeParams);
        return $results[0]['total'];
    }
    function getOrderDetails($orderId)
    {
        global $db;
        $sql = "SELECT * FROM order_details WHERE order_id = ?";
        $parameters = [$orderId];
        $typeParams = "i";
        return $db->getData($sql, $parameters, $typeParams);
    }
    function getOrderId($userid)
    {
        global $db;
        $sql = "SELECT order_id FROM orders WHERE user_id = ? ORDER BY order_id DESC LIMIT 0,1";
        $parameters = [$userid];
        $typeParams = "i";
        $results = $db->getData($sql, $parameters, $typeParams);
        return $results[0]['order_id'];
    }
    function getOrderDetailsByUserId($userid)
    {
        global $db;
        $sql = "SELECT order_details.*, products.* FROM orders
        INNER JOIN order_details ON orders.order_id = order_details.order_id
        INNER JOIN products ON order_details.product_id = products.product_id
        WHERE orders.user_id = ?";

        $parameters = [$userid];
        $typeParams = "i";
        return $db->getData($sql, $parameters, $typeParams);
    }
    function checkUserCart($userid)
    {
        global $db;
        $sql = "SELECT * FROM carts WHERE user_id = ?";
        $parameters = [$userid];
        $typeParams = "i";
        $results = $db->getData($sql, $parameters, $typeParams);
        return count($results) > 0;
    }
    function createUserCart($userid)
    {
        global $db;
        $sql = "INSERT INTO carts(user_id) VALUES(?)";
        $parameters = [$userid];
        $typeParams = "i";
        return $db->executeData($sql, $parameters, $typeParams);
    }
    function getCartItemByUserId($userid)
    {
        global $db;
        $sql = "SELECT cart_items.*, products.* FROM cart_items
        INNER JOIN products ON cart_items.product_id = products.product_id
        INNER JOIN carts ON cart_items.cart_id = carts.cart_id
        WHERE carts.user_id = ?";

        $parameters = [$userid];
        $typeParams = "i";
        return $db->getData($sql, $parameters, $typeParams);
    }
    function getTotalUserCartItems($userid)
    {
        global $db;
        $sql = "SELECT COUNT(*) AS total FROM cart_items
        INNER JOIN carts ON cart_items.cart_id = carts.cart_id
        WHERE carts.user_id = ?";
        $parameters = [$userid];
        $typeParams = "i";
        $results = $db->getData($sql, $parameters, $typeParams);
        return $results[0]['total'];
    }
    function addItemToCart($userId, $productId, $quantity)
    {
        echo "test";
        global $db;
        $sql = "SELECT * FROM carts WHERE user_id = ?";
        $parameters = [$userId];
        $typeParams = "i";
        $results = $db->getData($sql, $parameters, $typeParams);
        $cartId = $results[0]['cart_id'];
        echo $cartId;
        $sql = "SELECT * FROM cart_items WHERE cart_id = ? AND product_id = ?";
        $parameters = [$cartId, $productId];
        $typeParams = "ii";
        $results = $db->getData($sql, $parameters, $typeParams);
        if(count($results) > 0)
        {
            echo $cartId;
            echo $quantity;
            echo $productId;
            $sql = "UPDATE cart_items SET quantity = quantity + ? WHERE cart_id = ? AND product_id = ?";
            $parameters = [$quantity, $cartId, $productId];
            $typeParams = "iii";
            return $db->executeData($sql, $parameters, $typeParams);
        }
        echo "test2";
        $sql = "INSERT INTO cart_items(cart_id, product_id, quantity) VALUES(?, ?, ?)";
        $parameters = [$cartId, $productId, $quantity];
        $typeParams = "iii";
        echo "test";
        return $db->executeData($sql, $parameters, $typeParams);
    }
    function removeItemFromCart($userId, $productId)
    {
        global $db;
        $sql = "SELECT * FROM carts WHERE user_id = ?";
        $parameters = [$userId];
        $typeParams = "i";
        $results = $db->getData($sql, $parameters, $typeParams);
        $cartId = $results[0]['cart_id'];
        $sql = "DELETE FROM cart_items WHERE cart_id = ? AND product_id = ?";
        $parameters = [$cartId, $productId];
        $typeParams = "ii";
        return $db->executeData($sql, $parameters, $typeParams);
    }
    // Register Function
    function checkUsernameAvailability($username)
    {
        global $db;
        $sql = "SELECT * FROM users WHERE username = ?";
        $parameters = [$username];
        $typeParams = "s";
        $results = $db->getData($sql, $parameters, $typeParams);
        return count($results) > 0;
    }
    function registerUsers($username, $password)
    {
        global $db;
        $sql = "INSERT INTO users(username, password) VALUES(?, ?)";
        $parameters = [$username, $password];
        $typeParams = "ss";
        return $db->executeData($sql, $parameters, $typeParams);
    }
    function loginUsers($username, $password)
    {
        global $db;
        echo $username;
        echo $password;
        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $parameters = [$username, $password];
        $typeParams = "ss";
        return $db->getData($sql, $parameters, $typeParams);
    }
    function redirectWithMessage($url, $type, $message) {
        $url = $url ?? 'index.php';
        $_SESSION[$type] = $message;
        header("Location: $url");
        exit;
      }
?>