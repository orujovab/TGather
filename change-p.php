<?php 
require "config.php";
session_start();
ob_start();
$conn = connect();


if (isset($_SESSION['user_id'])) {


    if (isset($_POST['op']) && isset($_POST['np']) && isset($_POST['c_np'])) {

	// function validate($data){
    //    $data = trim($data);
	//    $data = stripslashes($data);
	//    $data = htmlspecialchars($data);
	//    return $data;
	// }

	// $op = validate($_POST['op']);
	// $np = validate($_POST['np']);
	// $c_np = validate($_POST['c_np']);

    $op = $_POST['op'];
	$np = $_POST['np'];
	$c_np = $_POST['c_np'];

   
    //   $select = " SELECT * FROM user_form WHERE id = $id && password = '$op' "; #read the username and database from database
   
    //   $result = mysqli_query($conn, $select); #checks if the username is in database
   
    //   if(mysqli_num_rows($result) > 0){
   

    $uppercase = preg_match('@[A-Z]@', $np);  
    $lowercase = preg_match('@[a-z]@', $np);
    $number    = preg_match('@[0-9]@', $np);
    $specialChars = preg_match('@[^\w]@', $np);
   
    
    if(empty($op)){
      header("Location: change-password.php?error=Old Password is required");
	  exit();
    }else if(empty($np)){
      header("Location: change-password.php?error=New Password is required");
	  exit();
    }else if($np !== $c_np){
      header("Location: change-password.php?error=The confirmation password  does not match");
	  exit();
    }else if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($np) < 6){ #if the password is not strong
   
      header("Location: change-password.php?error=Weak Password");
      exit();
    }else {
        
    	// hashing the password
    	$op = md5($op);
    	$np = md5($np);
        $id = $_SESSION['user_id'];
   
        $sql = "SELECT * FROM user_form WHERE id='$id' && password='$op'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
        	
        	$sql_2 = "UPDATE user_form SET password='$np' WHERE id='$id'";
        	mysqli_query($conn, $sql_2);
        	header("Location: change-password.php?success=Your password has been changed successfully");
	        exit();

        }else {

        	header("Location: change-password.php?error=Incorrect old password");
	        exit();
        }

    }
    
}else{
	header("Location: change-password.php");
	exit();
}

}else{
     header("Location: home.php");
     exit();
}