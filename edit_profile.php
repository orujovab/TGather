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

$msg='';
if (isset($_POST["submit"])) {
    $user_id=$_SESSION['user_id'];
    $select = " SELECT * FROM user_form WHERE id= '$user_id'";
    $result = mysqli_query($conn, $select);
    $row = mysqli_fetch_array($result);
    // header('location:profile.php');

    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $username =  mysqli_real_escape_string($conn, $_POST["username"]);
    // $password = mysqli_real_escape_string($conn, md5($_POST["password"]));
    // $cpassword = mysqli_real_escape_string($conn, md5($_POST["cpassword"]));
    $userabout = mysqli_real_escape_string($conn, $_POST['user_about']);
    $number =  mysqli_real_escape_string($conn, $_POST["number"]);
 
    
            // $select = " SELECT * FROM  user_form WHERE username = '$username'";
            // $result = mysqli_query($conn, $select);
            // if(mysqli_num_rows($result) > 0){   #if the entered username is not in database
            //     $error[]='User already exist!';
            // }else{
                $sql = "UPDATE user_form SET name='$name', username = '$username' ,user_about = '$userabout', user_phone ='$number' WHERE id='{$_SESSION["user_id"]}'";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $msg = "<div class='alert-success'>Profile Updated successfully.</div>";
                    // move_uploaded_file($photo_tmp_name, "uploads/" . $photo_new_name);
                } else {
                $error[]='Profile can not Updated.';
                echo  $conn->error;
            // }
        }
        
    
   
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <link rel="stylesheet" href="css/main.css">

    <style>
     .post{
        margin-right: 50px;
        float: right;
        margin-bottom: 18px;
    }

    .container .post input{
        width: 85%;
        padding:10px;
        font-size: 15px;
        margin:8px 0;
        
        box-shadow: 0 5px 10px rgba(0,0,0,.1);
        background: #fff;
        /* background: #eee; */
        /* border-radius: 5px; */
    }
    .profile{
        margin-left: 50px;
        background-color: white;
        box-shadow: 0 0 5px #4267b2;
        width: 220px;
        padding: 20px;
    }
    input[type="file"]{
        display: none;
    }
    label.upload{
        cursor: pointer;
        color: white;
        background-color: #4267b2;
        padding: 8px 12px;
        display: inline-block;
        max-width: 80px;
        overflow: auto;
    }
    label.upload:hover{
        background-color: #23385f;
    }
    .changeprofile{
        color: #23385f;
        font-family: Fontin SmallCaps;
    }

    .error-msg{
        width: 90%;
        margin:10px 0;
        display: block;
        background: rgb(239, 84, 84);
        color:#fff;
        border-radius: 5px;
        font-size: 20px;
        padding:10px;
    }

    .alert-success{
        width: 90%;
        margin:10px 0;
        display: block;
        background: rgb(70, 146, 70);
        color:#fff;
        border-radius: 5px;
        font-size: 20px;
        padding:10px;

    }
    </style>
    <title>Profile Page</title>


</head>

<body >
<?php include 'header.php';?>
<?php include 'sidebar.php';?>
<?php include 'functions/upload.php'; ?>

<div class="container">
<!-- 
<form action="" method="post"> -->

   
   <?php
        $sql = "SELECT * FROM user_form WHERE id='{$_SESSION["user_id"]}'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
   ?>
    <br>
    <div class="post">
            
            
            <br>
            <form method="post" onsubmit="return validateNumber()">
            <center>
                <h3 style = 'margin-bottom : 10px; font-size : 30px ;  text-transform : uppercase; color:#333'>Edit Profile</h3>
                <?php
                if(isset($error)){  #if an error occurs while registering, it will be displayed on the screen
                    foreach($error as $error){
                        echo '<span class="error-msg">'.$error.'</span>';
                    };
                };
                ?>
                <?php echo $msg; ?>
                <br>
                <label style="float:left; margin-left: 40px; color: red">Name:</label>
                <br>
                <input type="text" id="name" name="name" required placeholder="name" value="<?php echo $row['name']; ?>" required>            
                <br>
                <label style="float:left; margin-left: 40px; color: red">Email:</label><br>
                <input type="email" id="email" name="email" required placeholder="email" value="<?php echo $row['email']; ?>"disabled required>
                <label style="float:left; margin-left: 40px; color: red">Username:</label><br>
                <input type="text" id="username" name="username" required placeholder="username" value="<?php echo $row['username']; ?>" required>
                <!-- <input type="password" id="password" name="password" required placeholder="password" value="<?php echo $row['password']; ?>" required>
                <input type="password" id="cpassword" name="cpassword" required placeholder="confirm password" value="<?php echo $row['password']; ?>" required> -->
                <br>
                <label style="float:left; margin-left: 40px; color: red">Phone Number:</label>
                <input type="text" name="number" id="phonenum" placeholder = "Add Phone Number" value="<?php echo $row['user_phone']; ?>">
                <div class="required"></div>
                <br>
                <label>About Me</label><br>
                <input style="width: 85%; height: 45px; text-align: bottom;" name="user_about" id="user_about"  value="<?php echo $row['user_about']; ?>">
                <input type="submit" name="submit" value="Update Profile" class="form-btn">
            </center>
            </form>
        </div>
        <?php
            }
        }

        ?>
     <div class="profile">    
        <center class="changeprofile">Change Profile Picture</center>
        <br>
        <form action="" method="post" enctype="multipart/form-data">
        <center>
            <label class="upload" onchange="showPath()">
                <span id="path" style="color: white;">... Browse</span>
                <input type="file" name="fileUpload" id="selectedFile">
            </label>
        </center>
        <br>
        <center><input type="submit" value="Upload Image" name="profile" ></center>
        </form>
    </div>
    <br>

    </form>
</div>
</body>

<script>
function showPath(){
    var path = document.getElementById("selectedFile").value;
    path = path.replace(/^.*\\/, "");
    document.getElementById("path").innerHTML = path;
}
function validateNumber(){
    var number = document.getElementById("phonenum").value;
    var required = document.getElementsByClassName("required");
    if(isNaN(number)){
        required[0].innerHTML = "Phone Number must contain digits only."
        return false;
    }
    return true;
}
</script>
</html>

</html>