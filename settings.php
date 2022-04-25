<?php 
require 'config.php';
session_start();
// Check whether user is logged on or not
if (!isset($_SESSION['user_id'])) {
    header("location:index.php");
}else{
    header("location:about.php");
}

$temp = $_SESSION['user_id'];
session_destroy();
session_start();
$_SESSION['user_id'] = $temp;
ob_start(); 
// Establish Database Connection
$conn = connect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Social Network</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/w3.css">
</head>
<body>
<?php include 'header.php';?>
<?php include 'sidebar.php';?>

</body>
</html>