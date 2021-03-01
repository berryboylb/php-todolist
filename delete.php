<?php
// include database connection
include 'config/database.php';
 
try {
     
    $ListId=isset($_GET['ListId']) ? $_GET['ListId'] : die('ERROR: Record ID not found.');
 
    // delete query
    $query = "DELETE FROM list WHERE ListId = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $ListId);
     
    if($stmt->execute()){
        // redirect to read records page and 
        // tell the user record was deleted
        header('Location: index.php?action=deleted');
    }else{
        die('Unable to delete record.');
    }
}
 
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>