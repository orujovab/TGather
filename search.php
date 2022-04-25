<?php
//
require 'config.php';
session_start();
// Check whether user is logged on or not
if (!isset($_SESSION['user_id'])) {
    header("location:index.php");
}
// Establish Database Connection
$conn = connect();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Social Network</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
<?php include 'header.php'; ?>
    <div class="container">
        <h1>Search Results</h1>
        <?php
            $location = $_GET['location'];
            $key = $_GET['query'];
            if($location == 'name') {
              $sql = "SELECT * FROM user_form WHERE user_form.name like '%$key%'";
              include 'includes/userquery.php';
          } else if($location == 'username') {
              $sql = "SELECT * FROM user_form WHERE user_form.username like '%$key%'";
              include 'includes/userquery.php';
        }
        ?>
    </div>
</body>
</html>
