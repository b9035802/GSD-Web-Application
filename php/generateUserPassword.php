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
        //echo "Welcome back ".$_SESSION["User"].",  Access Level: ".$_SESSION['accessLevel'];
    }   
else 
    {
        //If not the user cannot view the page in full
        header("Location: ../html/index.html? no_access");
        exit(0);
    }

//variable for previous method after form onsubmitted

$previous = "javascript:history.go(-1)" ?? "";

//Instantiate POST varaible to reser userName

$userName = $_POST['userNameToReset'] ?? "";

//If the userName is empty

if ($userName == "") 
{
    Header("Location: $previous?userId=false"); //the userID is false and cannot process method
    exit(0);
}

//Extend thread on connect.php

include "connect.php";

//Instantiate variables

$password = "";
$resetPass = true;
$characters = " 012345678910abcdefghihklmnopqrstuvwxyzABCDEFHIJKLMNOPQRSTUVWXYZ";
$min = 0;
$max = strlen($characters); //split characters string

//For password being less than 12 iterations

for($i = 0; $i <12; $i++)
{
    $randNum = rand($min,$max); //Generate a random int (max iteration length 12)
    $password .= $characters[$randNum]; //Concatonate password to equal random set if ints and characters
}

//utilsie PHP pre-isntalled library to encrypt new password created via a password hash

$pwoptions = ['cost' => 8,];
$passhash = password_hash($password, PASSWORD_BCRYPT, $pwoptions);

//SQL - update users and set the userPass to 1 (reset password) where the userName is equal to the user updated

$sql = "UPDATE users SET userPass = '$passhash', resetPassword = '1' WHERE userName = '$userName'";

//If the database has recieved the query

if (mysqli_query($link, $sql))
{
    
    ?>
    <form id= "newUserForm" action="updateUserForm.php?passwordReset=success" method="post" enctype="multipart/form-data">
        <input name="password" type="hidden" value="<?php echo $password; ?>"> 
        <input name="userName" type="hidden" value="<?php echo $userName; ?>"> 
        <input name="userNameToUpdate" type="hidden" value="<?php echo $userName; ?>"> 
    </form>
    <script>
        document.forms["newUserForm"].submit(); //submit and POST the user form to generate a password
    </script>
    <?php
}
else 
{
    Header("Location: updateUserForm.php?passwordReset=failed");  //if password reset failed
}
?>
<body>
</body>
</html>