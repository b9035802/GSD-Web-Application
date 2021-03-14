<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Add Student to Class</title>
</head>

<?php

//Instantaite new POST method variables in relation to the database to add a student to a class 

$studentToAdd = $_POST['studentToAdd'] ?? "";
$classToUpdate = $_POST['classToUpdate'] ?? "";

//Initialise link to database in 'connect.php'


session_start();
//Checks if the cookie is true, welcomes back user
if ($_SESSION['valid'] ?? "")
    {
         //If the cookie is validated by a user/coach signing in, welcome them back to the page
        //echo "Welcome back ".$_SESSION["User"].",  Access Level: ".$_SESSION['accessLevel'];
    }   
else 
    {
        //If not the user cannot view the page in full
        header("Location: ../html/index.html? no_access");
        exit(0);
    }
    
    //SQL - Inserting a new student record in the database
    
include "connect.php";
$sql = "INSERT INTO classmember(classId, studentNum) VALUES('$classToUpdate', '$studentToAdd')";

//If the SQL statement is successful and valid, execute the mehtod, if not, echo a failed response

if (mysqli_query($link, $sql))
	{
		echo "success";
        header("Location: updateClassForm.php? classToUpdate=$classToUpdate"); //Update class 
    }
else 
    {
        echo "failed";
        header("Location: updateClassForm.php? classToUpdate=$classToUpdate"); //Update Class
    }
?>

<body>
</body>
</html>