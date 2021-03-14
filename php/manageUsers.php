<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<?php

session_start();
include "connect.php";


if (($_SESSION['valid'] ?? "") && ($_SESSION['accessLevel'] == 2) ?? "")
    {
        echo "Welcome back ".$_SESSION["User"].",  Access Level: ".$_SESSION['accessLevel'];
    }   
else {
    //If not the user cannot view the page in full
    header("Location: ../html/index.html? no_access");
}



$key = "";
$characters = " 0123456789abcdefghihklmnopqrstuvwxyzABCDEFHIJKLMNOPQRSTUVWXYZ!@$.?,+"; // Could this be cleaned up to 0...1,a...z,A...Z etc.?

$min = 0;
$max = strlen($characters);


for($i = 0; $i <20; $i++)
{
    
    $randNum = rand($min,$max);
    $key .= $characters[$randNum]; 
    
}

$pwoptions  = ['cost' => 8,];
$keyHash  = password_hash($key, PASSWORD_BCRYPT, $pwoptions);


$sql = "INSERT INTO userKey(numKey) VALUES('$keyHash')";

if (mysqli_query($link, $sql))
	{
        
        ?>
            
        <div class="form">
            <form id="keySubmit" action="manageUsersForm.php" method="POST">
                <input type="hidden" name="key" value="<?php echo $key ?>">
            </form>
        </div>
        <script>
           document.getElementById("keySubmit").submit();
        </script>


        <?php
	}
    else 
    {
        header("Location: manageUsersForm.php? message=key creation failed");
        echo "failed ".$key;
        echo "\n\n\n\n";
        echo $keyHash;
    }
    
    
    ?>

<body>
</body>
</html>
