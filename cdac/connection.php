<?php
// Database settings

$host = 'localhost';  // dtabase hosting
$username = 'root'; // database username
$password = ''; // database passsword
$dbname = 'cdac'; // database name

//creating connection using mysql
$conn = new mysqli($host, $username,$password,$dbname);

//checking connection
if($conn ->connect_error){
    die ('connection failed:'. $conn->connect_error);

}else{
//  echo "connection done";
}