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

<?php
if(isset($_GET['id']) && $_GET['id'] != $_SESSION['user_id']) {
    $current_id = $_GET['id'];
    $flag = 1;
} else {
    $current_id = $_SESSION['user_id'];
    $flag = 0;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ToGather</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" 
    integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" 
    crossorigin="anonymous" /> -->

 
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" 
   integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" 
   crossorigin="anonymous" />


    <style>
    .post{
        margin-right: 50px;
        float: right;
        margin-bottom: 18px;
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
    </style>
</head>
<body>
<?php include 'header.php';?>
    <div class="container">
   
        <h1>Profile</h1>
        <?php
        $postsql;
        if($flag == 0) { // Your Own Profile       
            $postsql = "SELECT posts.post_caption, posts.post_time, user_form.name, user_form.user_about,
                                posts.post_public, user_form.id, user_form.username ,user_form.user_type, 
                                posts.post_id
                        FROM posts
                        JOIN user_form
                        ON user_form.id = posts.post_by
                        WHERE posts.post_by = $current_id
                        ORDER BY posts.post_time DESC";
            $profilesql = "SELECT user_form.id, user_form.user_type, user_form.username, user_form.name,user_form.user_about
                          FROM user_form
                          WHERE user_form.id = $current_id";
            $profilequery = mysqli_query($conn, $profilesql);
        } else { // Another Profile ---> Retrieve User data and friendship status
            $profilesql = "SELECT user_form.id, user_form.user_type,
                                user_form.username, user_form.name, user_form.user_about, userfriends.friendship_status
                            FROM user_form
                            LEFT JOIN (
                                SELECT friendship.user1_id AS user_id, friendship.friendship_status
                                FROM friendship
                                WHERE friendship.user1_id = $current_id AND friendship.user2_id = {$_SESSION['user_id']}
                                UNION
                                SELECT friendship.user2_id AS user_id, friendship.friendship_status
                                FROM friendship
                                WHERE friendship.user1_id = {$_SESSION['user_id']} AND friendship.user2_id = $current_id
                            ) userfriends
                            ON userfriends.user_id = user_form.id
                            WHERE user_form.id = $current_id";
            $profilequery = mysqli_query($conn, $profilesql);
            $row = mysqli_fetch_assoc($profilequery);
            mysqli_data_seek($profilequery,0);
            if(isset($row['friendship_status'])){ // Either a friend or requested as a friend
                if($row['friendship_status'] == 1){ // Friend
                    $postsql = "SELECT posts.post_caption, posts.post_time, user_form.name, posts.post_public, 
                                        user_form.id, user_form.user_type, user_form.username, user_form.user_about,posts.post_id
                                FROM posts
                                JOIN user_form
                                ON user_form.id = posts.post_by
                                WHERE posts.post_by = $current_id
                                ORDER BY posts.post_time DESC";
                }
                else if($row['friendship_status'] == 0){ // Requested as a Friend
                    $postsql = "SELECT posts.post_caption, posts.post_time, user_form.name, posts.post_public, 
                                    user_form.id, user_form.user_type, user_form.username, user_form.user_about, posts.post_id
                                FROM posts
                                JOIN user_form
                                ON user_form.id = posts.post_by
                                WHERE posts.post_by = $current_id AND posts.post_public = 'Y'
                                ORDER BY posts.post_time DESC";
                }
            } else { // Not a friend
                $postsql = "SELECT posts.post_caption, posts.post_time, user_form.name, posts.post_public, 
                                user_form.id, user_form.user_type, user_form.username, user_form.user_about, posts.post_id
                            FROM posts
                            JOIN user_form
                            ON user_form.id = posts.post_by
                            WHERE posts.post_by = $current_id AND posts.post_public = 'Y'
                            ORDER BY posts.post_time DESC";
            }
        }
        $postquery = mysqli_query($conn, $postsql);    
        if($postquery){
            // Posts
            $width = '40px'; 
            $height = '40px';
            if(mysqli_num_rows($postquery) == 0){ // No Posts
                if($flag == 0){ // Message shown if it's your own profile
                    echo '<div class="post">';
                    echo 'You don\'t have any posts yet';
                    echo '</div>';
                } else { // Message shown if it's another profile other than you.
                    echo '<div class="post">';
                    echo 'There is no public posts to show.';
                    echo '</div>';
                }
                include 'includes/profile.php';
            } else {
                while($row = mysqli_fetch_assoc($postquery)){
                    
                    if($flag == 0){ // Message shown if it's your own profile
                        echo '<div class="post">';
                        echo '<p class="public">';
                        echo '<a href="edit-post.php?id= ' . $row['post_id'] . ' " class="btn btn-primary"><i class="fas fa-pen" ></i>Edit</a><br>';
                        echo '<br>';
                        echo '</div>';
                        echo '</p>';
                    } 
                    
                    include 'includes/post.php';
                    echo '<br>';

                }
                // Profile Info
                include 'includes/profile.php';
                ?>
                <br>
                <!-- <?php if($flag == 0){?>
                <div class="profile">   
                    <center class="changeprofile"><a href = "settings.php"><i class="fas fa-bars" ></i> Settings</a></center> 
                </div>
                <br>
                <br>
                <?php } ?> -->
               
                <?php
            }
        }
        if($flag == 0){?>
                <br>
                <br>
            <div class="profile">   
                <center class="changeprofile"><a href = "settings.php"><i class="fas fa-bars" ></i> Settings</a></center> 
            </div>
            <br>
            <br>
            <?php } 
        ?>
    </div>
</body>

</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // A form is posted
    if (isset($_POST['request'])) { // Send a Friend Request
        $sql3 = "INSERT INTO friendship(user1_id, user2_id, friendship_status)
                 VALUES ({$_SESSION['user_id']}, $current_id, 0)";
        $query3 = mysqli_query($conn, $sql3);
        if(!$query3){
            echo mysqli_error($conn);
        }
    } else if(isset($_POST['remove'])) { // Remove
        $sql3 = "DELETE FROM friendship
                 WHERE ((friendship.user1_id = $current_id AND friendship.user2_id = {$_SESSION['user_id']})
                 OR (friendship.user1_id = {$_SESSION['user_id']} AND friendship.user2_id = $current_id))
                 AND friendship.friendship_status = 1";
        $query3 = mysqli_query($conn, $sql3);
        if(!$query3){
            echo mysqli_error($conn);
        }
    } 

}
?>
