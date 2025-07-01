<?php
//  CONFIGURING DATABASE

//Host Name
define('DB_SERVER', 'localhost');
//Username
define('DB_USERNAME', 'root');
//Password
define('DB_PASSWORD', '');
//Database Name
define('DB_NAME', 'studentportal');

//connect to database
$connectLink = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($connectLink === false){
    die("ERROR: Could not connect.". mysqli_connect_error());
}

// else{
//     echo "Database Connected Successfully";
// }
