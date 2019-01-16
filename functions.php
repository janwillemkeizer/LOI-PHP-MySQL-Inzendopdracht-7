<?php

include 'config/connection.php';

function Display_Users($connection) {
       
$users_query = "SELECT Username, ID FROM Users";

$users_result = mysqli_query($connection, $users_query) 
        or die(mysqli_error($connection));

$user_array = mysqli_fetch_all($users_result);

//echo '<pre>';
//var_dump($user_array);
//echo '</pre>';

foreach ($user_array as $users) {
   
   if ($users[0] == 'admin') {
       continue;
   }
   echo '<a href="show.php?UserID=' . $users[1] . '">' . $users[0] . '</a><br>';
    
}
}

function Display_Blogs($connection, $UserID, $admin) {
    
if (!empty($UserID)) {
    
if ($admin) {
    $blogs_query = "SELECT ID, Title, Created FROM Blogs "
                . "ORDER BY Created DESC";
    } else {    
        $blogs_query = "SELECT ID, Title, Created FROM Blogs WHERE UserID='$UserID' "
                . "ORDER BY Created DESC";
    }
        $blogs_result = mysqli_query($connection, $blogs_query) 
                or die(mysqli_error($connection));

        $blogs_array = mysqli_fetch_all($blogs_result);
        
        if (count($blogs_array) > 0) {
            
        

        echo '<h2>Blogs aanpassen:</h2>';

        foreach ($blogs_array as $blogs) {

           echo '<a href="show.php?BlogID=' . $blogs[0] . '">' . 
                   date("d-m-Y", strtotime($blogs[2])) . ': ' . $blogs[1] . '</a>';
                   echo ' <a href="edit_blog.php?BlogID=' . $blogs[0] . '">' . '(Bewerken)</a>'
                           . ' - <a href="delete.php?BlogID=' . $blogs[0] . '">(Verwijderen)</a><br>';
        }
        } else {
            echo '<h5>Er zijn nog geen blogs geschreven.</h5>';
        }
    
}
}


