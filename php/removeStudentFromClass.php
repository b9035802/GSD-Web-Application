<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<?php

session_start();

//Instantiate new POST methods and set field to empty primitive if null

$studentIdToRemove = $_POST['studentIdToRemove'] ?? "";
$classToUpdate = $_POST['classToUpdate'] ?? "";
$remove = $_POST['remove'] ?? "";

//Extend thread on connect.php

include "connect.php";

//If session is not valid

if ($_SESSION['valid'] ?? "")
    {
        //If the cookie is validated by a user/coach signing in, welcome them back to the page
        //echo "Welcome back ".$_SESSION["User"].", Access Level: ".$_SESSION['accessLevel']."! ";
    }   
else 
    {  
        //If not the user cannot view the page in full, send them back to home with noaccess
        header("Location: ../html/index.html? no_access");
        exit(0);
    }

//SQL - delete from classmember where the studentNum is equal to the student being removed and classID is equal to the class updated

$sql = "DELETE FROM classMember WHERE studentNum = '$studentIdToRemove' AND classId = '$classToUpdate'";

//If database has recieved query

if (mysqli_query($link, $sql))
	{
		echo "success";
		header("Location: updateClassForm.php? classToUpdate=$classToUpdate"); //updated successfully 
		
	}
	else 
		{
            echo "failed";
            header("Location: updateClassForm.php? classToUpdate=$classToUpdate"); //not updated successfully
		}
?>

<body>
</body>
</html>