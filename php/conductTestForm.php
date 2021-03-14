<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dronfield Swimming Club - Conduct a Test</title>
    <link rel="stylesheet" href="../css/mobile.css">
    <link rel="stylesheet" href="../css/desktop.css" media="only screen and (min-width : 720px)" />
    <link rel="icon" type="image/x-icon" href="../images/logoCOMP.png" />
</head>

<?php
session_start();
//Checks if the cookie is true, welcomes back user
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

                //Extend thread with connect.php

                include "connect.php";

                //SQL - Select student data and order byh classID

                $sql = "SELECT students.studentNum, students.studentName, classmember.classId FROM students INNER JOIN classmember ON students.studentNum = classmember.studentNum ORDER BY classId asc;";
                $result = mysqli_query($link, $sql);

                //echo $_GET['message'];
                //Student table
                
                echo "<br>";

                if(isset($_GET['student']) && $_GET['student'] == "passed") //If student field is not null and is value set to passed
                {
                    ?>
                    <h2 style="float:none">Student Passed Test</h2>
                    <?php
                }
                else if(isset($_GET['student']) && $_GET['student'] == "failed") //If student field is not null and is value set to failed
                {
                    ?>
                    <h2 style="float: none">Student Failed Test</h2> 
                    <?php
                }
                else if(isset($_GET['sql']) && ($_GET['sql']) == "failed") //SQL statement failed to process
                {
                    ?>
                    <h2 style="float: none">Student Passed, but SQL Failed. Please Change Student's Class in the Admin Page</h2> 
                    <?php
                }
                ?>

                <div class= 'form'>

                <br><br>
                <table class= 'table'>
                <tr>

                <?php
                $counter=0;

                //Whilst the fetch row query is true to result

                while ($row=mysqli_fetch_row($result))
                    {	
                        $num = $row[0] ?? ""; //set variable in row to an empty type 
                        $name = $row[1] ?? ""; //set variable in row to an empty type 
                        $level = $row[2] ?? ""; //set variable in row to an empty type 
                        
                        //if level is resulted to an empty type

                        if($level =="")
                        {
                            $level = "N/A"; 
                        }

                        $counter++; //Increment counter

                        echo "<td id=member".$counter." class='topRow1'><span style='font-weight:bold'>Student Name: </span><br/>". $row[1]. "</td>";
                        echo "<td id=member".$counter." class='topRow1'><span style='font-weight:bold'>Level: </span><br/>". $level. "</td>";
                        
                        echo "<td id=member".$counter." class='topRow1'>";                //Rows from the database	
                        ?>
                            <form action="TestForms/testRedirect.php" method="post" >
                                <input type="hidden" name="studentIdToTest" value="<?php echo $num; ?>">
                                <input type="hidden" name="classId" value="<?php echo $level; ?>">
                                <input type="submit" name="update" value="Test" class="updateButton">
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
    <script src="../scripts/jquery-3.4.1.min.js"></script>
    <script src="../scripts/main.js"></script>
</body>
</html>