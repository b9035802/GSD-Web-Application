<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dronfield Swimming Club - Registration</title>
    <link rel="stylesheet" href="../css/mobile.css">
    <link rel="stylesheet" href="../css/desktop.css" media="only screen and (min-width : 800px)" />
    <link rel="icon" type="image/x-icon" href="../images/logoCOMP.png"/>
</head>
<?php

session_start();

//Checks if the cookie is true, welcomes back user
//if (isset($_GET['cookie']) && $_GET['cookie'] == "true")
if (($_SESSION['valid'] ?? "") && (($_SESSION['accessLevel'] == 1 ?? "") || ($_SESSION['accessLevel'] > 1 ?? "")))
    {
        //If the cookie is validated by a user/coach signing in, welcome them back to the page
        //echo "Welcome back ".($_SESSION["User"]?? "").",  Access Level: ".$_SESSION['accessLevel'];
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

        <main>
            <div class="mainContent">
                <!--content goes here-->
                <h1 class="siteTitle">Dronfield Swimming Club | Registration </h1>
                <!--Here is the student records form which will execute the php script-->
                <?php
                include "connect.php";

                //Instantiate new POST methods and set field to empty primitive if null

                $classToRegister = $_POST['classToRegister'] ?? "";
                $update = $_POST['update'] ?? "";

                ?>
                <script> console.info(<?php echo $classToRegister; ?>) </script>
                <?php

                $previous = "javascript:history.go(-1)" ?? "";
                if(empty($classToRegister))
                {
                    header("Location: $previous?no_classId"); //No student has been found
                    exit (0);
                }
                
                ?>
                
                <div class="form"> <!--Form for updating users-->
                  
                <?php
                //Student table
                $timeOfAttendance = date("Y-m-d 00:00:00");

                $studentNum = "";

                //SQL - select studentNum from classmember where classID is equal to the class currently being registered

                $sql = "SELECT studentNum FROM  classmember WHERE classId = '$classToRegister'";
                $result = mysqli_query($link, $sql);
                ?>
                
                <form action='register.php' method='post' enctype='multipart/form-data'>
                <?php
                echo "<table class= 'table'>";
                $counter=0;
                while ($row=mysqli_fetch_row($result))
                {	
                    $counter++;
                    echo "<tr class='tableRow'>";
                    echo "<td style='display: none' id=member".$counter." onclick='OpenRows(this.id)' class='topRow2'><span style='font-weight:bold'>Student Number: </span><br />". $row[0]."</td>";
                    $studentNum = $row[0];

                    //SQL - select studentName from students where studentNum is equal to student selected

                    $sql2 = "SELECT studentName FROM students WHERE studentNum = '$studentNum'";
                    $result2 = mysqli_query($link, $sql2);
                    
                    while ($row2=mysqli_fetch_row($result2))
                    {	
                        
                        
                        $checked = "";
                        $sqlCheck = "SELECT attendance FROM attendance WHERE classId = '$classToRegister' AND timeOfAttendance = '$timeOfAttendance' AND studentNum = '$studentNum'";
                        $resultCheck = mysqli_query($link, $sqlCheck);
                        
                        $values = mysqli_fetch_row($resultCheck);
                        $value = $values[0] ?? "";
                        
                        if ($value == 0)
                        {
                            $checked="";
                        }
                        else 
                        {
                            $checked="checked='true'";
                        }
                        
                        echo "<td id=member".$counter." class='topRow2'><span style='font-weight:bold'>Student Name: </span><br />". $row2[0]."</td>";
                        ?>
                        <td class='topRow2' style="width : 25% ">
                            <span style='font-weight:bold'> Present </span><br>
                            <input type="hidden" id="registerHidden" name="<?php echo $studentNum;?>" value="0">
                            <input type="checkbox" onclick="hideAbsent()" id="register" name="<?php echo $studentNum;?>" value="1" <?php echo $checked;?>>
                        
                        <?php
                        echo "</td>";
                        
                        echo "</tr>";
                        
                    }                     
                    
                }
                ?>
                <script>
                    function hideAbsent() //hide absent student if register checked
                    {
                        if(document.getElementById("register").checked) 
                        {
                            document.getElementById('registerHidden').disabled = true;
                        }
                        
                    }
                </script>
                <?php
                    echo "<input type='hidden' name='classIdToRegister' value='$classToRegister'>";
                ?>
                <br>
            </table>
            <br>
            <input class='updateClassbutton' type='submit' value='Submit Register' style="float: right">
                </form>

                <?php
                
                    $currentDate = date("Y-m-d 00:00:00");
                    $dateShouldPay1 = date("Y-01-01 00:00:00");
                    $dateShouldPay2 = date("Y-04-30 00:00:00");
                    $dateShouldPay3 = date("Y-09-30 00:00:00");
            
                    $dueDate = "";
                    $dateSet = false;

                    if (strtotime($currentDate) < strtotime($dateShouldPay3)) 
                    {
                        //if its between april and september due date should be april
                        $dueDate = $dateShouldPay2;
                    }
                    if (strtotime($currentDate) < strtotime($dateShouldPay2)) 
                    {
                        //if between january and april due date should be january
                        $dueDate = $dateShouldPay1;    
                                     
                    }
                    if (strtotime($currentDate) < strtotime($dateShouldPay1)) // 
                    {
                        //if later than september but in next year set due date as septmeber of the previous year
                        $dateSeconds = strtotime($dateShouldPay3);
                        $dateSeconds -= 31536000; // how many seconds in a year
                        $dueDate = date("Y-m-d 00:00:00",$dateSeconds);
                    }
                    
                    if(strtotime($currentDate) < strtotime(date("Y-12-31 00:00:00")) && strtotime($currentDate) < strtotime($dateShouldPay1))
                    {
                        // if later than september but same year set due date as septmeber of the current year
                        $dueDate = $dateShouldPay3;
                    }
                    
                    $diff = strtotime($currentDate)-strtotime($dueDate);
                    $diff = ($diff/86400);//gets the amount of days between the current date and the date should have paid
                    

                   
                    if($diff >= 21)
                    {
                        
                        $sqlHasPaid =  "SELECT students.studentNum, students.studentName, students.lastPaidDate, students.parentEmail, students.parentName FROM students 
                                        INNER JOIN classmember ON classmember.studentNum = students.studentNum 
                                        WHERE lastPaidDate <= '$dateShouldPay1' AND classmember.classId = '$classToRegister'";
                        
                        
                        
                        $resultPaid = mysqli_query($link, $sqlHasPaid);
                        
                        echo "<br><br>";
                        echo "<h2>These students have not yet paid membership: </h2>";
                        
                        
                        echo "<table class= 'table'>";
                        
                        
                        $dueDateFormat = date("01/01/Y");
                        $counter = 0;
                        while($row=mysqli_fetch_row($resultPaid)) // no $link needed
                        {
                            $counter++;
                            $studentName = $row[1];     
                            $parentEmail = $row[3];
                            $parentName = $row[4];
                            echo "<tr class='tableRow'>";
                            echo "<td class='topRow2'><span style='font-weight:bold'>Student Name: </span>". $studentName."</td>";

                            $message = "Dear $parentName %0D%0A%0D%0ARegarding memberships payments for $studentName %0D%0AYour membership payment was due on $dueDateFormat %0D%0ACould please pay this as soon as possible. %0D%0A%0D%0AKind Regards %0D%0ADronfield Swimming Club%0D%0A";

                            ?>
                            <td class='topRow2' style="width :50%">                                
                                <input class='emailSubmit' type="submit" style="float:right" target="_blank"

                                onclick="location.href='mailto:<?php echo $parentEmail ;?>?subject=Late Payment&body=<?php echo $message ;?>'" 
                                value="Send Reminder Email To Parent"/>
                        </td>
                        </tr>
                        <?php
                        }
                        ?>
                        </table>
                        <br>

                        
                        
                        <?php
                        
                    }
					?>
                

            </div>
        </div>
            
        </main> <!--Main body ends here-->
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
