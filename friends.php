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
?>

<!DOCTYPE html>
<html>
<head>
    <title>ToGather</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <style>
    .frame a{
        text-decoration: none;
        color: #4267b2;
    }
    .frame a:hover{
        text-decoration: underline;
    }
    </style>
</head>
<body>
<?php include 'header.php';?>
    <div class="container">
  
        <h1>TeamMates</h1>
        <?php
            echo '<center>'; 
            $sql = "SELECT user_form.id, user_form.name, user_form.username
                    FROM user_form
                    JOIN (
                        SELECT friendship.user1_id AS user_id
                        FROM friendship
                        WHERE friendship.user2_id = {$_SESSION['user_id']} AND friendship.friendship_status = 1
                        UNION
                        SELECT friendship.user2_id AS user_id
                        FROM friendship
                        WHERE friendship.user1_id = {$_SESSION['user_id']} AND friendship.friendship_status = 1
                    ) userfriends
                    ON userfriends.user_id = user_form.id";
            $query = mysqli_query($conn, $sql);
            $width = '168px';
            $height = '168px';
            if($query){
                if(mysqli_num_rows($query) == 0){
                    echo '<div class="post">';
                    echo 'You don\'t yet have any teammates yet.';
                    echo '</div>';
                } else {
                    while($row = mysqli_fetch_assoc($query)){
                    echo '<div class="frame">';
                    echo '<center>';
                    include 'includes/profile_picture.php';
                    echo '<br>';
                    echo '<a href="profile.php?id=' . $row['id'] . '">' . $row['name'] . '</a>';
                    echo '</center>';
                    echo '</div>';
                    }
                }
            }
            echo '</center>';
        ?>
    </div>
</body>
</html>