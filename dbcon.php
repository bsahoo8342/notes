<?php
//Database connection
$server="localhost";
$username= "<USERNAME>";
$password="<PASSWORD>.";
$database= "<DATABASE_NAME>";

$con=mysqli_connect($server,$username,$password,$database);
if(mysqli_connect_errno()){
    echo "Connection not success!!". mysqli_connect_error();
}
?>