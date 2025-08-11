<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Passion with Media</title>
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        /* Header */
        header {
            background-color: #0056b3;
            color: white;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            font-size: 2.5rem;
        }

        /* Form Styling */
        .form-container {
            background: white;
            padding: 20px;
            margin: 30px auto;
            max-width: 400px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-container label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        .form-container input[type="text"],
        .form-container input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-container button {
            width: 100%;
            background-color: #0056b3;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #003d80;
        }

        /* Passions Display */
        .passion-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            max-width: 400px;
            text-align: center;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .passion-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        .passion-card h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .passion-media {
            margin-top: 10px;
        }

        .passion-media img,
        .passion-media video {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-top: 10px;
        }

        .error {
            color: red;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }

        .success {
            color: green;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Add Your Passion with Images and Videos</h1>
    </header>
    <main>
        <form action="" method="post" enctype="multipart/form-data" class="form-container">
            <label for="passion">Passion:</label>
            <input type="text" id="passion" name="passion" placeholder="Enter your passion" required>
            
            <label for="media">Images/Videos (you can select multiple):</label>
            <input type="file" id="media" name="media[]" accept="image/*,video/*" multiple>
            
            <button type="submit" name="submit">Add Passion</button>
        </form>
    </main>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        // Database connection
        $con = mysqli_connect("localhost", "root", "", "portfolio");
        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Collect form data
        $passion = mysqli_real_escape_string($con, $_POST['passion']);
        
        // Insert the passion into the database
        $sql = "INSERT INTO passions (passion) VALUES ('$passion')";
        if (mysqli_query($con, $sql)) {
            $passion_id = mysqli_insert_id($con);

            // Handle file uploads
            if (!empty($_FILES['media']['name'][0])) {
                $target_dir = "uploads/";
                foreach ($_FILES['media']['name'] as $key => $media_name) {
                    $target_file = $target_dir . basename($media_name);
                    $media_type = mime_content_type($_FILES['media']['tmp_name'][$key]);

                    if (move_uploaded_file($_FILES['media']['tmp_name'][$key], $target_file)) {
                        // Determine media type (image or video)
                        $type = str_starts_with($media_type, 'image/') ? 'image' : (str_starts_with($media_type, 'video/') ? 'video' : 'other');

                        // Insert media into database
                        $sql_media = "INSERT INTO passion_media (passion_id, media_path, media_type) VALUES ('$passion_id', '$target_file', '$type')";
                        mysqli_query($con, $sql_media);
                    }
                }
            }

            echo "<p class='success'>Passion added successfully!</p>";
        } else {
            echo "<p class='error'>Error: " . mysqli_error($con) . "</p>";
        }

        mysqli_close($con);
    }
    ?>

    <h1>My Passions</h1>
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
</body>
</html>
