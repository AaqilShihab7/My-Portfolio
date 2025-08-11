<?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "portfolio");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $heading = mysqli_real_escape_string($con, $_POST['heading']);
    $file = $_FILES['file'];

    // Validation
    if (empty($username) || empty($heading)) {
        die("Username and Heading are required.");
    }

    // File handling
    $targetDir = "uploads/";
    $fileName = basename($file["name"]);
    $uniqueFileName = uniqid() . "_" . $fileName;
    $targetFilePath = $targetDir . $uniqueFileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Allow only images and PDFs
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
    if (in_array($fileType, $allowedTypes)) {
        // Check and create the upload directory if not exists
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Move uploaded file
        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            $fileType = ($fileType == 'pdf') ? 'pdf' : 'image';

            // Insert into database
            $sql = "INSERT INTO media_uploads (username, heading, file_path, file_type) VALUES (?, ?, ?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssss", $username, $heading, $targetFilePath, $fileType);
            if ($stmt->execute()) {
                echo "File uploaded successfully!";
            } else {
                echo "Database error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error moving uploaded file. Check permissions on the 'uploads' folder.";
        }
    } else {
        echo "Invalid file type. Only JPG, PNG, GIF, and PDF files are allowed.";
    }
}

mysqli_close($con);
?>
