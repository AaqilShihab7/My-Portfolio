<?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "portfolio");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch projects
$sql = "SELECT * FROM projects ORDER BY created_at DESC";
$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<h2>" . htmlspecialchars($row['heading']) . "</h2>";
        echo "<p><strong>Section:</strong> " . htmlspecialchars($row['section']) . "</p>";
        echo "<p><strong>Tools:</strong> " . htmlspecialchars($row['tools']) . "</p>";
        echo "<p><strong>Features:</strong> " . htmlspecialchars($row['features']) . "</p>";

        // Display project image
        if ($row['image_path']) {
            echo "<img src='" . htmlspecialchars($row['image_path']) . "' alt='Project Image' style='width:200px;'><br>";
        }

        // Display report in iframe
        if ($row['report_path']) {
            echo "<h3>Report:</h3>";
            echo "<iframe src='" . htmlspecialchars($row['report_path']) . "' style='width:100%; height:500px; border:1px solid #ccc;'></iframe><br>";
        }

        echo "<hr>";
    }
} else {
    echo "No projects found.";
}

mysqli_close($con);
?>
