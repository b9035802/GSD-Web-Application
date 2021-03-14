<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dronfield Swimming Club - Student Records</title>
    <link rel="stylesheet" href="../css/mobile.css">
    <link rel="stylesheet" href="../css/desktop.css" media="only screen and (min-width : 800px)"/>
    <link rel="icon" type="image/x-icon" href="../images/logoCOMP.png"/>
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
                    $accessLevel = $_SESSION['accessLevel'] ?? "";

                    //If session is valid

                    if ($accessLevel == 2)  // Access 1 is a coach, 2 is admin
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
                <h1 class="siteTitle">Dronfield Swimming Club | Student Records </h1>
                <!--Here is the student records form which will execute the php script-->

                <?php

                //Extend thread on connect.php

                include "connect.php";

                //SQL - select all data from students and order them by student name in ascending order

                $sql = "SELECT * FROM  `Students` ORDER BY  `studentName` ASC";

                //Set reuslt to new sql query

                $result = mysqli_query($link, $sql);

                //echo $_GET['message'];
                //Student table
                ?>

                <br>
                <div class= 'form'>

                <form class= 'managementButton' action='manageUsersForm.php' method='post' enctype='multipart/form-data'>
                <input class= 'newMemberbutton' type='submit' name='insert' value='Manage Users' required>
                </form>

                
                <form class='managementButton' action='newStudentForm.php' method='post' enctype='multipart/form-data'>
                <input class= 'newMemberbutton' type='submit' name='insert' value='Add New Student' required>
                </form>

                <br>
                
                <h2> Current Students:</h2>
                <br>
                <table class= 'table'>
                <tr>

                <?php
                $counter=0;

                //Whilst recieiving data from the result, order and update data appropriately dependent on the users input

                while ($row=mysqli_fetch_row($result))
                    {	
                        $date ="";
                        
                        if($row[8]== "")
                        {
                            $date="Never paid";
                        }
                        else 
                        {
                            $datetime =strtotime($row[8]); //parse row variable into datetuime variable
                            $date = date('d/M/Y',$datetime);

                        }
                        $counter++;
                        echo "<td colspan=2 id=member".$counter." onclick='OpenRows(this.id)' class='topRow'><span style='font-weight:bold;text-align:right'>Student Name: </span><span class='topRowRight'>". $row[1]."</span></td>";
                        
                        echo "</tr>";

                        //Display relevant data

                        echo "<tr id=member".$counter." class='tableRow hidden'>";
                        echo "<td><span style='font-weight:bold'>Student DOB: </span><br/>". $row[2]."</td>";
                        echo "<td><span style='font-weight:bold'>Student Number: </span><br/>". $row[0]. "</td>";
                        echo "</tr>";

                        echo "<tr id=member".$counter." class='tableRow hidden'>";
                        echo "<td><span style='font-weight:bold'>Parent Name: </span><br />". $row[4]."</td>";
                        echo "<td style='word-wrap: break-word'><span style='font-weight:bold'>Parent Email: </span><br />". $row[5]."</td>";
                        echo "</tr>";

                        echo "<tr id=member".$counter." class='tableRow hidden'>";
                        echo "<td><span style='font-weight:bold'>Phone No: </span><br />". $row[6]."</td>";
                        echo "<td><span style='font-weight:bold'>Address: </span><br />". $row[3]."</td>";
                        echo "</tr>";

                        echo "<tr id=member".$counter." class='tableRow hidden'>";
                        echo "<td colspan='2'><span style='font-weight:bold'>Date last paid: </span><br />". $date."</td>";
                        echo "</tr>";

                        echo "<tr id=member".$counter." class='tableRow hidden'>";
                        echo "<td colspan='2'><span style='font-weight:bold'>Medical Information: </span><br />". $row[7]."</td>";
                        echo "</tr>";

                        echo "<tr id=member".$counter." class='tableRow hidden'>";
                        echo "<td id=member".$counter." class='tableRow hidden'>";                //Rows from the database	
                        ?>

                            <form action="updateStudentForm.php" method="post" onsubmit="">
                                <input type="hidden" name="studentIdToUpdate" value="<?php echo $row[0]; ?>">
                                <input type="submit" name="update" value="Update" class="updateButton"> <!--if field wants to be updated-->
                            </form>

                        <?php
                        echo "</td>";
                        echo "<td class='tableRow'>";
                        ?>

                            <form action="deleteStudent.php" method="post" onsubmit="">
                                <input type="hidden" name="studentIdToDelete" value="<?php echo $row[0]; ?>">
                                <input type="hidden" name="archived" value="false">
                                <input type="submit" name="delete" value="Delete" class="deleteButton" onclick="return confirm('Are you sure?')"> <!--if field wants to be removed-->
                            </form>
                      
                        <?php
                        echo "</td>";
                        echo "</tr>";
                        echo "</form>";
                    }
                    //Form for insert function
                          
                echo "</table>";   
                echo "</div";
                ?>

                <br><br>
                <h2> Archived Students:</h2>
                <br>
                <table class= 'table'>
                <tr>

                <?php

                //SQL- select all data from archivestudents and order them by studentName in ascending order
                    
                $sql2 = "SELECT * FROM  `archivestudents` ORDER BY  `studentName` ASC";
                $result2 = mysqli_query($link, $sql2);
                
                $counter2=0;

                //Whilst recieiving data from the result, order and update data appropriately dependent on the users input

                while ($row=mysqli_fetch_row($result2))
                    {	
                        $datetime =strtotime($row[8]); //parse row variable into datetuime variable
                        $date = date('d/M/Y',$datetime);
                        $counter2++;
                        echo "<td colspan=2 id=2member".$counter2." onclick='OpenRows2(this.id)' class='topRow'><span style='font-weight:bold;text-align:right'>Student Name: </span><span class='topRowRight'>". $row[1]."</span></td>";
                        
                        echo "</tr>";

                        echo "<tr id=2member".$counter2." class='tableRow2 hidden'>";
                        echo "<td><span style='font-weight:bold'>Student DOB: </span><br/>". $row[2]."</td>";
                        echo "<td><span style='font-weight:bold'>Student Number: </span><br/>". $row[0]. "</td>";
                        echo "</tr>";

                        echo "<tr id=2member".$counter2." class='tableRow2 hidden'>";
                        echo "<td><span style='font-weight:bold'>Parent Name: </span><br />". $row[4]."</td>";
                        echo "<td><span style='font-weight:bold'>Parent Email: </span><br />". $row[5]."</td>";
                        echo "</tr>";

                        echo "<tr id=2member".$counter2." class='tableRow2 hidden'>";
                        echo "<td><span style='font-weight:bold'>Phone No: </span><br />". $row[6]."</td>";
                        echo "<td><span style='font-weight:bold'>Address: </span><br />". $row[3]."</td>";
                        echo "</tr>";

                        echo "<tr id=2member".$counter2." class='tableRow2 hidden'>";
                        echo "<td><span style='font-weight:bold'>Medical Information: </span><br />". $row[7]."</td>";
                        echo "<td><span style='font-weight:bold'>Date of archive: </span><br />". $date."</td>";
                        echo "</tr>";

                        echo "<tr id=2member".$counter2." class='tableRow2 hidden'>";
                        echo "<td colspan='2' id=2member".$counter2." class='tableRow2 hidden'>";                //Rows from the database	
                        ?>

                            <form action="deleteStudent.php" method="post" onsubmit="">
                                <input type="hidden" name="studentIdToDelete" value="<?php echo $row[0]; ?>">
                                <input type="hidden" name="archived" value="true">
                                <input type="submit" name="delete" value="Delete" class="deleteButton" onclick="return confirm('Are you sure?')">
                            </form>
                        <?php
                        echo "</td>";
                        echo "</tr>";
                        echo "</form>";
                    }
                    //Form for insert function
                          
                echo "</table>";   





                ?>
             </div>
        </main>
        <br/><br/>
    </div>
    <footer>
        <div class="row">
            <address>
                Dronfield Sports Centre<br /> Dronfield<br /> Derbyshire<br /> S42 6NG
            </address>
        </div>
    </footer>            
    
    <!--javaScript files will be executed here-->
    <script src="../scripts/jquery-3.4.1.min.js"></script>
    <script src="../scripts/main.js"></script>

</body>
</html>