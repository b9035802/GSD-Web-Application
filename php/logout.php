<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Page Title</title>
</head>

<?php
session_start();

//the session is no longer valid/ the user has been logged out

echo "Logged out ".$_SESSION["User"]."! ";

$valid = ($session['valid'] ?? ""); //set session to empty primitive if null

unset($valid); //unset value
ini_set($session ?? "", 0); //set the new value of session to either be null or 0
session_destroy();

header("Location: ../html/index.html?logout=true"); //logout has been successful
// exit(header())
?>

<body>
</body>
</html>