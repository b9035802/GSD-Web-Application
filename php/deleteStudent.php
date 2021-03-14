<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<?php

    session_start();

    //Instantaite new POST method variables in relation to the database to add a student to a class but set primitive to empty if null

    $studentIdToDelete = $_POST['studentIdToDelete'] ?? "";
    $archived = $_POST['archived'] ?? "";
    $delete = $_POST['delete'] ?? "";

    

    //Variable for previous instance of javascript, reload previous action made

    $previous = "javascript:history.go(-1)" ?? "";

    //Extend thread with connect.php

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

    //If field is empty

    if ($studentIdToDelete == "") 
    {
        header("Location: $previous?no_student"); //no student found
        exit (0);
    }

    $sqlClass = "";
    $sqlDelete = "";
    $sqlAttendance = "";

    //If student is archived

    
    if($archived == "true") 
    {
        $sqlDelete = "DELETE FROM archiveStudents WHERE studentNum = '$studentIdToDelete'"; //Delete field from archive students where studentNum is equal to user being deleted
    }

    //If not

    if($archived == "false")
    {
        $sql = "SELECT classId FROM classmember WHERE studentNum = '$studentIdToDelete'";//get class number of student
        $result = mysqli_query($link, $sql);
        $classId ="";
        while ($row=mysqli_fetch_row($result)) 
        {
            $classId=$row[0];
        }
        $sqlClass = "DELETE FROM classmember WHERE studentNum = '$studentIdToDelete' AND classId ='$classId'"; // must remove from class
        $sqlDelete = "DELETE FROM students WHERE studentNum = '$studentIdToDelete'"; //Delete field from students where studentNum is equal to user being deleted
        $sqlAttendance = "DELETE FROM attendance WHERE studentNum = '$studentIdToDelete'";
    }
    else if($studentIdToDelete ="")
    {
        header("Location: $previous?no_student"); //No student found
        exit (0);
    }
    $success = false;
    $success2 = false;

    //If database recieves query
    if ($archived == "false") 
    {
        if(mysqli_query($link, $sqlClass))
        {
            if (mysqli_query($link, $sqlDelete))
            {
                $success = true;
            }
            else 
            {
                $success = false;
            }
            
            if (mysqli_query($link, $sqlAttendance))
            {
                $success2 = true;
            }
            else 
            {
                $success2 = false;
            }

            if($success && $success2)
            {
                header('Location: databaseManagment.php? message=deletion success'); //Deletion success
            }
            else 
            {
                header("Location: databaseManagment.php? message=deletion from database failed.$studentIdToDelete"); //Deletion failed for (student)
            }
        }
        else 
        {
            echo "failed";
            header("Location: databaseManagment.php? message=deletion from class failed.$studentIdToDelete"); //Deletion failed for (student)
        }
    }
    else if ($archived == "true")
    {
        
        if (mysqli_query($link, $sqlDelete))
            {
                echo "success";
                header('Location: databaseManagment.php? message=deletion success'); //Deletion success
            }
        else 
        {
            echo "failed";
            header("Location: databaseManagment.php? message=deletion from database failed.$studentIdToDelete"); //Deletion failed for (student)
        }
        
    }
?>

<body>
</body>
</html>