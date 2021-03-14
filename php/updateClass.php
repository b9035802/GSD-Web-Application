<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<?php

session_start();

//Instantiate new POST methods and set field to empty primitive if null

$classToUpdate = $_POST['classToUpdate'] ?? "";
$update = $_POST['update'] ?? "";
$classDay = $_POST['classDay'] ?? "";
$classTime = $_POST['classTime'] ?? "";
$classStaff = $_POST['classStaff'] ?? "";
$previous = "javascript:history.go(-1)" ?? "";

//Extend thread on connect.php

include "connect.php";

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

if ($classToUpdate == "") //If the field is null/empty
{
    header("Location: $previous? no_class");
    exit (0);
}


//Split dateTimeFormat and indent null if true

$dateTimeFormat = strtotime($datetime ?? "");

//SQL - update classes and set relavnt data where the classID is equal to class selected

$sql = "UPDATE classes SET 
                    classDay = '$classDay', 
                    classTime = '0000-00-00 $classTime:00',
                    classStaff = '$classStaff'
                    WHERE classId = '$classToUpdate'";
                
                    if (mysqli_query($link, $sql))
                        {
                            echo "success";
                            header("Location: classes.php? message=success"); //message success
                        }
                    else 
                        {
                            echo "failed";
                            header("Location: classes.php? message=failed"); //message success
                        }

?>

<body>

</body>
</html>