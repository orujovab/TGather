<?php 
@include 'config.php';
$conn = connect();
$msg='';
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // A form is posted
  session_start();  
  if (isset($_POST['login'])) { // Login process
      $username = mysqli_real_escape_string($conn, $_POST['username']); #read the username 
      $pass = md5($_POST['password']); #hash the password
   
   
      $select = " SELECT * FROM user_form WHERE username = '$username' && password = '$pass' "; #read the username and database from database
   
      $result = mysqli_query($conn, $select); #checks if the username is in database
   
      if(mysqli_num_rows($result) > 0){
   
         $row = mysqli_fetch_array($result); #if true go to this row in database
   
        //  if($row['user_type'] == 'user'){ #if the account type is user account:
   
            $_SESSION['user_name'] = $row['name'];
            $_SESSION["user_id"] = $row['id'];
            header('location:home.php');
            // header('location:user.php');
         
        //  }elseif($row['user_type'] == 'project account'){ #if the account type is project account:
   
            // $_SESSION['project_name'] = $row['name'];
            // $_SESSION["user_id"] = $row['id'];
            // header('location:project.php');
        //  }
        
      }else{
         $error[] = 'incorrect username or password!';  #if the username is not in database show error
      }

    }


    if (isset($_POST['register'])) { // Register process
      $username = $_POST['username'];

   
      $name = mysqli_real_escape_string($conn, $_POST['name']);  #will read all variables in the text boxes entered by users
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $username = mysqli_real_escape_string($conn, $_POST['username']);
      //$pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
      //$cpass = password_hash($_POST['cpass'], PASSWORD_BCRYPT);
      $password= $_POST['password'];
      $pass = md5($password); # hashs the password for security
      $cpass = md5($_POST['cpassword']);
      $user_type = $_POST['user_type'];
     
   
      $select = " SELECT * FROM  user_form WHERE username = '$username'";  #reads the username 
      $selectemail = " SELECT  * FROM user_form WHERE email = '$email'"; #reads the email 
      $usertype = "SELECT * FROM user_form WHERE user_type = '$user_type'" ; #reads the type of acoount
      #regex to check Uppercase lowercase, number, and special charachters(password validation)
      $uppercase = preg_match('@[A-Z]@', $password);  
      $lowercase = preg_match('@[a-z]@', $password);
      $number    = preg_match('@[0-9]@', $password);
      $specialChars = preg_match('@[^\w]@', $password);
   
      $result = mysqli_query($conn, $select);
      $resultemail = mysqli_query($conn, $selectemail);
   
   
      if(mysqli_num_rows($result) > 0){   #if the entered username is already in database, error will be displayed
   
         $errorr[] = 'User already exist!';
   
      }else{
   
         if(mysqli_num_rows($resultemail) > 0){  #if the entered email is already in database, error will be displayed
   
            $errorr[] = 'This email has been used';
   
         }else{
         
         if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 6){ #if the password is not strong
   
            $errorr[] = 'Weak Password.';
         
         }else{
   
         if($pass != $cpass){ #if entered confirm passoword and password are not the same, error will be displayed
         
            $errorr[] = 'Passwords are not matched!';
         
         }else{
   
            if($user_type == " "){ #if type of account has not been chosen, error will be displayed
         
               $errorr[] = 'Choose account type!';
   
            }else{ #if all info is correct, they will be written to database
   
               $insert = "INSERT INTO user_form(name, email, username, password, user_type, user_about, user_phone) VALUES('$name','$email','$username','$pass','$user_type','','0')";
               $sqli = mysqli_query($conn, $insert);
               if($sqli){
                   $msg = "<div class='alert alert-success'>Registered successfully.</div>";
               }else{
                   $errorr[] = mysqli_error($conn);
               }
            }
         }
      }
    }
  }   
}
};

?>
<!DOCTYPE html>

<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home page</title>  <!--title of login form-->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" 
    integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" 
    crossorigin="anonymous" />

 
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" 
   integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" 
   crossorigin="anonymous" />

   <!-- custom css  link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<!-- Header Menu of the Page -->
<body>

<div class="topnav">
  <!-- <a class="active" href="home.php">Home</a> -->
  <div class="tab">
    <a><button class="tablink" onclick="openTab(event,'home')" id="link1">Home</button></a>
    <a><button class="tablink active" onclick="openTab(event,'signin')" id="link2">Login</button></a>
    <a><button class="tablink" onclick="openTab(event,'signup')" id="link3">Sign Up</button></a>
   
  </div>
</div>

<div id="content">
    <img src="images\logot_preview_rev_1.png" class="ribbon"/>   
</div>

<div class="form-container">
<div class="tabcontent" id="home">
  <div class = "welcome-information">
      <h1>Welcome to<h1>
      <h1><span>ToGather!</span></h1>
      <br>
    <h2>
    Join your dream startup team in Minutes.</h2>
      <h2>Connect with your future teammates
      from all over the world.</h2>

<p>Togather is a platform that connects startup owners with their future teammates.

Startup owners share their project, people who match can apply to the startup and wait for approval from the project owner. 
After the startup owner accepts the suitable ones, they become teammates.
If you are looking for teammates to get your startup to the next level, or you want to be a part of a startup team, we got you!
</p>
  </div>

</div>
  <div class="tabcontent" id="signin">
   <form action="" method="post">
      <h3>login</h3>
      <?php
      if(isset($error)){  #if there found an error while logging in then show this error on the screen
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="username" id="loginusername" required placeholder="enter your username"><br><!--create the boxes for user to enter infos-->

      <div class="wrapper">
         <input id="password" type="password" name="password" id="loginuserpass" required placeholder="enter your password"><br>   
         
         <span class="show-btn" onclick="password_show_hide();">  <!--when user will click on show eye button this function will be prossessed-->
            <i class="fas fa-eye" id="show_eye"></i>
            <i class="fas fa-eye-slash d-none " id="hide_eye"></i>
         </span>

      </div> 


      <input type="submit" name="login" value="login" class="form-btn">
      <!-- <p>Forgot your password? <a href="recoveremail.php">Click Here.</a></p> -->
      <!-- <p>Don't have an account? <a href="registration.php">Register.</a></p>when clicking on the link user will go to registration page -->
   </form>
    </div>

    <div class="tabcontent" id="signup">
      <form action="" method="post">
        <h3>registration</h3>
        <?php
          if(isset($errorr)){  #if an error occurs while registering, it will be displayed on the screen
            foreach($errorr as $errorr){
               echo '<span class="error-msg">'.$errorr.'</span>';
            };
         };
        ?>
        <?php echo $msg; ?>

        <!-- <div class="required"> -->
    
        <input  type="text" name="name"  id="name" required placeholder="enter your name"><!--creates the input boxes-->

        <!-- <span style="color:#ff0000">*</span> -->       
    
        <input  type="email" name="email" id="email" required placeholder="enter your email">
  
        <input  type="text" name="username" id="username" required placeholder="enter your username">
    
        <div class="wrapper">
          <input id="password" type="password" name="password" required placeholder="enter your password">   
          <span class="show-btn" onclick="password_show_hide();">   <!--when user will click on show eye button this function will be prossessed-->
              <i class="fas fa-eye" id="show_eye"></i>
              <i class="fas fa-eye-slash d-none " id="hide_eye"></i>
          </span>
        </div>   


        <input id="cpassword" type="password" name="cpassword" required placeholder="confirm your password">
  

        <!-- </div> -->
        <select name="user_type">
          <option value=" ">choose your account type</option> <!--it gives selection option to user to choose type of their account-->
          <option value="user account">user account</option>
          <option value="project account">project account</option>
        </select>
        <input type="submit" name="register" value="register" class="form-btn">
        <!-- <p>Already have an account? <a href="login.php">Login!</a></p>if user already has an account, he/she will go to login page -->
    </form>
      </div>


   </div>
   <script src="js/scripts.js"></script>
</body>
</html>
