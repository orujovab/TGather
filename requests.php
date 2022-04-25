<?php 
require 'config.php';
session_start();
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
    <title>Social Network</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
<?php include 'header.php';?>
    <div class="container">
        <h1>Requests</h1>
        <?php
        // Responding to Request
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_GET['accept'])) {
                $sql = "UPDATE friendship
                        SET friendship.friendship_status = 1
                        WHERE friendship.user1_id = {$_GET['id']} AND friendship.user2_id = {$_SESSION['user_id']}";
                $query = mysqli_query($conn, $sql);
                if($query){
                    ?>
                    <div class="userquery">
                    You have accepted <?php echo $_GET['name'];?>
                    <br><br>
                    Redirecting in 5 seconds
                    <br><br>
                    </div>
                    <br>
                    <?php
                    echo "<script>
                    setTimeout(function(){
                        window.location.href = 'requests.php';
                     }, 5000);
                    </script>";
                    // echo "<script>window.location.href='refresh:5; url = requests.php';</script>";
                    // header("refresh:5; url = requests.php" );
                }
                else{
                    echo mysqli_error($conn);
                }
            } else if(isset($_GET['ignore'])) {
                $sql6 = "DELETE FROM friendship
                        WHERE friendship.user1_id = {$_GET['id']} AND friendship.user2_id = {$_SESSION['user_id']}";
                $query6 = mysqli_query($conn, $sql6);
                if($query6){
                    ?>
                    <div class="userquery">
                    You have Ignored <?php echo $_GET['name'];?>
                    <br><br>
                    Redirecting in 5 seconds
                    <br><br>
                    </div>
                    <br>
                    <?php
                    echo "<script>
                    setTimeout(function(){
                        window.location.href = 'requests.php';
                     }, 5000);
                    </script>";
                    // echo "<script>window.location.href='refresh:5; url = requests.php';</script>";
                    // echo "<script>window.location.href='refresh:5; url = requests.php';</script>";
                    // echo "header('refresh:5; url = requests.php' )";
                }
            }
        }
        //
        ?>
        <?php
        $sql = "SELECT user_form.user_type, user_form.id, user_form.username
                FROM user_form
                JOIN friendship
                ON friendship.user2_id = {$_SESSION['user_id']} AND friendship.friendship_status = 0 AND friendship.user1_id = user_form.id";
        $query = mysqli_query($conn, $sql);
        $width = '168px';
        $height = '168px';
        if(!$query)
            echo mysqli_error($conn);
        if($query){
            if(mysqli_num_rows($query) == 0){
                echo '<div class="userquery">';
                echo 'You have no pending requests.';
                echo '<br><br>';
                echo '</div>';
            }
            while($row = mysqli_fetch_assoc($query)){
                echo '<div class="userquery">';
                include 'includes/profile_picture.php';
                echo '<br>';
                echo '<a class="profilelink" href="profile.php?id=' . $row['id'] .'">' . $row['username'] . '<a>';
                echo '<form method="get" action="requests.php">';
                echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                echo '<input type="hidden" name="name" value="' . $row['username'] . '">';
                echo '<input type="submit" value="Accept" name="accept">';
                echo '<br><br>';
                echo '<input type="submit" value="Ignore" name="ignore">';
                echo '<br><br>';
                echo'</form>';
                echo '</div>';
                echo '<br>';
            }
        }
        ?>
    </div>
</body>
</html>