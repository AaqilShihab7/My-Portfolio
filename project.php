<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project</title>
    <link rel="stylesheet" href="project.css">
</head>
<body>
    <header>
        <h1>Add New Project</h1>
    </header>
    <main>
        <form action="add_project.php" method="POST" enctype="multipart/form-data">
            <label for="section">Project Section:</label>
            <select id="section" name="section" required>
                <option value="Network">Network</option>
                <option value="Software">Software</option>
            </select>

            <label for="heading">Project Heading:</label>
            <input type="text" id="heading" name="heading" placeholder="e.g., SLTB Seat Reservation" required>

            <label for="tools">Tools and Technologies Used:</label>
            <input type="text" id="tools" name="tools" placeholder="e.g., Java, MySQL" required>

            <label for="features">Features:</label>
            <textarea id="features" name="features" placeholder="Describe the features of the project" rows="5" required></textarea>

            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="image" accept="image/*">

            <label for="report">Upload Report:</label>
            <input type="file" id="report" name="report" accept=".pdf">

            <button type="submit">Add Project</button>
        </form>
    </main>
    <h2>Uploaded Projects</h2>
    <p>
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
                    echo "<iframe class='report-frame' src='" . htmlspecialchars($row['report_path']) . "'></iframe><br>";
                }

                echo "<hr>";
            }
        } else {
            echo "No projects found.";
        }

        mysqli_close($con);
        ?>
    </p>
</body>
</html>
