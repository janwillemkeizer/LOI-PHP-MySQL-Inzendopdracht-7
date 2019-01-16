<?php

session_start();

include 'config/connection.php';
include 'config/variables.php';

// Load Error_handler
include 'error_handling/error_handler.php';

set_error_handler("error_handler");

$blog_id = filter_input(INPUT_GET, 'BlogID');

$delete_sql = "DELETE FROM Blogs WHERE ID='$blog_id'";
mysqli_query($connection, $delete_sql) or 
        die(mysqli_error($connection));

header('Location: show.php?UserID=' . $userID);
