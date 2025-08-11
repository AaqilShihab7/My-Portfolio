<?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "portfolio");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $section = mysqli_real_escape_string($con, $_POST['section']);
    $heading = mysqli_real_escape_string($con, $_POST['heading']);
    $tools = mysqli_real_escape_string($con, $_POST['tools']);
    $features = mysqli_real_escape_string($con, $_POST['features']);

    $image_path = NULL;
    $report_path = NULL;

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_path = 'uploads/images/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    }

    // Handle report upload
    if (isset($_FILES['report']) && $_FILES['report']['error'] === UPLOAD_ERR_OK) {
        $report_path = 'uploads/reports/' . basename($_FILES['report']['name']);
        move_uploaded_file($_FILES['report']['tmp_name'], $report_path);
    }

    // Insert data into database
    $sql = "INSERT INTO projects (section, heading, tools, features, image_path, report_path) 
            VALUES ('$section', '$heading', '$tools', '$features', '$image_path', '$report_path')";
    if (mysqli_query($con, $sql)) {
        echo "Project added successfully!";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

mysqli_close($con);
?>
