<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Database connection
    $con = mysqli_connect("localhost", "root", "", "portfolio");
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Collect form data
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    // Insert the gallery into the database
    $sql = "INSERT INTO gallery (title, description) VALUES ('$title', '$description')";
    if (mysqli_query($con, $sql)) {
        $gallery_id = mysqli_insert_id($con);

        // Handle file uploads
        if (!empty($_FILES['media']['name'][0])) {
            $target_dir = "uploads/"; // Directory where the files will be uploaded
            foreach ($_FILES['media']['name'] as $key => $media_name) {
                $target_file = $target_dir . basename($media_name);
                $media_type = mime_content_type($_FILES['media']['tmp_name'][$key]);

                if (move_uploaded_file($_FILES['media']['tmp_name'][$key], $target_file)) {
                    // Determine media type (image or video)
                    $type = str_starts_with($media_type, 'image/') ? 'image' : (str_starts_with($media_type, 'video/') ? 'video' : 'other');

                    // Insert media into database
                    $sql_media = "INSERT INTO gallery_media (gallery_id, media_path, media_type) VALUES ('$gallery_id', '$target_file', '$type')";
                    mysqli_query($con, $sql_media);
                }
            }
        }

        echo "<p class='success'>Gallery added successfully!</p>";
    } else {
        echo "<p class='error'>Error: " . mysqli_error($con) . "</p>";
    }

    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Gallery</title>
    <style>
        /* General styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        /* Center the form and add styling */
        form {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #dddddd;
            border-radius: 8px;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Form title */
        h1 {
            text-align: center;
            color: #333333;
        }

        /* Label styling */
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: inline-block;
            color: #555555;
        }

        /* Input and textarea styling */
        input[type="text"], 
        textarea, 
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        /* Submit button styling */
        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            form {
                padding: 15px;
            }

            input[type="text"], 
            textarea, 
            input[type="file"], 
            button[type="submit"] {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <h1>Add Gallery</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="media">Upload Images/Videos:</label><br>
        <input type="file" id="media" name="media[]" multiple required><br><br>

        <button type="submit" name="submit">Add Gallery</button>
    </form>
</body>
</html>
