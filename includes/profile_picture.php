<?php

$target = glob("assets/images/profiles/" . $row['id'] . ".*");
if($target) {
    echo '<img src="' . $target[0] . '" width="' . $width . '" height="' . $height .'">'; 
} else {
    echo '<img src="assets/images/profiles/dummy-user.jpg" width="' . $width . '" height="' . $height .'">';

    }


?>