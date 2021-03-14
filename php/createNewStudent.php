<?php

session_start();

if ($_SESSION['valid'] ?? "")
    {
        //If the cookie is validated by a user/coach signing in, welcome them back to the page
        //echo "Welcome back ".$_SESSION["User"].", Access Level: ".$_SESSION['accessLevel']."! ";
    }   
else {  
    //If not the user cannot view the page in full, send them back to home with noaccess
    header("Location: ../html/index.html? no_access");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Create New Student</title>
</head>

<?php

session_start();
//Checks if the cookie is true, welcomes back user
if (($_SESSION['valid'] ?? "") && ($_SESSION['accessLevel'] == 2) ?? "")
    {
        echo "Welcome back ".$_SESSION["User"].",  Access Level: ".$_SESSION['accessLevel'];
    }   
else 
    {
        //If not the user cannot view the page in full
        header("Location: ../html/index.html? no_access");
        exit(0);
    }

//Extend thread on connect.php

include "connect.php";

//Instantiate POST method variables and leave an empty primitive in the field if null

$studentNum = $_POST['studentNum'] ?? "";
$studentName = $_POST['studentName'] ?? "";
$studentDOB = $_POST['studentDOB'] ?? "";
$studentAddress = $_POST['studentAddress'] ?? "";
$parentName = $_POST['parentName'] ?? "";
$parentEmail = $_POST['parentEmail'] ?? "";
$parentPhone = $_POST['parentPhone'] ?? "";
$studentMedical = $_POST['studentMedical'] ?? "";
$previous = "javascript:history.go(-1)" ?? "";

//If studentNum is empty

if ($studentNum == "") 
{
    header("Location: $previous? no_class"); //No class found
    exit (0);
}

//header("Location: databaseManagment.php? message=values received.$studentNum.$studentName.$studentDOB.$studentAddress.$parentName.$parentEmail.$parentPhone.$studentMedical");

//SQL - Insert student data into students record

$sql = "INSERT INTO students(studentNum,studentName,studentDOB,studentAddress,parentName,parentEmail,parentPhone,studentMedical) 
                    VALUES('$studentNum','$studentName','$studentDOB','$studentAddress','$parentName','$parentEmail','$parentPhone','$studentMedical')";

//if database query is recieved

if (mysqli_query($link, $sql))
	{
		echo "success";
		header("Location: databaseManagment.php? message=update success.$studentNum"); //student record has been updated successfully
	}
else 
    {
        echo "failed";
        header("Location: databaseManagment.php? message=deletion failed.$studentNum"); //student record has not been updated successfully
    }


?>

<body>
</body>
</html>
