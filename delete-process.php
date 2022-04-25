<?php
require 'config.php';
session_start();
ob_start();
$conn = connect();
$id = $_SESSION['user_id'];
$sql = "DELETE FROM user_form WHERE id='$id'";
$sql1 = "DELETE FROM friendship WHERE user1_id='$id'";
$sql2 = "DELETE FROM posts WHERE post_by='$id'";
if (mysqli_query($conn, $sql) && mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
    ?>
    <center><div class="from-container" style="color: red; "><p><h1>Account deleted successfully.</h1></p></div><center>
    <?php

} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/style.css">
<title>Deleted account</title>
</head>
<body>

<div class="form-container">
  <div class = "welcome-information">
      <p>Go Back to ToGather<p>
        <h1><a href="index.php">Login/Registration</a></h1>
  </div>

</body>
</html>