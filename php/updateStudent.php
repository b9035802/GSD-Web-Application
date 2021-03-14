<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<?php

session_start();

//Instantiate new POST methods and set the primitive to empty if null

$studentIdToUpdate = $_POST['studentIdToUpdate'] ?? "";
$update = $_POST['update'] ?? "";
$studentName = $_POST['studentName'] ?? "";
$studentDOB = $_POST['studentDOB'] ?? "";
$studentAddress = $_POST['studentAddress'] ?? "";
$parentName = $_POST['parentName'] ?? "";
$parentEmail = $_POST['parentEmail'] ?? "";
$parentPhone = $_POST['parentPhone'] ?? "";
$lastPaidDate = $_POST['lastPaidDate'] ?? "";
$studentMedical = $_POST['studentMedical'] ?? "";
$previous = "javascript:history.go(-1)" ?? "";

//Extend thread on connect.php

include "connect.php";

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

if ($studentIdToUpdate == "") //If field empty/null
{
    header("Location: $previous?no_student");
    exit (0);
}

//SQL - update students with relevant updated data

$sql = "UPDATE students SET 
                    studentName = '$studentName', 
                    studentDOB = '$studentDOB',
                    studentAddress = '$studentAddress',
                    parentName = '$parentName',
                    parentEmail = '$parentEmail',
                    parentPhone = '$parentPhone',
                    studentMedical = '$studentMedical',
                    lastPaidDate = '$lastPaidDate'
                    WHERE studentNum = '$studentIdToUpdate'";

//If database recieves query

if (mysqli_query($link, $sql))
	{
		echo "success";
		header("Location: databaseManagment.php? message=update success."); //message update success
	}
	else 
		{
            echo "failed";
            header("Location: databaseManagment.php? message=deletion failed."); //message update failed
		}

?>

<body>

</body>
</html>