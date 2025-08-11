<?php
session_start();
if (!isset($_SESSION['username'])) {
    die("Unauthorized access");
}

$username = $_SESSION['username'];

$con = mysqli_connect("localhost", "root", "", "portfolio");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT certification, institution FROM certification WHERE username = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li><b>{$row['certification']}</b> from {$row['institution']} </li>";
    }
    echo "</ul>";
} else {
    echo "No qualifications found.";
}

$stmt->close();
$con->close();
?>