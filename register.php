<?php

include 'config/connection.php';
include 'functions.php';

// Load Error_handler
include 'error_handling/error_handler.php';

set_error_handler("error_handler");

function emailcheck($email) {
    if (preg_match('#[a-zA-Z]{2,}@[a-zA-Z]{2,}\.nl#', $email))
  {
    return TRUE;
  } else {
    return FALSE;
  }  
}

function generate_password($length = 20){
  $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.
            '0123456789!#';

  $generated_password = '';
  $max = strlen($chars) - 1;

  for ($i=0; $i < $length; $i++)
    $generated_password .= $chars[random_int(0, $max)];

  return $generated_password;
}

$message = '';
$username_message = '';
$email_message = '';

$submit = filter_input(INPUT_POST, 'submit');

$error = TRUE;

if (isset($submit) && $submit === 'Verzend')
{
$username = filter_input(INPUT_POST, 'username');
$email = filter_input(INPUT_POST, 'email');
//$emailaddress = filter_input(INPUT_POST, 'email');

$error = FALSE;

if(!isset($username) || strlen(trim($username)) < 3) {
$username_message = "De gebruikersnaam moet minimaal uit drie tekens bestaan.";    
$error = TRUE;    
}
if(!isset($email) || !emailcheck($email)) {
$email_message = "Vul alsjeblieft een correct e-mailadres in dat eindigt op '.nl'.";    
$error = TRUE;    
} 
}

if(!$error) {
$password = generate_password(8);
    
$query = "INSERT INTO Users (Username, Email, Password)
          VALUES ('$username','$email', md5('$password'))";
$result = mysqli_query($connection, $query);

    if (mysqli_affected_rows($connection) === 1) {
    $message = '<h3>Succes! Je bent toegevoegd als gebruiker. Er is een '
            . 'wachtwoord naar je verstuurd.</h3>' . 
       '<a href="login.php">Ga naar inloggen</a>';
    
    
    $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    $message_body = "
        <html>
        <head>
        </head>
        <body>
        <h1>Welkom bij de Blogger Site</h1>
        <p>Beste $username,</p>
        <p>Leuk dat je geregistreerd bent op de site.</p>
        <p>Dit is je wachtwoord: $password</p>
        <p>Veel plezier,</p>
        <p>Het team</p>
        </body>
        </html>
        ";
    
    mail($email, 'Nieuw wachtwoord voor de Bloggers Site!', 
            $message_body,$headers);
    
    $username = "";
    $password = "";
    $email = "";
    
    } else {
    mysqli_error($connection);
    $message = '<p>Het is niet gelukt om je als gebruiker te registreren.'
            . ' Probeer een andere gebruikersnaam in te voeren. </p>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
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
          <h1>Registreren</h1>
            <p>Vul hieronder je gewenste gebruikersnaam en e-mailadres in. Er zal een 
            wachtwoord naar je e-mailadres worden verzonden</p>

            <form method="post" action="register.php">

            Naam: <input type="text" size="30" name="username" 
            value="<?php if(isset($username)) echo $username; ?>" ><?php echo 
            $username_message;?><br>

            E-mail: <input type="text" size="30" name="email" 
            value="<?php if(isset($email)) echo $email; ?>" > <?php echo 
            $email_message;?><br><br>
            <input type="submit" name="submit" value="Verzend">

            </form>
            <?php echo $message; ?>
            <p><a href="index.php">Ga terug naar de homepage</a>.</p>
          
          </main>
          
          <right>
              <?php 
              if (isset($userID)) {
                  Display_Blogs($connection, $userID, $admin);
              }
              ?>
          </right>
          </main>

      </section>   
</body>
</html> 


