<?php
include_once 'config.php';
session_start();
ob_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");

}
$conn = connect();
$user_id = $_SESSION['user_id'];
$result = mysqli_query($conn,"SELECT * FROM user_form WHERE id = '$user_id'");
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/style.css">
<title>Delete record</title>
</head>
<body>
<?php include 'header.php';?>
<?php include 'sidebar.php';?>
<?php
	$i=0;
	while($row = mysqli_fetch_array($result)) {
	?>
<div class="form-container">
  <div class = "welcome-information">
      <p>Are you sure you want to Delete your account permanently?<p>
          <p>If you delete your account you will not be able to login this account, again</p>
          <p>If you still want to delete your account, follow the link below<p>
          <h1><span><a href="delete-process.php?userid=<?php echo $row["id"]; ?>">Delete</a></span></h1>
  </div>
  <?php
	$i++;
	}
	?>

</body>
</html>