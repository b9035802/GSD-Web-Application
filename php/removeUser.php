<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<?php

session_start();

//Instantiate new POST methods and set field to empty primitive if null

$delete = $_POST['delete'] ?? "";
$previous = "javascript:history.go(-1)" ?? "";
$userNameToRemove = $_POST['userNameToRemove'] ?? "";


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

//Extend thread on connect.php

include "connect.php";

if ($userNameToRemove == "") //If variable is empty/null
{
    header("Location: $previous?no_student"); //no student found
    exit (0);
}

//SQL - delete from users where userName is equal to the name being removed

$sql = "DELETE FROM users WHERE userName = '$userNameToRemove'";

//If database recieves query

if (mysqli_query($link, $sql))
	{
		echo "success";
		header('Location: manageUsersForm.php? message=deletion success'); //message deletion success
	}
	else 
		{
            echo "failed";
            header("Location: manageUsersForm.php? message=deletion failed.$userNameToRemove"); //message deletion not successful
		}
?>

<body>
</body>
</html>