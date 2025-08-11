<?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "portfolio");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch galleries from the database
$sql = "SELECT * FROM gallery";
$result = mysqli_query($con, $sql);

// Fetch associated media for each gallery
$galleries = [];
while ($row = mysqli_fetch_assoc($result)) {
    $gallery_id = $row['id'];
    $media_sql = "SELECT * FROM gallery_media WHERE gallery_id = $gallery_id";
    $media_result = mysqli_query($con, $media_sql);
    $media = [];
    while ($media_row = mysqli_fetch_assoc($media_result)) {
        $media[] = $media_row;
    }
    $row['media'] = $media;
    $galleries[] = $row;
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <style>
        /* General reset and body styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #ECFF8C, white);
            margin: 0;
            padding: 20px;
            color: #333;
        }

        /* Container to hold the entire gallery */
        .gallery-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            background: black;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        /* Heading and back button */
        h1 {
            text-align: center;
            color: white;
            margin-bottom: 20px;
            font-size: 32px;
            font-family: Magneto;
            font-size: 50px;
        }

        /* Back Button Styling */
        a.back-btn {
            display: inline-block;
            margin-bottom: 20px;
            font-size: 18px;
            text-decoration: none;
            color: white;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        a.back-btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        /* Gallery item styling */
        .gallery-item {
            background-color: #ECFF8C;
            padding: 20px;
            border: 1px solid #ddd;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .gallery-title {
            font-size: 34px;
            color: #333;
            margin-bottom: 10px;
            font-family: times new roman;
        }

        .gallery-description {
            font-size: 24px;
            color: #555;
            margin-bottom: 20px;
            font-family: Calibri Light;
        }

        /* Styling for the gallery media */
        .gallery-media {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .media-item {
            flex: 1 1 300px;
            max-width: 300px;
            overflow: hidden;
            margin-bottom: 15px;
            border-radius: 8px;
        }

        .media-image, .media-video {
            width: 100%;
            height: auto;
            border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .media-image {
            border: 1px solid #ddd;
        }

        .media-video {
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .nedia-inage,.media-video:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .gallery-container {
                padding: 15px;
            }

            .gallery-item {
                padding: 15px;
            }

            .gallery-title {
                font-size: 20px;
            }

            .gallery-description {
                font-size: 14px;
            }

            .gallery-media {
                flex-direction: column;
            }

            .media-item {
                max-width: 100%;
            }

            .back-btn {
                font-size: 16px;
                padding: 8px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="gallery-container">
        <!-- Back Button -->
        <a href="main.php" class="back-btn">Back to Main</a>
        <h1>Gallery</h1>

        <?php foreach ($galleries as $gallery): ?>
            <div class="gallery-item">
                <h2 class="gallery-title"><?= htmlspecialchars($gallery['title']) ?></h2>
                <p class="gallery-description"><?= nl2br(htmlspecialchars($gallery['description'])) ?></p>

                <div class="gallery-media">
                    <?php foreach ($gallery['media'] as $media): ?>
                        <div class="media-item">
                            <?php if ($media['media_type'] == 'image'): ?>
                                <img src="<?= htmlspecialchars($media['media_path']) ?>" alt="Gallery Image" class="media-image">
                            <?php elseif ($media['media_type'] == 'video'): ?>
                                <video controls class="media-video">
                                    <source src="<?= htmlspecialchars($media['media_path']) ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            <?php else: ?>
                                <p>Unsupported media type.</p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
