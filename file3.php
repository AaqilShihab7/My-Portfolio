<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Files</title>
    <link rel="stylesheet" href="s7.css">
</head>
<body>
    <header>
        <h1>My Experience</h1>
    </header>
    <main>
        <section class="uploaded-files">
           <?php
            // Database connection
            $con = mysqli_connect("localhost", "root", "", "portfolio");
            if (!$con) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Fetch experiences
            $sql = "SELECT * FROM experiences ORDER BY employment_date DESC";
            $result = mysqli_query($con, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='experience-card'>";
                    echo "<h2>" . htmlspecialchars($row['position_title']) . "</h2>";
                    echo "<p><strong>Company:</strong> " . htmlspecialchars($row['company_name']) . "</p>";
                    echo "<p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>";
                    echo "<p><strong>Employment Date:</strong> " . htmlspecialchars($row['employment_date']) . "</p>";
                    echo "<p><strong>Description:</strong> " . htmlspecialchars($row['job_description']) . "</p>";

                    // Display report
                    if (!empty($row['report_path'])) {
                        $report_ext = pathinfo($row['report_path'], PATHINFO_EXTENSION);
                        echo "<h3>Report:</h3>";
                        if ($report_ext === "pdf") {
                            echo "<iframe src='" . htmlspecialchars($row['report_path']) . "' style='width:100%; height:300px; border:1px solid #ccc;'></iframe>";
                        } else {
                            echo "<img src='" . htmlspecialchars($row['report_path']) . "' alt='Report Image' style='max-width:100%;'>";
                        }
                    }

                    // Display service letter
                    if (!empty($row['service_letter_path'])) {
                        echo "<h3>Service Letter:</h3>";
                        echo "<a href='" . htmlspecialchars($row['service_letter_path']) . "' target='_blank' class='download-link'>Download Service Letter</a>";
                    }

                    echo "</div>";
                }
            } else {
                echo "<p>No experiences found.</p>";
            }

            mysqli_close($con);
            ?>
        </section>
    </main>
</body>
</html>
