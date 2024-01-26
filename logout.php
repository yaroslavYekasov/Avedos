<?php
// Check if 'code' parameter is set in the URL
if (isset($_GET['code'])) {
    // Display the highlighted source code of this file and terminate execution
    die(highlight_file(__FILE__, 1));
}

session_start();
session_destroy();
header("location: veoLisamine.php");
?>
