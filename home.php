<?php
session_start(); // Resume the session

if (!isset($_SESSION['username'])) {
    // Redirect to login page if username is not set
    header("Location: login.php");
    exit();
}

$username = htmlspecialchars($_SESSION['username']);

// Define headings, details, and links for the carts
$carts = [
    [
        "heading" => "About Me",
        "details" => "Edit About Me details here.",
        "link" => "about.php"
    ],
    [
        "heading" => "Contact Me",
        "details" => "Add or Edit Contact details and see messages.",
        "link" => "contact.php"
    ],
    [
        "heading" => "Experience",
        "details" => "Edit or Add Experiences.",
        "link" => "add_experience.php"
    ],
    [
        "heading" => "Passions",
        "details" => "Edit or Add Passions (Hobbies).",
        "link" => "add_passion.php"
    ],
    [
        "heading" => "Education",
        "details" => "Edit or Add Educations.",
        "link" => "edu.html"
    ],
    [
        "heading" => "Certifications",
        "details" => "Edit or Add Certifications.",
        "link" => "cer.html"
    ],
    [
        "heading" => "Projects",
        "details" => "Edit or Add Academic Projects or Company Projects.",
        "link" => "project.php"
    ],
    [
        "heading" => "Uploads",
        "details" => "Edit or Add Profile Picture and Video.",
        "link" => "media.php"
    ],
    [
        "heading" => "Gallery",
        "details" => "Add Gallery.",
        "link" => "gallery.php"
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="s2.css"> 
    <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
    <div class="icon">
        <a href="logout.php"><i class="bi bi-box-arrow-in-left" aria-label="Logout"></i></a> 
    </div>
    <div class="header">
        <h1>Welcome to Admin Page</h1>
        <b><p><?php echo "Login successful! Welcome, " . $username . "."; ?></p></b>
    </div>

    <div class="cart-container">
        <!-- Cart Boxes with unique details -->
        <?php foreach ($carts as $cart): ?>
            <div class="cart-box">
                <h2><?php echo $cart['heading']; ?></h2>
                <p><?php echo $cart['details']; ?></p>
                <a href="<?php echo $cart['link']; ?>" class="cart-button"><?php echo $cart['heading']; ?></a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
