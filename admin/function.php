<?php
    define('MY_PATH', $_SERVER['DOCUMENT_ROOT'] . '/store/img/');

    function getFileInfo($fileName, $directory = MY_PATH) 
    {
        // Kiểm tra nếu thư mục không tồn tại
        if (!is_dir($directory)) {
            return "Directory does not exist.";
        }
    
        // Đường dẫn đầy đủ của file
        $filePath = $directory . $fileName;
    
        // Kiểm tra nếu file tồn tại
        if (file_exists($filePath) && is_file($filePath)) {
            $fileSize = filesize($filePath); // Lấy kích thước file
            $fileType = mime_content_type($filePath); // Lấy loại file (MIME type)
            $lastModified = date("F d Y H:i:s", filemtime($filePath)); // Ngày giờ sửa đổi cuối cùng
    
            return [
                'name' => $fileName,
                'size' => $fileSize,
                'type' => $fileType,
                'path' => realpath($filePath),
                'last_modified' => $lastModified
            ];
        }
    
        return "File does not exist.";
    }
    function uploadImage($file, $targetDir = MY_PATH) {
        // Tạo thư mục nếu chưa tồn tại
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
    
        // Lấy thông tin file
        $fileName = basename($file['name']);
        $targetFilePath = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    
        // Kiểm tra định dạng file hợp lệ
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($fileType, $allowedTypes)) {
            return [
                'message' => "Only JPG, JPEG, PNG & GIF files are allowed.",
                'fileName' => null
            ];
        }
    
        // Thử upload file
        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            return [
                'message' => "File uploaded successfully: " . $fileName,
                'fileName' => $fileName
            ];
        } else {
            return [
                'message' => "Sorry, there was an error uploading your file.",
                'fileName' => null
            ];
        }
    }
?>