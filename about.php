<?php
require 'config.php';

session_start();
ob_start();
// Check whether user is logged on or not
if (!isset($_SESSION['user_id'])) {
    header("location:index.php");
}
// Establish Database Connection
$conn = connect();

include 'header.php';
include 'sidebar.php';

// if(!isset($_SESSION['project_name'])){
//    header('location:login.php');
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>  <!--title of the project-->

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>


<div class="form-container">
<div class="tabcontent" id="home">
  <div class = "welcome-information">
      <h1><span style="margin-left: 240px">ToGather</span></h1><br>
      <br>
      <h2 style="font-size: 25px; color: black; text-align:center; margin-left: 310px">Join your dream startup team in Minutes.</h2>
      <h2 style="font-size: 25px; color: black; text-align:center; margin-left: 310px">Connect with your future teammates from all over the world.</h2>
      <br><br>

<p style="text-align:center;margin-left: 200px">Togather is a platform that connects startup owners with their future teammates.

Startup owners share their project, people who match can apply to the startup and wait for approval from the project owner. 
After the startup owner accepts the suitable ones, they become teammates.
If you are looking for teammates to get your startup to the next level, or you want to be a part of a startup team, we got you!
</p>
  </div>
</body>
</html>