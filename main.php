<?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "portfolio");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Start session to retrieve user info
session_start();

// Use POST data for dynamic username, default to 'AaqilShihab7' if not set
$username = isset($_POST['username']) ? $_POST['username'] : 'AaqilShihab7';
$username = mysqli_real_escape_string($con, $username);

// Fetch details from the 'about' table
$sql = "SELECT details FROM about WHERE username = '$username'";
$result = mysqli_query($con, $sql);
$details = ($result && mysqli_num_rows($result) > 0) ? mysqli_fetch_assoc($result)['details'] : "No details available for this user.";
mysqli_free_result($result);

// Fetch media (photos and videos) for the user
$media = [];
$sql = "SELECT file_path, file_type FROM media WHERE username = ?";
$stmt = $con->prepare($sql);
if ($stmt) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $media_result = $stmt->get_result();
    while ($row = $media_result->fetch_assoc()) {
        $media[] = $row;
    }
    $stmt->close();
}

// Fetch education details for the user
$education = [];
$sql = "SELECT degree, institution, year_of_completion FROM education WHERE username = ?";
$stmt = $con->prepare($sql);
if ($stmt) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $education_result = $stmt->get_result();
    while ($row = $education_result->fetch_assoc()) {
        $education[] = $row;
    }
    $stmt->close();
}

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Portfolio</title>
    <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="s.css">
</head>
<body>

    <header>
        <div class="profile_picture1">

  <?php
        // Display only the first photo in the header
        $photo_found = false;
        foreach ($media as $item) {
            if ($item['file_type'] === 'photo') {
                echo '<img src="' . htmlspecialchars($item['file_path']) . '" 
                          alt="Profile Picture" 
                          class="profile-picture" 
                          align="right">';
                $photo_found = true;
                break; // Stop after the first photo
            }
        }
        if (!$photo_found) {
            echo '<p>No profile picture found.</p>';
        }
        ?>
        </div>
        <h1>Welcome to My Portfolio</h1>
        <nav>
            <ul>
                <li><a href="#about">About Me</a></li>
                <li><a href="#education">Education</a></li>
                <li><a href="#certifications">Certifications</a></li>
                <li><a href="#experience">Experience</a></li>
                <li><a href="#projects">Projects</a></li>
                <li><a href="#passions">Passions</a></li>
                <li><a href="#contact">Contact Me</a></li>
                <li><a href="dis_gallery.php">Gallery</a></li>
                <li><a href="https://www.facebook.com" target="_blank"><i class="bi bi-facebook"></i></a></li>
                <li><a href="https://www.linkedin.com" target="_blank"><i class="bi bi-linkedin"></i></a></li>
                <li><a href="https://github.com" target="_blank"><i class="bi bi-github"></i></a></li>
                <li><a href="login.html"><i class="bi bi-person-circle"></i></a></li>
            </ul>
        </nav>
    </header>



    <section id="about">
        <h2>About Me</h2>
        <div class="about-content">
            <p>
                <?php echo nl2br(htmlspecialchars($details)); ?>
            </p>

        </div>

    </section>
  <?php
        // Display all videos in the body
        $video_found = false;
        foreach ($media as $item) {
            if ($item['file_type'] === 'video') {
                echo '<video width="750" controls autoplay class="profile-video">
                          <source src="' . htmlspecialchars($item['file_path']) . '" type="video/mp4" autoplay>
                          Your browser does not support the video tag.
                      </video>';
                $video_found = true;
            }
        }
        if (!$video_found) {
            echo '<p>No videos found.</p>';
        }
        ?>


    <section id="education">
        <h2>Education</h2>
        <div id="project-list">
            <div class="edu">
            <?php

// Database connection
$con = mysqli_connect("localhost", "root", "", "portfolio");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Assuming username is dynamic
$username = "AaqilShihab7";

// Prepared statement with a placeholder
$sql = "SELECT degree, institution, year_of_completion FROM education WHERE username = ?";
$stmt = $con->prepare($sql);

// Bind the username parameter
$stmt->bind_param("s", $username);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Display results
if ($result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li><b>" . htmlspecialchars($row['degree']) . "</b> from " . 
             htmlspecialchars($row['institution']) . " (" . 
             htmlspecialchars($row['year_of_completion']) . ")</li>";
    }
    echo "</ul>";
} else {
    echo "No qualifications found.";
}

// Close statement and connection
$stmt->close();
$con->close();

?>
<center><a href="file.php">See More</a></center>
</div>

        </div>
    </section>


    <section id="certifications">
        <h2>Certifications</h2>
        <div id="project-list">
            <div class="edu">
           <?php


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
<center><a href="file1.php">See More</a></center>
</div>

        </div>
    </section>


    <section id="experience">
        <h2>Experience</h2>
        <div id="project-list">
            <div class="edu">
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
                    echo "<p><strong>Job Title:</strong>" . htmlspecialchars($row['position_title']) . "</p>";
                    echo "<p><strong>Company:</strong> " . htmlspecialchars($row['company_name']) . "</p>";
                    echo "<p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>";
                    echo "<p><strong>Employment Date:</strong> " . htmlspecialchars($row['employment_date']) . "</p>";
                    echo "<p><strong>Description:</strong> " . htmlspecialchars($row['job_description']) . "</p>";

               

                    echo "<hr>";
                }
            } else {
                echo "<p>No experiences found.</p>";
            }

            mysqli_close($con);
            ?>

<center><a href="file3.php">See More</a></center>
</div>

        </div>
    </section>


    <section id="projects">
        <h2>Projects</h2>
        <div id="project-list"></div>
 <div class="edu">
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
        echo "<p><strong>Project Title:</strong> " . htmlspecialchars($row['heading']) . "</p>";
        echo "<p><strong>Section:</strong> " . htmlspecialchars($row['section']) . "</p>";
        echo "<p><strong>Tools:</strong> " . htmlspecialchars($row['tools']) . "</p>";
        echo "<p><strong>Features:</strong> " . htmlspecialchars($row['features']) . "</p>";



        echo "<hr>";
    }
} else {
    echo "No projects found.";
}

mysqli_close($con);
?>
<center><a href="file2.php">See More</a></center>
</div>

    </section>


<section id="passions">
        <h2>Passions</h2>
        <div id="project-list">
            <div class="edu">
           <?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "portfolio");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch passions
$sql = "SELECT passion FROM passions ORDER BY created_at DESC";
$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='passion-card'>";
       
        echo "<li><b>{$row['passion']}</b>  </li>";
        echo "</div>";
    }
} else {
    echo "<p>No passions found.</p>";
}

mysqli_close($con);
?>

<center><a href="file4.php">See More</a></center>
</div>

        </div>
    </section>


    <section id="contact">
        <h2>Contact Me</h2>
        <form id="contactForm" method="POST" action="submit1.php">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="message" placeholder="Your Message" required></textarea>
            <button type="submit">Send</button>
        </form>
    </section>

    <footer>
        <p>© 2024 Muhammadh Aakil Zihaf. All rights reserved.</p>
    </footer>

    <script src="scripts.js"></script>
</body>
</html>




