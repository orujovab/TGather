<?php

function connect() {
    static $conn;
    if ($conn === NULL){ 
        $conn = mysqli_connect('localhost','id18835789_togather','d]~$12P8_5X<4HU#','id18835789_localhost');  #creates the connection between php file and mysql
    }
    return $conn;
}

?>