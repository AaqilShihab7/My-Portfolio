<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Files</title>
    <link rel="stylesheet" href="s6.css">
</head>
<body>
    <header>
        <h1>My Projects</h1>
    </header>
    <main>
        <section class="uploaded-files">
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
                    echo "<div class='file-card'>";
                    echo "<h2>" . htmlspecialchars($row['heading']) . "</h2>";
                    echo "<p><strong>Section:</strong> " . htmlspecialchars($row['section']) . "</p>";
                    echo "<p><strong>Tools:</strong> " . htmlspecialchars($row['tools']) . "</p>";
                    echo "<p><strong>Features:</strong> " . htmlspecialchars($row['features']) . "</p>";

                    // Display project image
                    if (!empty($row['image_path'])) {
                        echo "<img src='" . htmlspecialchars($row['image_path']) . "' alt='Project Image'>";
                    }

                    // Display report in iframe
                    if (!empty($row['report_path'])) {
                        echo "<h3>Report:</h3>";
                        echo "<iframe src='" . htmlspecialchars($row['report_path']) . "'></iframe>";
                    }

                    echo "</div>";
                }
            } else {
                echo "<p>No projects found.</p>";
            }

            mysqli_close($con);
            ?>
        </section>
    </main>
</body>
</html>
