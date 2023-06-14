<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['loggedin'])) {
    session_unset();
    session_destroy();
}

// Redirect the user to the homepage or any other desired page
header("Location: index.php");
exit;
?>