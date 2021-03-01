<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo list with php</title>
    <link rel="stylesheet" href="styless.css">
</head>
<body>
    <?php
    //adding database connection
     include 'config/database.php';
    //clear all warnings
     error_reporting(E_ERROR | E_PARSE);

     //sql query
     $query = "INSERT INTO list
     SET ListContent=:ListContent, Created_on=:Created_on";

    //preparing query for execution
    $stmt = $con->prepare($query);

    //get list content from the form using html specialchars

    $ListContent= htmlspecialchars(strip_tags($_POST['ListContent']));

    if($ListContent) {
        //used in order to avoid the db filled with empty spaces
        $stmt->bindParam(':ListContent', $ListContent);
        $Created_on=date('Y-m-d H:i:s');
        $stmt->bindParam(':Created_on', $Created_on);
        // header('Location: ' . $_SERVER['PHP_SELF']);
        // exit(0);
    }else {
        //if empty it won't write any just echo write something
       echo "<div class = 'alert'><h3>write something</h3></div>";
    }

   
    //if PDO statement successfully occurs  echo the record was saved and redirect back to the page
    //in order to stop refreshing
    if($stmt->execute()){
        echo "<div class='alert'> <h3>Record was saved.</h3></div>";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit(0);
    }
    ?>
    
    <div class="container">
    <div class="name"><h3>Todo list</h3></div>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
    <input type="text" class= "data" name ="ListContent" placeholder ="Write something here...">
    <input type="submit" class = "submit" value="Add">
    </form>
        <ul class="content">
        <?php
           
           //grabbing all the data using a foreach each time the $con query runs we display it like so

            foreach($con->query("SELECT * FROM list") as $row){
                echo "<li class =\"li\"><div class=\"checkbox_wrapper\"><input type=\"checkbox\" class=\"input_class_checkbox\" onclick='overLine()' > <label></label> <h3>{$row['ListContent']}</h3></div> 
                <button class=\"cancel\" onclick='delete_user({$row[ListId]});'>Delete</button></li>";
            }
        ?>

        </ul>
    </div>
    <input type="range" name="range" id="" >
    
    <script type='text/javascript'>
    // confirm record deletion
    function delete_user( ListId ){
        
        var answer = confirm('Are you sure?');
        if (answer){
            // pass the id to delete.php and execute the delete query
            window.location = 'delete.php?ListId=' + ListId;
        } 
    }
    
    function overLine(){
        const ul = document.querySelector('.content');

        const shady = ul.children;
    // console.log(shady);

    Array.from(shady).forEach(function(e){
       const checkbox = e.firstElementChild.firstElementChild;

       if(checkbox.checked){
           checkbox.nextElementSibling.nextElementSibling.style.textDecoration = "line-through";
       }else {
        checkbox.nextElementSibling.nextElementSibling.style.textDecoration = "none";
       }
    });
    }
    </script>
</body>
</html>