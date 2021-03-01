<?php
// used to connect to the database
$host = "localhost";
$db_name = "todolist";
$username = "root";
$password = "";
  
try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
    if(!$con)
    {
        
        die ('Cannot connect to server');
    }
    else {
        echo "<h1>Connected</h1>";
    }
}
  

// show error
catch(PDOException $exception){
    echo "Connection error: " . $exception->getMessage();
}




?>