<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Media</title>
    <link rel="stylesheet" href="s4.css">
</head>
<body>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <label for="file">Choose Photo/Video:</label>
        <input type="file" name="file" id="file" required>
        <input type="hidden" name="username" value="AaqilShihab7"> 
        <button type="submit">Upload</button>
    </form>
</body>
</html>
