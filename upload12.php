<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Files</title>
    <link rel="stylesheet" href="upload1.css">
</head>
<body>
    <h1>Upload Images or PDFs</h1>
    <form action="upload1.php" method="POST" enctype="multipart/form-data">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="heading">Heading:</label>
        <input type="text" id="heading" name="heading" required>
        
        <label for="file">Choose File:</label>
        <input type="file" id="file" name="file" required>
        
        <button type="submit">Upload</button>
    </form>

    <h1>Uploaded Files</h1>
    <div id="uploaded-files">
        <?php include 'getfile.php'; ?>
    </div>
</body>
</html>
