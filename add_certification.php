<?php
session_start();
if (!isset($_SESSION['username'])) {
    die("Unauthorized access");
}

$username = $_SESSION['username'];
$certification = $_POST['certification'];
$institution = $_POST['institution'];


$con = mysqli_connect("localhost", "root", "", "portfolio");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO certification (username, certification, institution) 
        VALUES (?, ?, ?, ?)";
$stmt = $con->prepare($sql);
$stmt->bind_param("sssi", $username, $certification, $institution);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$con->close();
?>
