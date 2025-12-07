<?php
session_start();
if(empty($_SESSION['logged_in'])){
    die("Not authorized");
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])){
    $id = $_POST['id'];

    $jsonFile = 'Blogpost_Entries.json';
    $posts = json_decode(file_get_contents($jsonFile), true) ?? [];

    if(isset($posts[$id])){
        unset($posts[$id]);
        file_put_contents($jsonFile, json_encode($posts, JSON_PRETTY_PRINT));
        echo "Post deleted";
    } else {
        echo "Post not found";
    }
}
?>
