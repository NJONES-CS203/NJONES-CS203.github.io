<?php
session_start();

$hash = password_hash("CS203", PASSWORD_DEFAULT);

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';

    if (password_verify($password, $hash)) {
        $_SESSION['logged_in'] = true;
        header("Location: index.php"); // back to blog
        exit;
    } else {
        $error = "<div class='Error'><i class='fas fa-exclamation-triangle'></i> Incorrect password <i class='fas fa-exclamation-triangle'></i></div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
        <meta name="author" content="Natalya Jones">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="my_style.css">
        <link rel="stylesheet" href="my_blog_style.css">
        <!-- Font Awesome for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        
    </style>
</head>
<body>
    <div class="body_wrapper">
        <div class="Form">
            <h2>Login</h2>
            <?php if($error) echo "<p>$error</p>"; ?>
            <form method="POST">
                <label>Password:</label>
                <input type="password" name="password">
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
