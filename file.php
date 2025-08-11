<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Files</title>
    <link rel="stylesheet" href="s5.css">
</head>
<body>
    <header>
        <h1>My Certificates and Transcript</h1>
    </header>
    <main>
        <section class="uploaded-files">
            <?php
            // Database connection
            $con = mysqli_connect("localhost", "root", "", "portfolio");
            if (!$con) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Fetch uploaded files
            $sql = "SELECT id, heading, file_path, file_type FROM media_uploads ORDER BY uploaded_at DESC";
            $result = mysqli_query($con, $sql);

            // Display files
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='file-card'>";
                    echo "<h3>" . htmlspecialchars($row['heading']) . "</h3>";

                    // If the file is an image
                    if ($row['file_type'] == 'image') {
                        echo "<a href='" . htmlspecialchars($row['file_path']) . "' target='_blank'>";
                        echo "<img src='" . htmlspecialchars($row['file_path']) . "' alt='Image'>";
                        echo "</a>";
                    }
                    // If the file is a PDF
                    else if ($row['file_type'] == 'pdf') {
                        echo "<h4>PDF View:</h4>";
                        echo "<iframe src='" . htmlspecialchars($row['file_path']) . "'></iframe>";
                        echo "<a href='" . htmlspecialchars($row['file_path']) . "' target='_blank'>Open in New Tab</a>";
                    }
                    echo "</div>";
                }
            } else {
                echo "<p>No files found.</p>";
            }

            mysqli_close($con);
            ?>
        </section>
    </main>

</body>
</html>
