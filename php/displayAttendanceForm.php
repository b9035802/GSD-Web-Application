
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <!-- Viewport here -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Classes</title>
    <!-- attach styles here -->
    <link rel="stylesheet" href="../css/mobile.css"/>
    <link rel="stylesheet" href="../css/desktop.css" media="only screen and (min-width : 720px)"/>
    <link rel="icon" type="image/x-icon" href="../images/logoCOMP.png"/>
</head>
<?php

session_start();

//$secure = $_COOKIE("Secure");

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

                //Instantiate new POST method and set field to empty primitive if null

                $classId = $_POST['classIdForAttendance'] ?? "";

                $sql = "SELECT classId,timeOfAttendance FROM  attendance WHERE classId = '$classId' GROUP BY timeOfAttendance ORDER BY timeOfAttendance DESC LIMIT 0,52";
                $result = mysqli_query($link, $sql);
                $studentNum = "";

                //echo $_GET['message'];
                //Student table
                echo "<br>";
                echo "<table class= 'table'>";
                
                $counter=0;
                
                
                //Whilst recieiving data from the result, order and update data appropriately dependent on the users input
                
                $noData = false;
                if(mysqli_num_rows($result) == 0) 
                { 
                    //if no rows are return from database(no attendance has been taken for that class yet)
                    $noData = true; //there is attendence
                }
                else 
                {
                    $noData = false; //there is no attendence
                }
                
                while ($row=mysqli_fetch_row($result)) //If query has been recieved in database
                {	
                    
                    
                    $datetime =strtotime($row[1]); //parse row variable into datetuime variable
                    $date = date('d/M/Y',$datetime); //Instantiate new date variable which has passed in value of datetime variable
                    
                    $counter++; //increment 
                    
                    echo "<tr>";
                    
                    echo "<td colspan='2' id=member".$counter." onclick='OpenRows(this.id)' class='topRow'><span style='font-weight:bold'>Date: </span>". $date. "</td>";
                    echo "</tr>";
                     

                    //Post repsonses to accept a reques to update the class or register a new class

                    
                    
                        

                    //SQL - Select the StundentNum where the classID is equal to the first row selected
                    
                    
                    $sqlA = "SELECT studentNum, Attendance FROM attendance WHERE classId = '$classId' AND timeOfAttendance = '$row[1]'";


                    $resultA = mysqli_query($link, $sqlA);

                    //Whilst the result is true of the requested class
                    
                    while ($rowA=mysqli_fetch_row($resultA))
                    {	
                        echo "<tr id='member$counter' class='tableRow hidden'>";
                        
                        //SQL - Select studentName where the studentNum is equal to the first row selected
                        
                        $studentNum = $rowA[0];
                        $sql2 = "SELECT studentName FROM  students WHERE studentNum = '$studentNum'";
                        $result2 = mysqli_query($link, $sql2);
                        
                        //Whilst the result is true of the fecthed class, display appropriate data
                        
                        $counter2 = 0;
                        while ($row2=mysqli_fetch_row($result2))
                        {	
                            $counter2++;
                            $studentName = $row2[0];
                            echo "<td class='classRecord' colspan='1'><span style='font-weight:bold'>Student Name: </span><br />". $studentName."</td>";
                        }
                        if($counter2 == 0)
                        {
                            echo "<td class='classRecord' colspan='1'><span style='font-weight:bold'>Student Name: </span><br />Student no longer in club</td>";
                            $counter2 = 0;
                        }

                        $attendance = "";

                        //If the value returned from the query method is equal to 1

                        if ($rowA[1] == 1)
                        {
                            $attendance = "Present"; //That student is present in the class
                        }
                        else
                        {
                            $attendance = "Absent"; //That student is not present in the class
                        }
                        if($counter2 == 0)
                        {
                            $attendance = "null";
                            $counter2 = 0;
                        }
                        echo "<td class='classRecord' colspan='1'><span style='font-weight:bold'>Attendance: </span><br/>". $attendance."</td>"; //return the attendence for each class once displayed
                        echo "</tr>";
                    }
                    
                    
                } 
                
                echo "</table>";

                if($noData) //If no data is true
                {
                ?>
                    <h2>No registers have been taken for this class<h2>
                <?php
                }
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