<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<?php

$studentIdToDelete = $_POST['studentIdToDelete'];
$delete = $_POST['delete'];

include "connect.php";

$sql = "DELETE FROM students WHERE studentNum = '$studentIdToDelete'";

if (mysqli_query($link, $sql))
	{
		echo "success";
		header('Location: databaseManagment.php? message=deletion success');
	}
	else 
		{
            echo "failed";
            header("Location: databaseManagment.php? message=deletion failed.$studentIdToDelete");
		}
?>

<body>
</body>
</html>
