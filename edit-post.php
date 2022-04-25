<?php
require 'config.php';
session_start();
ob_start(); 
// Check whether user is logged on or not
if (!isset($_GET['id'])) {
    header("location:profile.php");
}else{

    $post_id = $_GET['id'];
}
$conn = connect();
$msg='';
// Establish Database Connection


if (isset($_POST['edit'])) {
    $caption =  mysqli_real_escape_string($conn, $_POST["caption"]);

    if ($caption == " ") {
        $error[]='Caption can not be empty.';
    } else {
            // update info in database
        $sql = "UPDATE posts SET post_caption='$caption' WHERE post_id='$post_id'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $msg = "<div class='alert-success'>Post Updated successfully.</div>";
        } else {
            $error[]='Post can not Updated.';
        }
    }
}
    
if (isset($_POST['remove'])) {
    // gets the id of post from the current session
    
    // $post_id = $_GET['id'];

    $sql = "DELETE FROM posts WHERE post_id='$post_id'";
        // deletes the post with the specific id
    $result = mysqli_query($conn, $sql);
    if ($result) {
            // and return true or false values
        header("Location: profile.php?remove_success=true");
    } else {
        header("Location: profile.php?remove_success=false");
    }

}



?>

<!DOCTYPE html>
<html>
<head>
    <title>ToGather</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <style>

        
    .error-msg{
        width: 97%;
        margin:10px 0;
        display: block;
        background: rgb(239, 84, 84);
        color:#fff;
        border-radius: 5px;
        font-size: 20px;
        padding:10px;
    }

    .alert-success{
        width: 97%;
        margin:10px 0;
        display: block;
        background: rgb(70, 146, 70);
        color:#fff;
        border-radius: 5px;
        font-size: 20px;
        padding:10px;

    }

        </style>
</head>
<body>
<?php include 'header.php';?>
    <div class="container">
    <?php
        $sql = "SELECT * FROM posts WHERE post_id='$post_id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
   ?>
        <br>
        <div class="createpost">
            <form method="post" action="" onsubmit="return validatePost()" enctype="multipart/form-data">
            
                <?php 
                    if(isset($error)){  #if an error occurs while registering, it will be displayed on the screen
                        foreach($error as $error){
                            echo '<span class="error-msg">'.$error.'</span>';
                        };
                    };
                    ?>
                <?php echo $msg; ?>
                <h2>Edit Caption</h2>
                <br>
                Caption
                <br>
                <input  style="width: 100%; height: 45px; margin-top: 30px" type="text" name="caption" id="caption" placeholder = "Add Caption" class="required" value="<?php echo $row['post_caption'];?>"><span class = "required" style= "display:none"> *You can't Leave the Caption Empty.</span><br>
                        
                <center><img src="" id="preview" style="max-width:580px; display:none;"></center>
             
                <br>
                <div class="createpostbuttons">
                    <!--<form action="" method="post" enctype="multipart/form-data" id="imageform">-->
                    <input type="submit" value="Edit" name="edit">
                    
                    <!--</form>-->
                </div>
                <br>
                <div class="createpostbuttons">
                    <input style="background: red" type="submit" value="Delete post" name="remove">
                        </div>
                </form>
        </div>
        <?php
            }
        }
        ?>

    </div>
    </body>
</html>
