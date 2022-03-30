<?php
//goes to the login.php page and empties the session
session_start();
session_unset();
header("Location: index.php");

?>