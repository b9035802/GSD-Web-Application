<?php

session_start();


if ($_SESSION['valid'])
    {
        echo "Welcome back ".$_COOKIE["User"].", Access Level: ".$_SESSION['accessLevel']."! ";
    }   
else {
    //If not the user cannot view the page in full
    die("Access to content denied") ;
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<?php

include "connect.php";

$studentNum = $_POST['studentNum'];
$studentName = $_POST['studentName'];
$studentDOB = $_POST['studentDOB'];
$studentAddress = $_POST['studentAddress'];
$parentName = $_POST['parentName'];
$parentEmail = $_POST['parentEmail'];
$parentPhone = $_POST['parentPhone'];
$studentMedical = $_POST['studentMedical'];

//header("Location: databaseManagment.php? message=values received.$studentNum.$studentName.$studentDOB.$studentAddress.$parentName.$parentEmail.$parentPhone.$studentMedical");

$sql = "INSERT INTO students(studentNum,studentName,studentDOB,studentAddress,parentName,parentEmail,parentPhone,studentMedical) 
                    VALUES('$studentNum','$studentName','$studentDOB','$studentAddress','$parentName','$parentEmail','$parentPhone','$studentMedical')";

if (mysqli_query($link, $sql))
	{
		echo "success";
		header("Location: databaseManagment.php? message=update success.$studentNum");
	}
	else 
		{
            echo "failed";
            header("Location: databaseManagment.php? message=deletion failed.$studentNum");
		}


?>

<body>
</body>
</html>
