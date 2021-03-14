<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sign Up</title>
    <link rel="icon" type="image/x-icon" href="../images/logoCOMP.png"/>
</head>


<?php
    include "connect.php";
    session_start();

    //Instantiate new POST methods and set field to empty primitive if null

    $user = $_POST['username'] ?? "";
    $pass = $_POST['password'] ?? "";
    $passConfirm = $_POST['password2'] ?? "";
    $signUpKey = $_POST['signUpKey'] ?? "";

    if ($user == "" || $pass == "" || $passConfirm == "" || $signUpKey == "") //If the fields are empty/null
    {
        header("Location: loginForm.php?invaliddetails"); //Invalid details
        exit (0);
    }
    if(strpbrk($user, ';:"=-+/_%*&|\'')) //If splitted string username contains any of the given characters
    {
        header("Location: signUpForm.php?invalidcharacters");
        exit (0);
    }
    if(strpbrk($pass, ';:"=-+/_%*&|\'')) //If splitted string password contains any of the given characters
    {
        header("Location: signUpForm.php?invalidcharacters");
        exit (0);
    }
    if(strpbrk($passConfirm, ';:"=-+_%/*&|\'')) //If splitted passconfirm username contains any of the given characters
    {
        header("Location: signUpForm.php?invalidcharacters");
        exit (0);
    }
    if(strpbrk($signUpKey, ';:"=-+/_%*&|\'')) //If splitted string signupkey contains any of the given characters
    {
        header("Location: signUpForm.php?invalidcharacters");
        exit (0);
    }

    //SQL - select all from userKey

    $sql = "SELECT * FROM userKey";
    $result = mysqli_query($link, $sql);

    if($result) //if true
    {
        echo "result = true";
    }
    if(false===$result) //If false
    {
        printf("error: %s\n", mysqli_error($link)); //print SQL error query
    }
    
    $created = false;
    $counter = 1;
    $key = "";
    while($row=mysqli_fetch_row($result))
    {
        $storedKey = $row[0];
        
        if(password_verify($signUpKey,$storedKey)) //If passwords match the hashed password
        {
            //access level 1

            //SQL - insert relevant data into users

            $sql = "INSERT into users(userName,userPass,accessLevel) VALUES('$user','$pass',1)";
            if (mysqli_query($link, $sql))
            {
                header("Location: signUpForm.php? message=signup success"); //sign up success
                $created = true; //true
                break;
                
            }
            else 
            {
                header("Location: signUpForm.php? message=signup failed");
                       
            }

        }
        $counter++;//keeps track of which row loop is on
    }
    if(!$created) //If not true
    {
        header("Location: signUpForm.php? message=signup failed"); //sign uyp failed

    }

    
?>

<body>
</body>
</html>