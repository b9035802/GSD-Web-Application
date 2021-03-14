<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <!-- Viewport here -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dronfield Swimming Club - Login</title>
    <!-- attach styles here -->
    <link rel="stylesheet" href="../css/mobile.css"/>
    <link rel="stylesheet" href="../css/desktop.css" media="only screen and (min-width : 800px)"/>
    <link rel="icon" type="image/x-icon" href="../images/logoCOMP.png"/>
</head> <!--https://cdn.discordapp.com/attachments/788419191870324769/798955834453393418-->
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
                </ul>
            </div>
        </nav>
         <!--the main content for the site-->
         <main>
             <div class="mainContent">
                 <!--content goes here-->
                 <h1 class="siteTitle">Dronfield Swimming Club | Login </h1>
                 <!--Here is the login form which will execute the php script-->
                 <div class="form">


                    <form action="../php/login.php" method="post" enctype="multipart/form-data">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                        <input type="hidden" name="destination" value="login">
                        <br><br>
                        <input type="submit" name="submit" class="newMemberbutton">
                        <br><br>
                    </form>

                    
                </div>
                
             </div>
         </main>
    </div>

    <!--javaScript files will be executed here-->
    <script src="../scripts/jquery-3.4.1.min.js"></script>
    <script src="../scripts/main.js"></script>
    
    <?php
    
    //Extend thread on connect.php

    include "../php/connect.php";

    //This is the message the user will recive if they enter invalid details
    if (isset($_GET['credit']) && $_GET['credit'] == "false")
        {
            echo '<br><span style="color:#F00; "> Either the username or password is incorrect, try again ';
        }

    
    ?>

     <footer>
        <div class="row">
            <address>
                Dronfield Sports Centre<br /> Dronfield<br /> Derbyshire<br /> S42 6NG
            </address>
        </div>
    </footer>
    
</body>
</html>