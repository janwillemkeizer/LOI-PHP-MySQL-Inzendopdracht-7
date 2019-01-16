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

$blog_sql = "SELECT * FROM Blogs WHERE ID='$blog_id'";
$blog_result = mysqli_query($connection, $blog_sql) 
        or die(mysqli_error($connection));
$blog_array = mysqli_fetch_row($blog_result);

//var_dump($blog_array);

$title = $blog_array[2];
$content = nl2br($blog_array[3]);

$title_message = '';
$content_message = '';

$submit = filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_STRING);
$reset = filter_input(INPUT_POST, 'reset', FILTER_SANITIZE_STRING);


if (isset($submit)) {
$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
$content = nl2br(filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING));
$blog_id = filter_input(INPUT_POST, 'blog_id', FILTER_SANITIZE_STRING);
  
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
            $update_query = "UPDATE Blogs SET Title = '$title', "
            . "Content = '$content' "
            . "WHERE ID = '$blog_id'";
            mysqli_query($connection, $update_query)
            or die(mysqli_error($connection));
            mysqli_close($connection);
            header('Location: show.php?UserID=' . $userID);
        }
}

if(isset($reset)) {
    $title = '';
    $content = '';
    $blog_id = filter_input(INPUT_POST, 'blog_id', FILTER_SANITIZE_STRING);
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
          
          <nav><h1>Bloggers</h1><?php Display_Users($connection); ?></nav>
          <main>
              <form method="post" action="edit_blog.php">
                <label for="title">Titel</label><br> 
                <input type="text" 
                       name="title" value="<?php if(isset($title)) echo $title; ?>" ><br>
                <?php echo $title_message; ?><br>
                <label for="content">Blog</label><br>
                <textarea name="content" rows="10"><?php if(isset($content))echo nl2br($content); ?>
                </textarea><br><?php echo $content_message; ?><br>
                <input type="hidden" name="blog_id" value="<?php echo $blog_id; ?>">
                <input type="submit" name="submit" value="Verzend">
                <input type="submit" name="reset" value="Reset">
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


