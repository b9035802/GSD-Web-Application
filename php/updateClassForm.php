<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <!-- Viewport here -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Home</title>
    <!-- attach styles here -->
    <link rel="stylesheet" href="../css/mobile.css">
    <link rel="stylesheet" href="../css/desktop.css" media="only screen and (min-width : 800px)"/>
</head>
<?php

session_start();

//Checks if the cookie is true, welcomes back user
//if (isset($_GET['cookie']) && $_GET['cookie'] == "true")
if ($_SESSION['valid']?? "")
    {
        //If the cookie is validated by a user/coach signing in, welcome them back to the page
        //echo "Welcome back ".$_SESSION["User"].", Access Level: ".$_SESSION['accessLevel']."! ";
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
                 <h1 class="siteTitle">Dronfield Swimming Club | Update </h1>
                 <!--Here is the login form which will execute the php script-->

                 <?php

                    include "connect.php";

                    //Instantiate new POST methods and set the primitive to empty if null

                    $classToUpdate = $_POST['classToUpdate'] ?? "";
                    $update = $_POST['update'] ?? "";

                    ?>
                        <script> console.info(<?php echo $classToUpdate; ?>) </script>
                    <?php


                    if($classToUpdate == "")
                    {
                        $classToUpdate = $_GET['classToUpdate'] ?? ""; //Get current value of classtoupdate anfd set null
                        ?>
                        <script> console.info(<?php echo $classToUpdate; ?>) </script>
                        <?php
                    }

                    //SQL - select all from classes where the classID is the same to the class selected

                    $sql = "SELECT * FROM  classes WHERE classId = '$classToUpdate'";
                    $result = mysqli_query($link, $sql);
                    
                 ?>



                 <div class="form"> <!--Form for updating meeting-->
                 <h2>Update Class</h2>
                 <br><br>
                 <br><br>
                    <form action="updateClass.php" method="post" enctype="multipart/form-data">
                        <input name="classToUpdate" type="hidden" value="<?php echo $classToUpdate; ?>">
                        <label for="classDay">Day of the Week</label>
                            <select name="classDay" id="classDay">
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                            </select>
                        <label for="classTime">Time (24hr)</label>
                        <input type="time" id="classTime" name="classTime">
                        <label for="classStaff">Staff</label>
                        <input type="text" id="classStaff" name="classStaff">
                        <br><br>
                        <input type="submit" name="update" class="newMemberbutton">
                        <br><br>
                    </form>
                    
                    <script>
                        <?php

                        //Whilst the query has returned the relevant row response

                        while ($row=mysqli_fetch_row($result))
                        {	

                            $classDay = $row[1];
                            $classTime = $row[2];
                            $classStaff = $row[3];

                            //Parse and split string into new time variable

                            $datetime=strtotime($classTime);
                            $time=date('H:i',$datetime);

                            ?>
                            var temp;
                            var classDay = document.getElementById("classDay");
                            var i = 0;

                            for (i = 0; i < 7; i++) // seven days in a week
                            {
                                if(classDay[i].value == "<?php echo $classDay; ?>")
                                {
                                    classDay.selectedIndex = i;
                                    break;
                                }   
                            }
                            document.getElementById("classTime").defaultValue = "<?php echo $time; ?>" //echo the time 
                            document.getElementById("classStaff").defaultValue = "<?php echo $classStaff; ?>" //echo the class stuff
                        <?php 
                        } ?>
                    </script>
                 </div>

                 
                 <br>
                 <div class="form"> <!--Form for updating users-->
                 
                 <h2>Update Students</h2>
                 <?php
                 //Student table

                $studentNum = "";
                
                $sql = "SELECT studentNum FROM  classmember WHERE classId = '$classToUpdate'";
                $result = mysqli_query($link, $sql);
                
                ?>
                <br> 
                <?php
                echo "<table class= 'table'>";
                $counter=0;
                while ($row=mysqli_fetch_row($result))
                {	
                    $counter++;
                    echo "<tr class='tableRow'>";
                    echo "<td style='display: none' id=member".$counter." onclick='OpenRows(this.id)' class='topRow'><span style='font-weight:bold'>Student Number: </span><br />". $row[0]."</td>";
                    $studentNum = $row[0];
                    
                    $sql2 = "SELECT studentName FROM  students WHERE studentNum = '$studentNum'";
                    $result2 = mysqli_query($link, $sql2);
                    
                    while ($row2=mysqli_fetch_row($result2))
                    {	
                        
                        echo "<td colspan='2' id=member".$counter." onclick='OpenRows(this.id)' class='topRow'><span style='font-weight:bold'>Student Name: </span><br />". $row2[0]."</td>";
                        
                        echo "<tr id=member".$counter." class='tableRow hidden'>";
                        echo "<td colspan='2' id=member".$counter." class='tableRow hidden' colspan='2'>";                //Rows from the database	
                        ?>
                            <form action="removeStudentFromClass.php" method="post" onsubmit="">
                                <input type="hidden" name="studentIdToRemove" value="<?php echo $studentNum; ?>">
                                <input type="hidden" name="classToUpdate" value="<?php echo $classToUpdate; ?>">
                                <input type="submit" name="remove" value="Remove Student" class="newMemberbutton"  onclick="return confirm('Are you sure?')">
                            </form>
                            <?php
                        echo "</td>";
                        echo "</td>";
                        echo "</tr>";
                        
                    } 
                    
                    
                }
                echo "</form>";
                
                
                echo "</table>";
                ?>
                <br>
                <div style="padding-top: 0" class= "form">
                <form action="addStudentToClassList.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="classToUpdate" value="<?php echo $classToUpdate; ?>">
                <input class= "newMemberbutton" type="submit" name="insert" value="Add Student" required>
                </form>
                </div>
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
    <!--javaScript files will be executed here-->
    <script src="../scripts/jquery-3.4.1.min.js"></script>
    <script src="../scripts/main.js"></script>
</body>
</html>