<?php
session_start();
if (empty($_SESSION['logged_in'])) {
    http_response_code(403);
    exit("Not authorized");
}

// Get the postId from POST
$postId = $_POST['postId'] ?? '';
if (!$postId) {
    http_response_code(400);
    exit("No post ID provided");
}

// Load JSON
$jsonFile = 'Blogpost_Entries.json';
$posts = json_decode(file_get_contents($jsonFile), true) ?? [];

// Delete the post if it exists
if (isset($posts[$postId])) {
    unset($posts[$postId]);
    file_put_contents($jsonFile, json_encode($posts, JSON_PRETTY_PRINT));
    echo "Post deleted successfully";
} else {
    http_response_code(404);
    echo "Post not found";
}
?>

