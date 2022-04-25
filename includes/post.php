<?php

if(isset($_GET['id']) && $_GET['id'] != $_SESSION['user_id']) {
    $current_id = $_GET['id'];
    $flag = 1;
} else {
    $current_id = $_SESSION['user_id'];
    $flag = 0;
}

echo '<div class="post">';
echo '<p class="public">';
// if($flag == 0){ // Message shown if it's your own profile
//     echo '<a href="edit-post.php?id= ' . $row['post_id'] . ' " class="btn btn-primary"><i class="fas fa-pen" ></i>Edit</a><br>';
//     echo '<br>';
// }
echo '<br>';
if($row['post_public'] == 'Y') {

    echo 'Public';
}else {

    echo 'Private';   
}
echo '<br>';
echo '<span class="postedtime">' . $row['post_time'] . '</span>';
echo '</p>';
echo '<div>';
include 'profile_picture.php';
echo '<a class="profilelink" href="profile.php?id=' . $row['id'] .'">' . $row['username']  . '<a>';
echo'</div>';
echo '<br>';
echo '<p class="caption">' . $row['post_caption'] . '</p>';
echo '<center>'; 

echo '<br>';
$target = glob("assets/images/posts/" . $row['post_id'] . ".*");
if($target) {
    echo '<img src="' . $target[0] . '" style="max-width:580px">'; 
    echo '<br><br>';
}
echo '<br>';
echo '</center>';
echo '</div>';


?>
