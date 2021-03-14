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
$classId = $_POST['classId'] ?? "";

//Empty variable 

$destination = "";

//If classID is equal to a switch case option, retrieve relevant php file post form submission

switch ($classId) {
    case '1':
        $destination = "level1Test.php"; //level 1
        break;
    case '2':
        $destination = "level2Test.php"; //level 2
        break;
    case '3':
        $destination = "level3Test.php"; //level 3
        break;
    case '4':
        $destination = "level4Test.php"; //level 4
        break;
    case '5':
        $destination = "level5Test.php"; //level 5
        break;
    case '6':
        $destination = "level6Test.php"; //level 6
        break;
    case '7':
        $destination = "level7Test.php"; //level 7
        break;
    default:
        # code...
        break;
}
?>
    <body>
            <form id="formToSubmit" action="<?php echo $destination;?>" method="post" onsubmit="">
                <input type="hidden" name="studentIdToTest" value="<?php echo $studentNum;?>">
                <input type="hidden" name="classId" value="<?php echo $classId; ?>">
            </form>
            <script>
                document.getElementById("formToSubmit").submit(); //Submit response to form and post onsubmit
            </script>
    </body>
   


</html>