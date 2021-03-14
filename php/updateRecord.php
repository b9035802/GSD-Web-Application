<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<?php
$studentIdToUpdate = $_POST['studentIdToUpdate'];
$update = $_POST['update'];
$studentName = $_POST['studentName'];
$studentDOB = $_POST['studentDOB'];
$studentAddress = $_POST['studentAddress'];
$parentName = $_POST['parentName'];
$parentEmail = $_POST['parentEmail'];
$parentPhone = $_POST['parentPhone'];
$studentMedical = $_POST['studentMedical'];


include "connect.php";

$sql = "UPDATE students SET 
                    studentName = '$studentName', 
                    studentDOB = '$studentDOB',
                    studentAddress = '$studentAddress',
                    parentName = '$parentName',
                    parentEmail = '$parentEmail',
                    parentPhone = '$parentPhone',
                    studentMedical = '$studentMedical'
                    WHERE studentNum = '$studentIdToUpdate'";
echo $sql;
if (mysqli_query($link, $sql))
	{
		echo "success";
		header("Location: databaseManagment.php? message=update success.");
	}
	else 
		{
            echo "failed";
            header("Location: databaseManagment.php? message=deletion failed.");
		}

?>

<body>

</body>
</html>