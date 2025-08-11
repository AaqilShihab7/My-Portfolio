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

$sql = "SELECT degree, institution, year_of_completion FROM education WHERE username = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li><b>{$row['degree']}</b> from {$row['institution']} ({$row['year_of_completion']})</li>";
    }
    echo "</ul>";
} else {
    echo "No qualifications found.";
}

$stmt->close();
$con->close();
?>
