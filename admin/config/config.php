<?php
    define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/store/admin/views/');
    require_once $_SERVER['DOCUMENT_ROOT'] . '/store/admin/models/ConfigModel.php';
    $configModel = new ConfigModel();
    $currentConfig = $configModel->getAllConfig();
    ini_set('upload_max_filesize', $currentConfig['upload_limit'] . 'M'); 
?>