<?php

@include 'config.php';

session_start();
session_unset();
session_destroy(); #destroys the session and go back to login page

header('location:index.php');

?>