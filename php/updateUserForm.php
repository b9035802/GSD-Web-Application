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
if (($_SESSION['valid'] ?? "") && ($_SESSION['accessLevel'] == 2) ?? "")
    {
        //If the cookie is validated by a user/coach signing in, welcome them back to the page
        //echo "Welcome back ".$_SESSION["User"].",  Access Level: ".$_SESSION['accessLevel'];
    }   
else {
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

                    //If session valid

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

                 //Extend thread on connect.php

                    include "connect.php";

                    //Instantiate new POST methods and set the primitive to empty if null

                    $userNameToUpdate = $_POST['userNameToUpdate'] ?? "";
                    $update = $_POST['update'] ?? "";

                    $previous = "javascript:history.go(-1)" ?? "";
                    if ($userNameToUpdate == "") //If the field is empty/null
                    {
                        header("Location: $previous? no_studenId"); //no student found
                        exit (0);
                    }

                    //SQL - select all from users where the userName is equal to the user selected

                    $sql = "SELECT * FROM  users WHERE userName = '$userNameToUpdate'";
                    $result = mysqli_query($link, $sql);

                    

                 ?>

                 <div class="form">
                 <form action="updateUser.php" method="post" enctype="multipart/form-data">
                        <input name="userNameToUpdate" type="hidden" value="<?php echo $userNameToUpdate; ?>">
                        <label for="fullName">Name</label>
                        <input type="text" name="fullName" id="fullName" required>
                        <label for="accessLevel">Coach/Admin</label>
                        <select name="accessLevel" id="coachAdmin" required>
                            <option value="1">Coach</option>
                            <option value="2">Admin</option>
                        </select>
                    <br><br>
                    <input type="submit" name="remove" value="Update" class="newMemberbutton"  onclick="document.getElementById('coachAdmin').disabled = false;return confirm('Are you sure?')">
                    <!--to remove the user-->
                </form>

                </div>
                <div class="form">
                <br>
                <h3>Reset Password</h3>
                <form action="generateUserPassword.php" method="post" enctype="multipart/form-data">
                    <input name="userNameToReset" type="hidden" value="<?php echo $userNameToUpdate; ?>"> 
                    <br>
                    <input type="submit" name="remove" value="Generate new password" class="newMemberbutton"  onclick="return confirm('Are you sure?')">
                    <!--to remove the user-->
                </form>
                </div>

                <?php

                    //If password reset is not null and is equal to 'success'

                    if(isset($_GET['passwordReset']) && $_GET['passwordReset'] == "success")
                    {
                        $userName = $_POST['userName'] ?? "";
                        $pass = $_POST['password'] ?? "";
                        
                        ?>
                        <div id='newUserDetails'>
                        <p>Current username: <?php echo $userName; ?></p>
                        <p>Users New password: <?php echo $pass; ?></p>
                        </div>

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
    <!--javaScript files will be executed here-->
    <script src="../scripts/jquery-3.4.1.min.js"></script>
    <script src="../scripts/main.js"></script>
    <script>
        <?php
        while ($row=mysqli_fetch_row($result))
        {	
            ?>
            var accessLevel = <?php echo $row[3]; ?>
            //console.info(accessLevel)
            document.getElementById("fullName").defaultValue = "<?php echo $row[2]; ?>"
            document.getElementById("coachAdmin").selectedIndex = accessLevel-1
        <?php 

        //If user is equal to user currently being edited
        if($_SESSION["User"] == $userNameToUpdate)
        {
            ?>
            console.info("editing self")
            document.getElementById("coachAdmin").disabled = true
            <?php
        }

        
        } 
        ?>
    </script>
</body>
</html>