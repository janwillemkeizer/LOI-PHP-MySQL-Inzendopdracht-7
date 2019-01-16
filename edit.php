<?php

include 'config/connection.php';
include 'config/variables.php';

// Load Error_handler
include 'error_handling/error_handler.php';

set_error_handler("error_handler");

session_start();

include 'functions.php';

if(isset($_SESSION['userID'])) {
$userID = $_SESSION['userID'];
}

$blog_id = filter_input(INPUT_GET, 'BlogID');


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
          
          <nav><h1>Bloggers</h1><?php Display_Users($connection); ?></nav>
          <main>
                           
              <?php 
            if (isset($userID)) {
                  Display_Blogs($connection, $userID, $admin);
              } else {
                  echo 'Er is niemand ingelogd';
              }
              ?>
          </main>
          <right>
              
          </right>
      </section>
    </body>
</html>


