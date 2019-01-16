<?php
include 'config/connection.php';
include 'functions.php';
include 'config/variables.php';

// Load Error_handler
include 'error_handling/error_handler.php';

set_error_handler("error_handler");

session_start();

$title_message = '';
$content_message = '';

$error = TRUE;

if (isset($_SESSION['username'])) {
$username = $_SESSION['username'];
$userID = $_SESSION['userID'];
$user_login = TRUE;
$user_logged_in = 'Ingelogd als ' . $_SESSION['username'] . 
' - <a href="logout.php">Uitloggen</a>';   
} else {
    $user_not_logged_in = '<a href="login.php">Inloggen</a>';
    $user_login = FALSE;
} 

$submit = filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_STRING);
$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
$content = nl2br(filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING));

if (isset($submit) && $user_login) {
    
    $error = FALSE;

        if(!isset($title) || strlen(trim($title)) < 3) {
        $title_message = "Deze titel is wel erg kort. Kan het wat langer?";    
        $error = TRUE;    
        }
        if(!isset($content) || strlen(trim($content)) <= 3) {
        $content_message = "<p>Een blog met maximaal drie tekens is geen blog natuurlijk ;-)</p>" .
                '<p>Zou je meer tekst kunnen typen?</p>';    
        $error = TRUE;    
        }

        if (!$error) {
            $sql = "INSERT INTO Blogs (UserID, Title, Content)
                VALUES ('$userID','$title', '$content')";

                mysqli_query($connection, $sql) or die (mysqli_error($connection));

            header('Location: show.php?UserID=' . $userID);
        }
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
              <a href="index.php">HOME</a>
              <?php
              if ($user_login) {
                  echo $user_logged_in;
              } else {
                  echo $user_not_logged_in;
              }
              ?>      
          </header>
          
          <nav><h1>Bloggers</h1><?php Display_Users($connection); ?></nav>
          <main><h1>Nieuw blog</h1>
              <form method="post" action="new.php">
                <label for="title">Titel</label><br> 
                <input type="text" 
                name="title" value="<?php if(isset($title)) 
                    echo $title; ?>" ><br><?php echo $title_message; ?> <br><br>
                <label for="content">Blog</label><br>
                <textarea name="content" rows="10"><?php if(isset($content)) echo $content; ?></textarea><br>
                <?php echo $content_message; ?><br>
                <input type="submit" name="submit" value="Verzend">
                <input type="reset" value="Reset">
              </form>
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

