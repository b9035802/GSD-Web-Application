<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Page Title</title>
</head>

<?php

//Checks if the cookie is true, welcomes back user
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

//Initialise new POST methods and set the field to an empty primitive if null

$user = $_POST['username'] ?? "";
$pass = $_POST['password'] ?? "";
$passConfirm = $_POST['password2'] ?? "";
$signUpKey = $_POST['signUpKey'] ?? "";
$destination = $_POST['destination'] ?? "";

//If the data fields are empty 

if ($user == "" || $pass == "" || $passConfirm == "" || $signUpKey == "") 
{
    header("Location: loginForm.php?invaliddetails"); //Invalid details have been provided
    exit (0);
}

//utilsie PHP pre-isntalled library to encrypt new password created via a password hash

 $pwoptions   = ['cost' => 8,];
 $passhash    = password_hash($pass, PASSWORD_BCRYPT, $pwoptions);

 echo "<br />";
 echo $passhash;
 $pass = "";

 //If directory is equal to signUp

if($destination == "signUp")
{
    
    ?>
    <body>
            <form id="signUpForm" action="signUp.php" method="post" onsubmit="">
                <input type="hidden" name="username" value="<?php echo $user ?>"> <!--echo username-->
                <input type="hidden" name="password" value="<?php echo $passhash ?>"> <!--echo password-->
                <input type="hidden" name="signUpKey" value="<?php echo $signUpKey ?>"> <!--echo sign up key-->
            </form>
            <script>
                document.getElementById("signUpForm").submit(); //submit and POST the data to signup the user
            </script>
    </body>
    <?php
}

//If directory is equal to login

if($destination == "login")
{

    ?>
    <body>
            <form id="loginForm" action="login.php" method="post" onsubmit=""> 
                <input type="hidden" name="username" value="<?php echo $user ?>"> <!--echo username-->
                <input type="hidden" name="password" value="<?php echo $passhash ?>"> <!--echo password-->
            </form>
            <script>
                document.getElementById("loginForm").submit(); //submit and POST the data to login the user
            </script>
    </body>
    <?php
}

?>

</html>