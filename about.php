<?php
session_start(); // Resume the session

if (!isset($_SESSION['username'])) {
    // Redirect to login page if username is not set
    header("Location: login.php");
    exit();
}

$username = htmlspecialchars($_SESSION['username']);
$about_me = "";

// Database connection
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "portfolio";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission to update the "About Me" details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $about_me = $conn->real_escape_string($_POST['about_me']);

    // Check if "About Me" entry exists for this user
    $check_sql = "SELECT * FROM about WHERE username = '{$_SESSION['username']}'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        // Update existing entry
        $update_sql = "UPDATE about SET details = '$about_me' WHERE username = '{$_SESSION['username']}'";
        $conn->query($update_sql);
    } else {
        // Insert new entry
        $insert_sql = "INSERT INTO about (username, details) VALUES ('{$_SESSION['username']}', '$about_me')";
        $conn->query($insert_sql);
    }

  echo '<script>alert("Details have been successfully saved!");</script>';
}

// Fetch existing "About Me" details
$fetch_sql = "SELECT details FROM about WHERE username = '{$_SESSION['username']}'";
$result = $conn->query($fetch_sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $about_me = htmlspecialchars($row['details']);
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit About Me</title>
    <link rel="stylesheet" href="s3.css">
    <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
       <div class="icon">
        <a href="home.php"><i class="bi bi-box-arrow-in-left"></i></a> 
    </div>
    <div class="container">
        <h1>Edit About Me</h1>
        <form method="POST" action="about.php">
            <textarea name="about_me" rows="10" cols="50" placeholder="Write about yourself..."><?php echo $about_me; ?></textarea>
            <button type="submit" class="save-button">Save</button>
        </form>
    </div>
</body>
</html>
