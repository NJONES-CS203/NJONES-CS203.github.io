<?php 
    //start php so everything works
    session_start();
    $logged_in = !empty($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    //Check for errors and displays
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL); 
    
    $json = file_get_contents('./Blogpost_Entries.json');

    $posts = json_decode($json, true);

    
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Blog</title>
        <meta name="author" content="Natalya Jones">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="my_blog_style.css">
        <link rel="stylesheet" href="my_style.css">
        
        <!-- Font Awesome for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        
</head>
<body> 
    <nav class="nav">
            <div class="nav-left">
                <a href="index.html"> Home</a>
            </div>
            <div class="dropdown"> <!-- previous labs dropdown-->
                <button class="dropbtn"> Previous Labs</button>
                <div class="dropdown-content">
                    <a href="vacation01.html"> Vacation</a> 
                    <a href="artist.html"> My self</a> 
                    <a href="marketplace.html"> Marketplace</a> 
                    <a href="2-my_calculators.html"> Calculators</a>
                    <a href="to-do.html"> To Do List</a>
                </div>
            </div>
            <div class="nav-left">
                <a class="current"  href="index.php"> Blog</a>
            </div>
            <div class="nav-right"> <!-- trying to make it on the rightside-->
                <!-- LOGIN -->
                <div class="dropdown"> 
                    <button class="dropbtn"> 
                        <i class="fas fa-key"> </i>  Login</button>
                    <div class="dropdown-content">
                        <a href="Login.php"> Login </a>
                        <a href="Logout.php"> Logout </a>
                        <!-- DARK MODE (opt2) -->
                        <button onclick="DarkMode()"> Change Theme</button>
                        
                    </div>
                </div>
            </div>
    </nav>

        <div class="body_wrapper">
            <!-- HERO SECTION -->
            <div class="Hero_pic">
                <div class="Circle_animation"></div>
                    <h1 class="HText_title"> Natalya's Recpie Blog</h1>
                    <p class="HText_subtitle">Favourite recpies and stories </p>
            </div>

            <!-- MAIN SECTION -->
            <div class="Part2">
                <div class="Main">
                    <!-- ADD POST -->
                    <?php //Loading each blogpost from the json file
                        foreach ($posts as $id => $post) {
                            echo "<article class='Post' id='$id'>";
                            echo "<h1 class='post-title'>" . htmlspecialchars($post['title']) . "</h1>";
                            echo "<p class='post-date'><em>" . htmlspecialchars($post['date']) . "</em></p>";
                            echo "<div class='postTextWrapper post-body'>";
                            foreach ($post['paragraphs'] as $para) {
                                echo "<p class='postText'>" . htmlspecialchars($para) . "</p>";
                            }
                            echo "</div>";
                            if ($logged_in) {
                                echo "<button class='edit-btn' onclick=\"editPost('$id')\">Edit</button>";
                            }
                            echo "
                                <button class='read-toggle'>
                                    <span class='btn-text'>Read more</span>
                                    <i class='fa-solid fa-chevron-down toggle-icon'></i>
                                </button>";
                            echo "</article>";
                        }
                    ?>
                    <?php if($logged_in): ?>
                        <div class="add-post-container">
                            <a href="Add_Post.php" class="add-post-button">Add New Post <i class="fas fa-plus"></i></a>
                        </div>
                    <?php endif; ?>
                </div>
                                    
                <!-- ASIDE SECTION //list of all post -->
                <div class="Aside">
                    <div class="About" style="color: black;">
                        <p> Hi, my name is Natalya!</p>
                        <p> I've collected a lot of yummy recpies over the years and now is the time to share them</p>
                        <!-- WOBBLE ANIMATION (opt6) -->
                        <img id="wobble" src="Images/Wobble.PNG">
                        <h4>Other Posts</h4>
                        <ul class="Older_post">
                            <?php 
                                foreach ($posts as $id => $post) {
                                    //<!-- EDIT POST (opt4) -->
                                    //<!-- DELETE POST -->
                                    echo "<li><a href='#$id'>" . htmlspecialchars($post['title']) . "</a>";
                                    if ($logged_in) {
                                        // echo "<button class='edit-btn' onclick=\"editPost('$id')\">Edit</button>";
                                        echo " <button class='delete-post' data-post-id='$id'>
                                                <i class='far fa-trash-alt'></i>
                                            </button>";
                                    }
                                    echo "</li>";
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <p> test test tester</p>

            <!-- SORTING (opt5) -->
  
        </div>
    <div class="Footer">
        <p> Natalya's website for CSL203 </p>
    </div>
    <!--this makes sure that the most current version of my JS file is the one being used
    I had some issues earlier where it wasnt using the right JS file so I'm keeping this in to scare it -->
    <script src="Blog_JavaScript.js?v=5"> </script>  
</body>
</html>
