<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <!-- Viewport here -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dronfield Swimming Club - Sign Up</title>
    <!-- attach styles here -->
    <link rel="stylesheet" href="../css/mobile.css">
    <link rel="stylesheet" href="../css/desktop.css" media="only screen and (min-width : 800px)"/>
    <link rel="icon" type="image/x-icon" href="../images/logoCOMP.png"/>
</head>
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
                    <!-- <li><a href="../html/classes.html">Classes</a></li>
                    <li><a href="../html/testing.html">Conduct a Test</a></li> -->
                </ul>
            </div>
        </nav>
         <!--the main content for the site-->
         <main>
             <div class="mainContent">
                 <!--content goes here-->
                 <h1 class="siteTitle">Dronfield Swimming Club | Sign Up </h1>
                 <!--Here is the login form which will execute the php script-->
                 <div class="form">
                    <form action="../php/hashGenerate.php" method="post" enctype="multipart/form-data">
                        <label for="username">Enter Username</label>
                        <input type="text" id="username" name="username" required>
                        <label for="password">Enter Password</label>
                        <input type="password" id="password" name="password" onkeyup='checkPasswordsMatch()' required>
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" onkeyup='checkPasswordsMatch()' required>
                        <label for="signupKey">Enter Sign Up Key </label>
                        <input type="password" id="signUpKey" name="signUpKey" required>
                        <input type="hidden" name="destination" value="signUp">
                        <br><br><br>
                        <input disabled = true type="submit" name="signUpSubmit" id="signUpSubmit" value="Sign Up" class="newMemberbutton" >
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