<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ToGather</title>

    <!-- Custom fonts for this template-->
    <link href="css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <!-- <link href="css/sb-admin-2.min.css" rel="stylesheet"> -->
    
    <!-- Custom styles for this page -->
    <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">

</head>

<body >

<div class="usernav">
    <?php
        $sql2 = "SELECT COUNT(*) AS count FROM friendship 
                 WHERE friendship.user2_id = {$_SESSION['user_id']} AND friendship.friendship_status = 0";
        $query2 = mysqli_query($conn, $sql2);
        $row = mysqli_fetch_assoc($query2);
    ?>
    <ul> <!-- Ensure there are no enter escape characters.-->
      <li><a href="home.php">Home</a></li><li><a href="friends.php">Teammates</a></li><li><a href="profile.php">Profile</a></li><li><a href="requests.php">Requests (<?php echo $row['count'] ?>)</a></li><li><a href="logout.php">Log Out</a></li>
    </ul>
    <div class="globalsearch">
        <form method="get" action="search.php" onsubmit="return validateField()"> <!-- Ensure there are no enter escape characters.-->
            <select name="location">
                <option value="name">Name</option>
                <option value="username">Username</option>
               
            </select><input type="text" placeholder="Search" name="query" id="query"><input type="submit" value="Search" id="querybutton">
        </form>
    </div>
</div>

<script>
function validateField(){
    var query = document.getElementById("query");
    var button = document.getElementById("querybutton");
    if(query.value == "") {
        query.placeholder = 'Type something!';
        return false;
    }
    return true;
}
</script>
</body>
            