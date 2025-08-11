<?php
session_start();
if (!isset($_SESSION['username'])) {
    die("Unauthorized access");
}

$username = $_SESSION['username'];
$degree = $_POST['degree'];
$institution = $_POST['institution'];
$year_of_completion = $_POST['year_of_completion'];

$con = mysqli_connect("localhost", "root", "", "portfolio");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO education (username, degree, institution, year_of_completion) 
        VALUES (?, ?, ?, ?)";
$stmt = $con->prepare($sql);
$stmt->bind_param("sssi", $username, $degree, $institution, $year_of_completion);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$con->close();
?>
