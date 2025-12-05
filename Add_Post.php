<?php
session_start();
if(empty($_SESSION['logged_in'])) {
    header("Location: Login.php");
    exit;
}

//On submit
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = htmlentities($_POST['title']);
    $date = date("Y-m-d");
    $paragraphs = array_map('htmlentities', explode("\n", $_POST['content']));

    //Load existing
    $jsonFile = 'Blogpost_Entries.json';
    $posts = json_decode(file_get_contents($jsonFile), true) ?? [];

    //Use new ID for each post
    $id = "post_" . time();
    $posts[$id] = [
        'title' => $title,
        'date' => $date,
        'paragraphs' => $paragraphs
    ];

    file_put_contents($jsonFile, json_encode($posts, JSON_PRETTY_PRINT));

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Post</title>
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
                <textarea name="content" rows="10" cols="50" required></textarea><br><br>

                <button type="submit">Add Post</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
