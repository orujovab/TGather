<?php 
require 'config.php';

session_start();
ob_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
$conn = connect();

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Change Password</title>
	<link rel="stylesheet" type="text/css" href="css/password.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php include 'header.php';?>
<?php include 'sidebar.php';?>

<div class="form-container">
    <form action="change-p.php" method="post">
     	<h2>Change Password</h2>
     	<?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>

     	<?php if (isset($_GET['success'])) { ?>
            <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>
     	
     	<input type="password" name="op" placeholder="Old Password">
     	<br>
     	<input type="password" name="np" placeholder="New Password">
        <br>
     	<input type="password" name="c_np" placeholder="Confirm New Password">
     	<br>
         <button type="submit">CHANGE</button>
     </form>
         </div>
</body>
</html>
