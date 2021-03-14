<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Page Title</title>
</head>

<?php
session_start();

if ($_SESSION['valid'] ?? "")
    {
        //If the cookie is validated by a user/coach signing in, welcome them back to the page
        //echo "Welcome back ".$_SESSION["User"].", Access Level: ".$_SESSION['accessLevel']."! ";
    }   
else {  
    //If not the user cannot view the page in full, send them back to home with noaccess
    header("Location: ../../html/index.html? no_access");
    exit(0);
}

//Instantaite new POST method variables in relation to the database to add a student to a class 

$studentNum = $_POST['studentIdToTest'] ?? "";
$classId = $_POST['classIdToRegister'] ?? "";

$numOfObjective = 0;

//$classId = str_replace($classId,"\"","")

//switch case for the value of classID, if the classID is equal to a certain number, display relevant objectives

$classId = (int)$classId;

switch ($classId) {
    case 1:
        $numOfObjective = 13; //If classID is 1
        break;
    case 2:
        $numOfObjective = 10; //If classID is 2
        break;
    case 3:
        $numOfObjective = 9; //If classID is 3
        break;
    case 4:
        $numOfObjective = 13; //If classID is 4
        break;
    case 5:
        $numOfObjective = 12; //If classID is 5
        break;
    case 6:
        $numOfObjective = 11; //If classID is 6
        break;
    case 7:
        $numOfObjective = 10; //If classID is 7
        break;
    default:
        break;
}

$objectives = [];

for ($i= 0; $i < $numOfObjective; $i++) // loop through number of tests
{
    $testPassFail = $_POST['test'.$i] ?? "";
   
    array_push($objectives,$testPassFail); //push elements on the end of the array (objectives and testPassFail)
}

$passed = true; // Define passed with no default or false and set it as true if criteria is met

for ($i= 0; $i < count($objectives); $i++) //
{
    if ($objectives[$i] == '0') // if test returned a zero
    {
        $passed = false;
        //break;
    } // after this loop, GOTO the else right away, skipping the if-else loop on line 74 entirely
}


//Extend thread to connect.php

include "../connect.php";

$newClassId = 0;

if($passed)  //If the test has been passed, increment the classID
{
    if ($classId < 7) 
    {
        $newClassId = $classId+1;
    }
    else 
    {
        //SQL - Insert Student data into Student archive once posted

        $sqlArchive = "INSERT INTO archivestudents (studentNum, studentName, studentDOB, studentAddress, parentName, parentEmail, parentPhone, studentMedical) SELECT studentNum, studentName, studentDOB, studentAddress, parentName, parentEmail, parentPhone, studentMedical FROM students WHERE studentNum = '$studentNum'"; 

        if (mysqli_query($link, $sqlArchive)) 
        {
            //SQL - Delete data from classmember if studentNum is true

            $sqlDelete1 = "DELETE FROM classmember WHERE studentNum = '$studentNum'";
            if (mysqli_query($link, $sqlDelete1)) 
            {
                //SQL - Delete data from students if studentNum is true

                $sqlDelete2 = "DELETE FROM students WHERE studentNum = '$studentNum'";
                if (mysqli_query($link, $sqlDelete2)) 
                {
                    header("Location: ../conductTestForm.php?success!student=archived");
                    exit(0); //exit method
                }
                else 
                {
                    header("Location: ../conductTestForm.php?sqldelete=failed");
                    exit(0); //exit method
                }
            }
            else 
            {
                header("Location: ../conductTestForm.php?sqldelete=failed");
                exit(0); //exit method
            }
        }
        else 
        {
            header("Location: ../conductTestForm.php?sqlinsert=failed");
            exit(0); //exit method
        }
    }

    //SQL - Update classmember and set the classID to the value of newClassID where studentNum is true 

    $sql = "UPDATE classmember SET classId = '$newClassId' WHERE studentNum = '$studentNum'";

    //If database has recieved query
 
    if (mysqli_query($link, $sql)) 
    {
        echo "success"; //success
		header("Location: ../conductTestForm.php? student=passed");
    }
    else 
    {
        echo "failed"; //failed
		header("Location: ../conductTestForm.php? sqlupdate=failed");
    }
    // Move them up a group
}
else
{
    header("Location: ../conductTestForm.php? student=failed");
    // Send a message to the coach/admin to say they failed
}

?>
    <body>
            <form id="formToSubmit" action="" method="post" onsubmit="">
                <input type="hidden" name="studentIdToTest" value="<?php echo $studentNum;?>">
                <input type="hidden" name="classId" value="<?php echo $classId; ?>">
            </form>
            <script>
                //document.getElementById("formToSubmit").submit();
            </script>
    </body>
   


</html>