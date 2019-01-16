<?php
if(isset($_SESSION['userID'])) {
$userID = $_SESSION['userID'];
}
if(isset($_SESSION['admin'])) {
$admin = $_SESSION['admin'];
} else {
$admin = FALSE;
}
if(isset($_SESSION['username'])) {
$username = $_SESSION['username'];
}
