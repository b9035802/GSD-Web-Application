<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Student to Class List</title>
    <link rel="stylesheet" href="../css/mobile.css">
    <link rel="stylesheet" href="../css/desktop.css" media="only screen and (min-width : 800px)"/>
    <link rel="icon" type="image/x-icon" href="../images/logoCOMP.png"/>
</head>

<?php
session_start();
//Checks if the cookie is true, welcomes back user
if ($_SESSION['valid'] ?? "")
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
            <div class="logo">
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
                <h1 class="siteTitle">Dronfield Swimming Club | Add Student To Class </h1>
                <!--Here is the student records form which will execute the php script-->

                <?php

                //Initialise link to database in 'connect.php'

                include "connect.php";

                //SQL - Retreiving student data in database, descending value (30 max)

                $sql = "SELECT students.studentNum, students.studentName, classmember.classId FROM  Students LEFT OUTER JOIN classmember ON Students.studentNum = classmember.studentNum WHERE classId IS NULL ORDER BY  studentNum DESC LIMIT 0 , 30";
                $result = mysqli_query($link, $sql);

                $noData = false; //set noData to false
                
                $numOfRows = mysqli_num_rows($result) ?? 0; //database result casted to the num_rows query


                if($numOfRows == 0) 
                { 
                    //if no rows are return from database(no students that are not in a class)                    
                    $noData = true;
                }
                else if($numOfRows > 0)
                {
                    $noData = false;
                }                

                //echo $_GET['message'];
                //Student table
                echo "<br>
                <div class= 'form'>";
                
                echo "<table class= 'table'>";
                
                $counter=0;
                $classToUpdate = $_POST['classToUpdate'];

                //Event for every row in the table in which data is polymorphic - can be shown and hidden once clicked on, each time a record is added, the field list increases in the table
                //Once updated, data is then echoed back and updated in the database
                
                while ($row=mysqli_fetch_row($result))
                {	
                        
                        //Each time a row is added, modify exisiting variable and add amount present to a counter variable

                        echo "<tr>";
                        $studentToAdd = $row[0];
                        $counter++;
                        echo "<td id=member".$counter." onclick='OpenRows(this.id)' class='topRow'><span style='font-weight:bold'>Student Number: </span>". $row[0]. "</td>";
                        echo "<td id=member".$counter." onclick='OpenRows(this.id)' class='topRow'><span style='font-weight:bold'>Student Name: </span>". $row[1]. "</td>";
                        echo "</tr>";

                        echo "<tr id=member".$counter." class='tableRow hidden'>";
                        echo "<td colspan='2' id=member".$counter." class='tableRow hidden'>";                //Rows from the database	
                        ?>
                            <form  action="addStudentToClass.php" method="post" onsubmit="">
                                <input type="hidden" name="studentToAdd" value="<?php echo $studentToAdd; ?>">
                                <input type="hidden" name="classToUpdate" value="<?php echo "$classToUpdate"; ?>">
                                <input class="updateClassButton" type="submit" name="addStudent" value="Add Student To Class" class="updateButton">
                            </form>
                        <?php
                        echo "</td>";
                        
                        
                    }
                    //Form for insert function
                    
                    echo "</tr>";
                    
                    
                    
                echo "</table>";
                echo "</div";
                echo"<meta http-equiv='refresh' content='1'>";
                ?>
             </div>
                <?php
                if($noData) //If noData is true
                {
                ?>
                    <h2>All students are already in a class<h2>
                <?php
                }
                ?>
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