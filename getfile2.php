<?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "portfolio");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch uploaded files
$sql = "SELECT id, heading, file_path, file_type FROM certificate_uploads ORDER BY uploaded_at DESC";
$result = mysqli_query($con, $sql);

// Display files
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<h3>" . htmlspecialchars($row['heading']) . "</h3>";
        
        // If the file is an image
        if ($row['file_type'] == 'image') {
            echo "<img src='" . htmlspecialchars($row['file_path']) . "' alt='Image' style='width:200px;'><br>";
        }
        // If the file is a PDF
        else if ($row['file_type'] == 'pdf') {
            echo "<h4>PDF View:</h4>";
            // Use an iframe to display the PDF inline
            echo "<iframe src='" . htmlspecialchars($row['file_path']) . "' width='600' height='400'></iframe><br>";
        }
    }
} else {
    echo "No files found.";
}

mysqli_close($con);
?>
