<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Register</title>
</head>

<?php
    session_start();
    
    //Extend thread with connect.php
    include "../php/connect.php";

    if ($_SESSION['valid'] ?? "" && ($_SESSION['accessLevel'] == 2 ?? ""))
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

    //Instantiate POST method variables to the database

    $classId = $_POST['classIdToRegister'] ?? "";
   
    $studentNum = "";

    //SQL -

    $sql = "SELECT studentNum FROM  classmember WHERE classId = '$classId'";        // getting all student numbers from database where classId matches
    $result = mysqli_query($link, $sql);
    $numOfStudents = mysqli_num_rows($result);                                      // storing number of students from registration form
    $success = false;

    while ($row=mysqli_fetch_row($result))
    {	
        $studentNum = $row[0];
        $attendance = $_POST[$studentNum];
        
        $timeOfAttendance = date("Y-m-d 00:00:00");                                 // format current date
        $sqlCheck = "SELECT * FROM attendance WHERE classId = '$classId' AND timeOfAttendance = '$timeOfAttendance'";
        $resultCheck = mysqli_query($link, $sqlCheck);
        $numOfRows = mysqli_num_rows($resultCheck);                                 // number of rows returned is stored
        

        if ($numOfRows == $numOfStudents)                                           // if number of rows returned is the same as the number of students
        {
            while ($row=mysqli_fetch_row($resultCheck))                             // loops only if sql return fields
            {
                                                                                    // update student record
                $sqlUpdate = "UPDATE attendance SET
                                attendance = '$attendance'
                                WHERE studentNum = '$studentNum' AND classId = '$classId' AND timeOfAttendance = '$timeOfAttendance'";
                if (mysqli_query($link, $sqlUpdate))
                {
                    $success = true;
                }
            }
        }
        if ($numOfRows < $numOfStudents)                                            // if number of students is less than insert new record
        {
            $sqlInsert = "INSERT INTO attendance (classId, studentNum, timeOfAttendance, attendance) VALUES ('$classId', '$studentNum', '$timeOfAttendance', '$attendance')";
            if (mysqli_query($link, $sqlInsert))
            {
                $success = true;   
            }   
        }        
    }

    if($success)
    {
        header("Location: securehomepage.php?message=register+success"); //return success in header
    }
    else 
    {
        header("Location: securehomepage.php?message=register+failed"); //return failed in header
    }

    
    
?>