<?php

session_start();

include 'functions.php';

// Load Error_handler
include 'error_handling/error_handler.php';

set_error_handler("error_handler");

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
          
          <main><h1>Bloggers Site</h1>
              Welkom op deze Bloggers Site. Je kunt blogs lezen door 
          op de naam van een blogger te klikken aan de linkerkant. Als je zelf
          een blogger bent kun je inloggen en een blog schrijven, bewerken of 
          verwijderen.
          <p><img src="images/keyboard.jpg" width="200px"></p>
          </main>
          
          <right>
              <?php 
              if (isset($userID)) {
                  Display_Blogs($connection, $userID, $admin);
              }
              ?>
          </right>
      </section>
    </body>
</html>
