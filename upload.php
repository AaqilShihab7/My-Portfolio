<?php
session_start();
if (!isset($_SESSION['username'])) {
    die(json_encode(['status' => 'error', 'message' => 'Unauthorized access']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $con = mysqli_connect("localhost", "root", "", "portfolio");
    if (!$con) {
        die(json_encode(['status' => 'error', 'message' => 'Database connection failed']));
    }

    $username = $_SESSION['username'];
    $file = $_FILES['file'];

    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'video/mp4'];
        $fileType = mime_content_type($file['tmp_name']);
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $validExtensions = ['jpg', 'jpeg', 'png', 'mp4'];

        if (in_array($fileType, $allowedTypes) && in_array($extension, $validExtensions)) {
            // Define upload directory and unique file name
            $uploadDir = 'uploads/';
            $fileName = uniqid() . "_" . basename($file['name']);
            $uploadFilePath = $uploadDir . $fileName;

            // Ensure upload directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Move file to upload directory
            if (move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
                $type = (strpos($fileType, 'image') !== false) ? 'photo' : 'video';

                // Save file path to database
                $stmt = $con->prepare("INSERT INTO media (username, file_path, file_type) VALUES (?, ?, ?)");
                if ($stmt) {
                    $stmt->bind_param("sss", $username, $uploadFilePath, $type);
                    if ($stmt->execute()) {
                        echo json_encode(['status' => 'success', 'message' => 'File uploaded and saved successfully']);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Error saving file path in database']);
                    }
                    $stmt->close();
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Database query preparation failed']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to upload file']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Unsupported file type or invalid file extension']);
        }
    } else {
        $uploadErrors = [
            UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive specified in the HTML form',
            UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload',
        ];
        $errorMsg = $uploadErrors[$file['error']] ?? 'Unknown error during file upload';
        echo json_encode(['status' => 'error', 'message' => $errorMsg]);
    }

    mysqli_close($con);
}
?>
