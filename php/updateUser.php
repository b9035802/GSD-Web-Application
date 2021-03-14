<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<?php
session_start();

//Instantiate new POST methods and set the primitive to empty if null

$userNameToUpdate = $_POST['userNameToUpdate'] ?? "";
$fullName = $_POST['fullName'] ?? "";
$accessLevel = $_POST['accessLevel'] ?? "";
$update = $_POST['update'] ?? "";

//Esxtend threat 


//If session valid

if ($_SESSION['valid']?? "")
{
    //If the cookie is validated by a user/coach signing in, welcome them back to the page
    //echo "Welcome back ".$_SESSION["User"].", Access Level: ".$_SESSION['accessLevel']."! ";
}   
else 
{
    //If not the user cannot view the page in full
    header("Location: ../html/index.html? no_access");
    exit(0);
}

$previous = "javascript:history.go(-1)" ?? "";
if ($userNameToUpdate == "") //If field is empty
{
    header("Location: $previous?no_student"); //No student has been found
    exit (0);
}

include "connect.php";
//SQL - update users and set relevant data where the userName is equal to the user selected

$sql = "UPDATE users SET 
                    fullName = '$fullName', 
                    accessLevel = '$accessLevel'
                    WHERE userName = '$userNameToUpdate'";
                    
//If database has recieived the query

if (mysqli_query($link, $sql))
	{
		echo "success";
		header("Location: manageUsersForm.php? message=update success."); //update successful
	}
	else 
		{
            echo "failed";
            header("Location: manageUsersForm.php? message=deletion failed."); //update failed
		}

?>

<body>

</body>
</html>