<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Classes</title>
    <link rel="stylesheet" href="../css/mobile.css"/>
    <link rel="stylesheet" href="../css/desktop.css" media="only screen and (min-width : 720px)"/>
    <link rel="icon" type="image/x-icon" href="../images/logoCOMP.png"/>
</head>
<?php

session_start();

//Checks if the cookie is true

//if (isset($_GET['cookie']) && $_GET['cookie'] == "true")

if (($_SESSION['valid'] ?? "") && (($_SESSION['accessLevel'] == 1 ?? "") || ($_SESSION['accessLevel'] > 1 ?? "")))
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

?>
<body>
    <div class="container">
        <header>
            <!--logo-->
            <div class="logo">
                <!--image logo will go here-->
                <img src="../images/logoCOMP.png" alt="Dronfield Swimming Club Logo" />
            </div>
            <!--login-->
            <div class="loginLink">
                <ul>
                    <li>
                    <a href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
            <!--burger menu-->
            <div class="burgerMenu">
                <div class="bars">
                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3"></div>
                </div>
            </div>
        </header>
        <!--navigation header at top of page-->
        <nav class="mainNav">
            <div class="row">
                <ul>
                    <li><a href="securehomepage.php">Home</a></li>
                    <li><a href="classes.php">Classes</a></li>
                    <li><a href="conductTestForm.php">Conduct a Test</a></li>
                    <?php

                    //If the access level of the current session is equal to 2, grant access to the database management system, exclusivisty for coaches

                    $accessLevel = $_SESSION['accessLevel'] ?? "";

                    //If session is valid

                    if ($accessLevel == 2)  
                    {
                        ?>
                        <li><a href="databaseManagment.php">Manage Members</a></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </nav>
        <!--the main content for the site-->
        <main>
            <div class="mainContent">
                <!--content goes here-->
                <h1 class="siteTitle">Dronfield Swimming Club | Classes </h1>
                <!--Here is the student records form which will execute the php script-->

                <?php

                //Initialise link to database in 'connect.php'

                include "connect.php";

                //SQL - Retreiving Class data and order then by class ID ascending order (30 max)

                $sql = "SELECT * FROM  `Classes` ORDER BY  `classId` ASC LIMIT 0 , 30";
                $result = mysqli_query($link, $sql);
                $classId = 0;
                $studentNum = "";

                //echo $_GET['message'];
                //Student table
                echo "<br>";
                echo "<table class= 'table'>";
                echo "<tr>";
                $counter=0;

                //Whilst recieiving data from the result, order and update data appropriately dependent on the users input

                while ($row=mysqli_fetch_row($result)) 
                {	

                    $datetime =strtotime($row[2]); //Parse the time (3rd postion of data) in row array to new datetime varible
                    $time = date('H:i',$datetime); //Cast datetime to date variable

                    $counter++;
              
                    echo "<td id=member".$counter." onclick='OpenRows(this.id)' class='topRow'><span style='font-weight:bold'>Class Number: </span><br/>". $row[0]. "</td>";
                    echo "<td id=member".$counter." onclick='OpenRows(this.id)' class='topRow'><span style='font-weight:bold'>Day: </span><br/>". $row[1]. "</td>";
                    echo "<td id=member".$counter." onclick='OpenRows(this.id)' class='topRow'><span style='font-weight:bold'>Time: </span><br/>". $time. "</td>";
                    echo "<td id=member".$counter." onclick='OpenRows(this.id)' class='topRow'><span style='font-weight:bold'>Staff: </span><br/>". $row[3]. "</td>";
                    echo "</tr>";
                    $classId = $row[0]; 

                    //Post repsonses to accept a request to update the class or register a new class after form onsumbmitted

                    echo "</tr>";
                        echo "<td id=member".$counter." class='tableRow hidden' colspan='1'>";
                        ?>
                        <form action="updateClassForm.php" method="post" onsubmit="">
                            <input type="hidden" name="classToUpdate" value="<?php echo $classId; ?>">
                            <input type="submit" name="editClass" value="Update" class="updateClassButton2">
                        </form>
                        </td>
                        <?php
                            echo "<td id=member".$counter." class='tableRow hidden' colspan='2'>";
                        ?>
                            
                            <form action="displayAttendanceForm.php" method="post" onsubmit="">
                                <input type="hidden" name="classIdForAttendance" value="<?php echo $classId; ?>">
                                <input style= 'white-space: normal' type="submit" name="editClass" value="View Previous Attendance" class="updateClassButton2">
                            </form>
                            </td>
                        <?php
                        echo "<td id=member".$counter." class='tableRow hidden' colspan='1'>";
                        ?>

                        <form action="registrationForm.php" method="post" onsubmit="">
                            <input type="hidden" name="classToRegister" value="<?php echo $classId; ?>">
                            <input type="submit" name="registerClass" value="Register" class="registerClassButton">
                        </form>
                        </td>
                        </tr>
                        <?php                        
                        
                        echo "</tr>";

                    //SQL - Select the StundentNum where the classID is equal to the first row selected
                        
                    $sqlA = "SELECT studentNum FROM  classmember WHERE classId = '$classId'";
                    $resultA = mysqli_query($link, $sqlA);

                    //Whilst the result is true of the requested class
                    
                    while ($rowA=mysqli_fetch_row($resultA))
                    {	
                        echo "<tr id='member$counter' class='tableRow hidden'>";
                        echo "<td style='display: none' class='classRecord' colspan='2'><span style='font-weight:bold'>Student Number: </span><br/>". $rowA[0]."</td>";
                        $studentNum = $rowA[0];

                        //SQL - Select studentName where the studentNum is equal to the first row selected
    
                        $sql2 = "SELECT studentName FROM  students WHERE studentNum = '$studentNum'";
                        $result2 = mysqli_query($link, $sql2);

                        //Whilst the result is true of the fecthed class, display appropriate data
                        
                        while ($row2=mysqli_fetch_row($result2))
                        {	
                            
                            echo "<td class='classRecord' colspan='4'><span style='font-weight:bold'>Student Name: </span><br />". $row2[0]."</td>"; //return relevant row
                            
                        }
                        echo "</tr>";
                    }
                    
                } 
            
                echo "</table>";
                    ?>
            </div>
        </main>
    </div>
    <footer>
        <div class="row">
            <address>
                Dronfield Sports Centre<br /> Dronfield<br /> Derbyshire<br /> S42 6NG
            </address>
        </div>
    </footer>
    <script src="../scripts/jquery-3.4.1.min.js"></script>
    <script src="../scripts/main.js"></script>
</body>
</html>