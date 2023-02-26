<?php
session_start(); // Start a new session or resume an existing session

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page
header('Location: ../signin');
exit();
?>
