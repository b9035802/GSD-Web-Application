<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dronfield Swimming Club - Registration</title>
    <link rel="stylesheet" href="../../css/mobile.css"/> <!--Ensure links to css etc. are ../../ (or ... in UNIX)--> 
    <link rel="stylesheet" href="../../css/desktop.css" media="only screen and (min-width : 800px)" />
    <link rel="icon" type="image/x-icon" href="../../images/logoCOMP.png"/>
</head>
<?php

session_start();


if (($_SESSION['valid'] ?? "") && (($_SESSION['accessLevel'] == 1 ?? "") || ($_SESSION['accessLevel'] > 1 ?? "")))
    {
        //If the cookie is validated by a user/coach signing in, welcome them back to the page
        //echo "Welcome back ".($_SESSION["User"]?? "").",  Access Level: ".$_SESSION['accessLevel'];
    }   
else {
    //If not the user cannot view the page in full
    header("Location: ../../html/index.html? no_access");
    exit(0);
}

//Instantaite new POST method variables in relation to the database to add a student to a class 

$studentNum = $_POST['studentIdToTest'] ?? "";
$classId = $_POST['classId'] ?? "";

$previous = "javascript:history.go(-1)" ?? "";
if ($studentNum == "" || $classId == "") //If field is empty
{
    header("Location: $previous?no_student"); //No student has been found
    exit (0);
}


?>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <!--image logo will go here-->
                <img src="../../images/logoCOMP.png" alt="Dronfield Swimming Club Logo" />
            </div>
            <!--login-->
            <div class="loginLink">
                <ul>
                    <li>
                    <a href="../logout.php">Logout</a>
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
                    <li><a href="../securehomepage.php">Home</a></li>
                    <li><a href="../classes.php">Classes</a></li>
                    <li><a href="../conductTestForm.php">Conduct a Test</a></li>
                    <?php
                    $accessLevel = $_SESSION['accessLevel'] ?? "";

                    //If session is valid

                    if ($accessLevel == 2)  // Access 1 is a coach, 2 is admin
                    {
                        ?>
                        <li><a href="../databaseManagment.php">Manage Members</a></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </nav>


        <main>
            <div class="mainContent">
                <!--content goes here-->
                <h1 class="siteTitle">Dronfield Swimming Club | Level 6 Test </h1>
                <!--Here is the student records form which will execute the php script-->
                <?php
                include "../connect.php";
                ?>


                <div class="form"> <!--Form for updating users-->
                
                <form action='processTest.php' method='post' enctype='multipart/form-data'>
                <table class= 'table'> 

                    <tr class='tableRow'>
                        <td>Test Condition:</td>
                        <td id='testTable' >Pass/Fail</td>
                    </tr>
                    <!-- ROW 1-->
                    <tr class='tableRow'>
                        <td>Demonstrate an understanding of preparation for excersise</td>
                        <td class='radioButton'>
                            <label for="pass">Pass</label>
                            <input type="radio" name="test0" value="1" required>
                            <label for="fail">Fail</label>
                            <input type="radio" name="test0" value="0">
                        </td>
                    </tr>
                    <!-- ROW 2-->
                    <tr class='tableRow'>
                        <td>Sink, push off on the side from the wall, glide, kick and rotate into backstroke</td>
                        <td class='radioButton'>
                            <label for="pass">Pass</label>
                            <input type="radio" name="test1" value="1" required>
                            <label for="fail">Fail</label>
                            <input type="radio" name="test1" value="0">
                        </td>
                    </tr>
                    <!-- ROW 3-->
                    <tr class='tableRow'>
                        <td>Sink, push off on the side from the wall, glide, kick and rotate into front crawl</td>
                        <td class='radioButton'>
                            <label for="pass">Pass</label>
                            <input type="radio" name="test2" value="1" required>
                            <label for="fail">Fail</label>
                            <input type="radio" name="test2" value="0">
                        </td>
                    </tr>
                    <!-- ROW 4-->
                    <tr class='tableRow'>
                        <td>Swim 10 metres wearing clothes</td>
                        <td class='radioButton'>
                            <label for="pass">Pass</label>
                            <input type="radio" name="test3" value="1" required>
                            <label for="fail">Fail</label>
                            <input type="radio" name="test3" value="0">
                        </td>
                    </tr>
                    <!-- ROW 5-->
                    <tr class='tableRow'>
                        <td>Swim front crawl to include at least six rhythmical breaths (refer to the ASA expected stroke standards sheet)</td>
                        <td class='radioButton'>
                            <label for="pass">Pass</label>
                            <input type="radio" name="test4" value="1" required>
                            <label for="fail">Fail</label>
                            <input type="radio" name="test4" value="0">
                        </td>
                    </tr>
                    <!-- ROW 6-->
                    <tr class='tableRow'>
                        <td>Swim breastroke to include at least six rhythmical breaths (refer to the ASA expected stroke standards sheet)</td>
                        <td class='radioButton'>
                            <label for="pass">Pass</label>
                            <input type="radio" name="test5" value="1" required>
                            <label for="fail">Fail</label>
                            <input type="radio" name="test5" value="0">
                        </td>
                    </tr>
                    <!-- ROW 7-->
                    <tr class='tableRow'>
                        <td>Swim butterfly to include at least six rhythmical breaths (refer to the ASA expected stroke standards sheet)</td>
                        <td class='radioButton'>
                            <label for="pass">Pass</label>
                            <input type="radio" name="test6" value="1" required>
                            <label for="fail">Fail</label>
                            <input type="radio" name="test6" value="0">
                        </td>
                    </tr>
                    <!-- ROW 8-->
                    <tr class='tableRow'>
                        <td>Swim 25 metres, choice of stroke is optional (refer to the ASA expected stroke standards sheet)</td>
                        <td class='radioButton'>
                            <label for="pass">Pass</label>
                            <input type="radio" name="test7" value="1" required>
                            <label for="fail">Fail</label>
                            <input type="radio" name="test7" value="0">
                        </td>
                    </tr>
                    <!-- ROW 9-->
                    <tr class='tableRow'>
                        <td>Perform a "shout and signal" rescue</td>
                        <td class='radioButton'>
                            <label for="pass">Pass</label>
                            <input type="radio" name="test8" value="1" required>
                            <label for="fail">Fail</label>
                            <input type="radio" name="test8" value="0">
                        </td>
                    </tr>
                    <!-- ROW 10-->
                    <tr class='tableRow'>
                        <td>Perform a surface dive</td>
                        <td class='radioButton'>
                            <label for="pass">Pass</label>
                            <input type="radio" name="test9" value="1" required>
                            <label for="fail">Fail</label>
                            <input type="radio" name="test9" value="0">
                        </td>
                    </tr>
                    <!-- ROW 11-->
                    <tr class='tableRow'>
                        <td>Exit the water without using steps</td>
                        <td class='radioButton'>
                            <label for="pass">Pass</label>
                            <input type="radio" name="test10" value="1" required>
                            <label for="fail">Fail</label>
                            <input type="radio" name="test10" value="0">
                        </td>
                    </tr>
                    

                        
                <input type='hidden' name='classIdToRegister' value='<?php echo $classId ?>'> <!--Return classID-->
                <input type='hidden' name='studentIdToTest' value='<?php echo $studentNum ?>'> <!--Return studentNum-->
                
                </table>
                <br>
                <input class='registerSubmit' type='submit' value='Submit' style="float: right">
                </form>

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
    

    <script src="../../scripts/jquery-3.4.1.min.js"></script>
    <script src="../../scripts/main.js"></script>
</body>
</html>