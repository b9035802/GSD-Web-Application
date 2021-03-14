<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sign Up</title>
    <link rel="icon" type="image/x-icon" href="../images/logoCOMP.png"/>
</head>


<?php

    //Extend thread on connect.php

    session_start();
    
    //Instantiate new POST methods and set field to empty primitive if null
    
    $username = $_POST['userName'] ?? "";
    $password = $_POST['password'] ?? "";
    
    if ($username == "" || $password == "") //If fields are empty/null
    {
        header("Location: loginForm.php?invaliddetails"); //Invalid details 
        exit (0);
    }
    if(strpbrk($username, ';:"=-+/_%*&|\'')) //If splitted string username contains any of the given characters/symbols
    {
        header("Location: signUpForm.php?invalidcharacters"); //Invalid details 
        exit (0);
    }
    if(strpbrk($password, ';:"=-+/_%*&|\'')) //If splitted string password contains any of the given characters/symbols
    {
        header("Location: signUpForm.php?invalidcharacters"); //Invalid details 
        exit (0);
    }
    
    include "connect.php";
    //utilsie PHP pre-isntalled library to encrypt new password created via a password hash
    
    $pwoptions   = ['cost' => 8,];
    $passhash    = password_hash($password, PASSWORD_BCRYPT, $pwoptions);
    
    //SQL - update users and set userPass data where the userName is equal to the selected username

    $sql = "UPDATE users SET userPass = '$passhash', resetPassword = '0' WHERE userName = '$username'";
    $result = mysqli_query($link, $sql);

    if($result) //If result is true
    {
        header("location: securehomepage.php?session=true"); 
    }
    else 
    {
        header("location: logout.php");
    }
?>

<body>
</body>
</html>