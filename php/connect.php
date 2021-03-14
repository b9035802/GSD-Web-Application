<?php
// Opens a text file if present and loads in the password as the first line
$password = "";
$file = fopen("D:\connect.txt","r"); // Consider removing this loop after development
while($line = fgets($file))
{
    $password = $line; //set password as (line)
}
fclose($file);

$link = mysqli_connect("localhost", "root", $password, "dronfield");
// Hide root and local names and passwords
// Establishes connection to created database on local root
if (!$link) {
    //echo "Error: Unable to connect to MySQL." . PHP_EOL;
    //echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL; //Debug
    //echo "Debugging error: " . mysqli_connect_error() . PHP_EOL; //Debug
    exit;
}