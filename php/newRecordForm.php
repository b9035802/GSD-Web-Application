<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <!-- Viewport here -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Home</title>
    <!-- attach styles here -->
    <link rel="stylesheet" href="../css/mobile.css">
    <link rel="stylesheet" href="../css/desktop.css" media="only screen and (min-width : 800px)"/>
</head>
<body>
    <div class="container">
        <header>
            <!--logo-->
            <div class="logo">
                <!--image logo will go here-->
                <img src="https://media.discordapp.net/attachments/788419191870324769/798146408313782282/LOGO.png" alt="" />

            </div>
            <!--login-->
            <div class="loginLink">
                <ul>
                    <li>
                        <a href="../php/loginForm.php">Login</a>
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
                    <li><a href="../html/index.html">Home</a></li>
                    <li><a href="../html/classes.html">Classes</a></li>
                    <li><a href="../html/testing.html">Conduct a Test</a></li>
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

                    $studentIdToUpdate = $_POST['studentIdToUpdate'];
                    $update = $_POST['update'];

                    $sql = "SELECT * FROM  Students WHERE studentNum = '$studentIdToUpdate'";
                    $result = mysqli_query($link, $sql);
                 ?>

                 <div class="form">
                    <form action="../php/createNewRecord.php" method="post" enctype="multipart/form-data">
                        <label for="studentNum">Student Number</label>
                        <input type="text" id="studentNum" name="studentNum">
                        <label for="studentName">Student's Name</label>
                        <input type="text" id="studentName" name="studentName">
                        <label for="studentDOB">Student's Date of Birth</label>
                        <input  type="date" id="studentDOB" name="studentDOB">
                        <label for="studentAddress">Student's Home Address</label>
                        <input type="text" id="studentAddress" name="studentAddress">
                        <label for="parentName">Student's Parent's Name (Only One Required)</label>
                        <input type="text" id="parentName" name="parentName">
                        <label for="parentEmail">Parent's Email</label>
                        <input type="email" id="parentEmail" name="parentEmail">
                        <label for="parentPhone">Parent's Phone</label>
                        <input type="tel" id="parentPhone" name="parentPhone">
                        <label for="studentMedical">Student's Medical Information</label>
                        <textarea  id="studentMedical" name="studentMedical"></textarea>
                        <br><br>
                        <input type="submit" name="submit">
                        <br><br>
                    </form>
                 </div>
             </div>
         </main>
    </div>
    <!--javaScript files will be executed here-->
    <script src="../scripts/jquery-3.4.1.min.js"></script>
    <script src="../scripts/main.js"></script>
    <script>
        <?php
        while ($row=mysqli_fetch_row($result))
        {	
            ?>
            document.getElementById("studentName").defaultValue = "<?php echo $row[1]; ?>"
            document.getElementById("studentDOB").defaultValue = "<?php echo $row[2]; ?>"
            document.getElementById("studentAddress").defaultValue = "<?php echo $row[3]; ?>"
            document.getElementById("parentName").defaultValue = "<?php echo $row[4]; ?>"
            document.getElementById("parentEmail").defaultValue = "<?php echo $row[5]; ?>"
            document.getElementById("parentPhone").defaultValue = "<?php echo $row[6]; ?>"
            document.getElementById("studentMedical").defaultValue = "<?php echo $row[7]; ?>"
        <?php } ?>
    </script>
</body>
</html>