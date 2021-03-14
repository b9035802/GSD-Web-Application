<?php

session_start();


if ($_SESSION['valid'] ?? "")
    {
        //If the cookie is validated by a user/coach signing in, welcome them back to the page
        //echo "Welcome back ".$_SESSION["User"].", Access Level: ".$_SESSION['accessLevel']."! ";
    }   
else 
    {  
        //If not the user cannot view the page in full, send them back to home with noaccess
        header("Location: ../html/index.html? no_access");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Create New User</title>
</head>

<?php

session_start();
//Checks if the cookie is true, welcomes back user
if (($_SESSION['valid'] ?? "") && ($_SESSION['accessLevel'] == 2) ?? "")
    {
        //If the cookie is validated by a user/coach signing in, welcome them back to the page
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

//Instantiate POST method variables and set field to empty primitive if null

$fullName = $_POST['fullName'] ?? "";
$accessLevel = $_POST['accessLevel'] ?? "";

//New variable declaration 

$userName = "";
$password = "";
$resetPass = true;

//Variable for previous form post retrieval

$previous = "javascript:history.go(-1)" ?? "";

//Split string and remove whitespace from fullName and set new string to new userName

$arr = explode(' ',trim($fullName));
$userName= $arr[0];

//Variable declaration for new user creation

$characters = " 012345678910abcdefghihklmnopqrstuvwxyzABCDEFHIJKLMNOPQRSTUVWXYZ";
$numbers = "1234567890";
$min = 0;
$max = strlen($characters); //Get string length of characters
$max2 = strlen($numbers); //Get string length of numbers

//For (the password distinction being less than 12 characters) 

for($i = 0; $i <12; $i++)
{
    $randNum = rand($min,$max); //Generate a random int (max iteration length 12)
    $password .= $characters[$randNum]; //Concatonate password to equal random set if ints and characters
}

//For (the username disticntion being less than 4 characters)

for($i = 0; $i<4; $i++)
{
    $randNum = rand($min,$max2); //Generate a random int (max iteration length 4)
    $userName .= $numbers[$randNum]; //Concatonate username to equal random set if ints and characters
}

//utilsie PHP pre-isntalled library to encrypt new password created via a password hash

$pwoptions   = ['cost' => 8,];
$passhash    = password_hash($password, PASSWORD_BCRYPT, $pwoptions);

//SQL - insert users data into users field 

$sql = "INSERT INTO users (userName, userPass, fullName, accessLevel, resetPassword) VALUES ('$userName','$passhash','$fullName','$accessLevel','$resetPass')";

//If database query has been recieived

if (mysqli_query($link, $sql))
{
    ?>
    <form id= "newUserForm" action="manageUsersForm.php?newUser=success" method="post" enctype="multipart/form-data">
        <input name="password" type="hidden" value="<?php echo $password; ?>"> <!--echo password to form-->
        <input name="userName" type="hidden" value="<?php echo $userName; ?>"> <!--echo username to form-->
    </form>
    <script>
        document.getElementById("newUserForm").submit(); //Submit the newUserForm 
    </script>
    <?php
}
else {
    Header("Location: manageUsersForm.php?newUser=failed"); } //If manage users cannot be found
?>
<body>
</body>
</html>