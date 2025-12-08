<?php
//Check for errors and displays
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL); 

//shows if logged in
session_start();
if(empty($_SESSION['logged_in'])) {
    header("Location: Login.php");
    exit;
}

$jsonFile = 'Blogpost_Entries.json';

//Create if not found
if (!file_exists($jsonFile)) {
    file_put_contents($jsonFile, json_encode([], JSON_PRETTY_PRINT));
}

//Read and decode safely
$jsonRaw = file_get_contents($jsonFile);
$posts = json_decode($jsonRaw, true);

//If corrupted, reset 
if (!is_array($posts)) {
    $posts = [];
}

//HANDLE FORM SUBMISSION
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Protect against HTML injection
    $title = trim($_POST['title']);
    $date = date("Y-m-d");

    //Convert textarea into paragraphs
    $paragraphsRaw = explode("\n", $_POST['content']);

    //Clean & filter empty lines
    $paragraphs = array_values(array_filter(array_map('trim', $paragraphsRaw)));

    //Escape HTML
    $paragraphs = array_map('htmlspecialchars', $paragraphs);

    //Generate unique ID
    $id = "post_" . time();

    //Build post array
    $posts[$id] = [
        'title'      => htmlspecialchars($title),
        'date'       => $date,
        'paragraphs' => $paragraphs
    ];

    //Save JSON
    file_put_contents(
        $jsonFile,
        json_encode($posts, JSON_PRETTY_PRINT),
        LOCK_EX
    );

    //Go back home
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Post</title>
        <meta name="author" content="Natalya Jones">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="my_style.css">
        <link rel="stylesheet" href="my_blog_style.css">
        <!-- Font Awesome for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<div class="body_wrapper">
    <div class="Hero_pic" style="border:2px solid black">
        <div class="TranspBox">
            <h2>Add New Post</h2>
            <form method="POST">
                <label><b>Title:<b></label><br>
                <input type="text" name="title" required><br><br>

                <label><b>Content (use line breaks for paragraphs):<b></label><br>
                <textarea name="content" rows="15" cols="70" required></textarea><br><br>

                <button type="submit">Add Post</button>
                <script src="Blog_JavaScript.js"></script>
            </form>
        </div>
    </div>
</div>
</body>
</html>
