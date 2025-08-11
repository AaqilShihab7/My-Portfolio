<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Experience</title>
    <link rel="stylesheet" href="ex.css">
</head>
<body>
    <header>
        <h1>Add Experience</h1>
    </header>
    <main>
        <?php
        // Database connection
        $con = mysqli_connect("localhost", "root", "", "portfolio");
        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $position_title = htmlspecialchars($_POST["position_title"]);
            $company_name = htmlspecialchars($_POST["company_name"]);
            $location = htmlspecialchars($_POST["location"]);
            $employment_date = htmlspecialchars($_POST["employment_date"]);
            $job_description = htmlspecialchars($_POST["job_description"]);

            // Handle file uploads
            $report_path = "";
            $service_letter_path = "";

            // Report Upload
            if (isset($_FILES["report"]["name"]) && $_FILES["report"]["name"] !== "") {
                $report_path = "uploads/" . basename($_FILES["report"]["name"]);
                move_uploaded_file($_FILES["report"]["tmp_name"], $report_path);
            }

            // Service Letter Upload
            if (isset($_FILES["service_letter"]["name"]) && $_FILES["service_letter"]["name"] !== "") {
                $service_letter_path = "uploads/" . basename($_FILES["service_letter"]["name"]);
                move_uploaded_file($_FILES["service_letter"]["tmp_name"], $service_letter_path);
            }

            // Insert data into the database
            $sql = "INSERT INTO experiences (position_title, company_name, location, employment_date, job_description, report_path, service_letter_path) 
                    VALUES ('$position_title', '$company_name', '$location', '$employment_date', '$job_description', '$report_path', '$service_letter_path')";

            if (mysqli_query($con, $sql)) {
                echo "<p>Experience added successfully!</p>";
            } else {
                echo "<p>Error: " . mysqli_error($con) . "</p>";
            }
        }

        mysqli_close($con);
        ?>

        <form action="add_experience.php" method="POST" enctype="multipart/form-data">
            <label for="position_title">Position Title</label>
            <input type="text" id="position_title" name="position_title" required>

            <label for="company_name">Company Name</label>
            <input type="text" id="company_name" name="company_name" required>

            <label for="location">Location</label>
            <input type="text" id="location" name="location" required>

            <label for="employment_date">Date of Employment</label>
            <input type="text" id="employment_date" name="employment_date" placeholder="YYYY.MM.DD-YYYY.MM.DD" required>

            <label for="job_description">Job Description</label>
            <textarea id="job_description" name="job_description" rows="5" required></textarea>

            <label for="report">Report (PDF or Image)</label>
            <input type="file" id="report" name="report" accept=".pdf, .jpg, .jpeg, .png">

            <label for="service_letter">Service Letter (PDF)</label>
            <input type="file" id="service_letter" name="service_letter" accept=".pdf">

            <button type="submit">Add Experience</button>
        </form>
    </main>
    <center><h2>Uploaded</h2></center>
<center>
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
</center>

</body>
</html>
