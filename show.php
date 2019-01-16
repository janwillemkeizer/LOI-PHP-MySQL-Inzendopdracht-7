<?php

session_start();

include 'config/connection.php';
include 'config/variables.php';
include 'functions.php';

// Load Error_handler
include 'error_handling/error_handler.php';

set_error_handler("error_handler");


$user_id = filter_input(INPUT_GET, 'UserID');
$blog_id = filter_input(INPUT_GET, 'BlogID');

if(isset($_SESSION['userID'])) {
$session_userID = $_SESSION['userID'];
} else {
  $session_userID = FAlSE;  
}


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inzendopdracht 051R7</title>
        <link rel="stylesheet" type="text/css" href="config/styles.css">
    </head>
    <body>
      <section id="page">
          <header>
              
              <?php 
              echo '<a href="index.php">HOME</a> | ';
              if (isset($_SESSION['username'])) {
              $user_login = TRUE;
              echo 'Ingelogd als ' . $_SESSION['username'] . 
              ' - <a href="logout.php">Uitloggen</a>' . 
              ' - <a href="new.php">Nieuw blog schrijven</a>' .
              ' - <a href="edit.php">Bewerken</a>';
              } else {
                    echo '<a href="login.php">Inloggen</a>';
                    $user_login = FALSE;
                } ?>      
          </header>
          
          <nav>
              <h1>Bloggers</h1><?php Display_Users($connection); ?>
          </nav>
          
          <main>
            <h1>Blogs</h1>
            <?php
            if (isset($user_id)) {
                $user_sql = "SELECT * FROM Blogs WHERE UserID='$user_id' ORDER BY Created DESC";
                $user_result = mysqli_query($connection, $user_sql) 
                        or die(mysqli_error($connection));
                $user_blogs_array = mysqli_fetch_all($user_result);
                
                if(count($user_blogs_array) === 0) {
                    echo 'Er zijn geen blogs.';
                }          

                foreach ($user_blogs_array as $blogs) {
                    echo "<h1>$blogs[2]</h1>";
                    echo "<p>$blogs[3]</p>";
                    echo '<h6>geschreven op: ' . date("d-m-Y", strtotime($blogs[4]));
                    if ($user_id === $session_userID) {
                        echo ' <a href="edit_blog.php?BlogID=' . $blogs[0] . '">' . '(Bewerken)</a>'
                            . ' - <a href="delete.php?BlogID=' . $blogs[0] . '">(Verwijderen)</a></h6><br>';
                    }
                }
            } 

            if (isset($blog_id)) {
                $blog_sql = "SELECT * FROM Blogs WHERE ID='$blog_id'";
                $blog_result = mysqli_query($connection, $blog_sql) 
                        or die(mysqli_error($connection));
                $blog_array = mysqli_fetch_row($blog_result);

                


                echo "<h1>$blog_array[2]</h1>";
                echo "<p>$blog_array[3]</p>";
                echo '<h6>geschreven op: ' . date("d-m-Y", strtotime($blog_array[4])). '</h6>';
            } 
              ?>
          </main>
          
          <right>
              <?php 
              if (isset($session_userID)) {
                  Display_Blogs($connection, $session_userID, $admin);
              }
              ?>
          </right>
      </section>
    </body>
</html>

