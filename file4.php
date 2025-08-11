<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Files</title>
    <link rel="stylesheet" href="s8.css">
</head>
<body>
    <header>
        <h1>My Passions</h1>
    </header>
    <main>
        <section class="uploaded-files">
<?php
    // Database connection
    $con = mysqli_connect("localhost", "root", "", "portfolio");
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch passions
    $sql = "SELECT * FROM passions ORDER BY created_at DESC";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='passion-card'>";
            echo "<h2>" . htmlspecialchars($row['passion']) . "</h2>";

            // Fetch media for this passion
            $passion_id = $row['id'];
            $sql_media = "SELECT * FROM passion_media WHERE passion_id = '$passion_id'";
            $media_result = mysqli_query($con, $sql_media);

            if ($media_result && mysqli_num_rows($media_result) > 0) {
                echo "<div class='passion-media'>";
                while ($media_row = mysqli_fetch_assoc($media_result)) {
                    if ($media_row['media_type'] === 'image') {
                        echo "<img src='" . htmlspecialchars($media_row['media_path']) . "' alt='Passion Image'>";
                    } elseif ($media_row['media_type'] === 'video') {
                        echo "<video controls>
                                <source src='" . htmlspecialchars($media_row['media_path']) . "' type='video/mp4'>
                                Your browser does not support the video tag.
                              </video>";
                    }
                }
                echo "</div>";
            }

            echo "</div>";
        }
    } else {
        echo "<p>No passions found.</p>";
    }

    mysqli_close($con);
    ?>
        </section>
    </main>
</body>
</html>
