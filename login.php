<?php
include 'config/connection.php';
include 'functions.php';

// Load Error_handler
include 'error_handling/error_handler.php';

set_error_handler("error_handler");

session_start();

$submit = filter_input(INPUT_POST, 'submit');
$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');
$message = '';

$error = TRUE;

if (isset($submit) && $submit === 'Verzend') {

if (isset($username) && isset($password)) {
$error = FALSE;

$passwordmd5 = md5($password);

$query = "SELECT * FROM `Users` WHERE username='$username' "
        . "AND password='$passwordmd5'";

$result = mysqli_query($connection, $query) 
        or die(mysqli_error($connection));
        
$count = mysqli_num_rows($result);

//Find ID for $username
$UserID_find = mysqli_fetch_row($result);

if ($count === 1){
$_SESSION['username'] = $username;
$_SESSION['userID'] = $UserID_find[0];
    if ($username == 'admin') {
    $_SESSION['admin'] = TRUE;    
    } else {
    $_SESSION['admin'] = FALSE; 
    }
header('Location: show.php?UserID=' . $UserID_find[0]);
} 
else {
$error = TRUE;
$message = "Deze inloggegevens zijn ongeldig. Probeer het alsjeblieft opnieuw.";
}
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
           <h1>Inloggen</h1>
           
           
               
        <form method="post" action="login.php">

            Gebruikersnaam: <input type="text" size="30" name="username" 
             value="<?php if(isset($username)) echo $username; ?>" > <br>

            Wachtwoord: <input type="password" size="30" name="password"
            value=""> <br>
            <input type="submit" name="submit" value="Verzend">
            
            <?php echo $message; ?>
            
        </form>
        
        <p>Nog geen account?</p>
        <a href="register.php">Registreer</a> of  
        <a href="index.php">ga terug naar de homepage</a>.          
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

