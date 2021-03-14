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

                 //Extend thread on connect.php

                    include "connect.php";
                 ?>

                 <div class="form"> <!--Form for updating meeting-->
                 <h2>Create New User</h2>
                 <br><br>
                 <br><br>
                    <form action="createNewUser.php" method="post" enctype="multipart/form-data">
                        <label for="fullName">Name</label>
                        <input type="text" name="fullName">
                        <label for="accessLevel">Coach/Admin</label>
                        <select name="accessLevel" id="classDay">
                            <option value="1">Coach</option>
                            <option value="2">Admin</option>
                        </select>
                    <br><br>
                    <input type="submit" name="remove" value="Add New" class="newMemberbutton"  onclick="return confirm('Are you sure?')">

                    </form>
                    <?php
                    if(isset($_GET['newUser']) && $_GET['newUser'] == "success") //If newUser is not null and is equal to 'success'
                    {
                        //Initialise new POST methods and set the field to an empty primitive if null

                        $userName = $_POST['userName'] ?? "";
                        $pass = $_POST['password'] ?? "";
                        
                        ?>
                        <div id='newUserDetails'>
                        <p>New users username: <?php echo $userName; ?></p>
                        <p>New users password: <?php echo $pass; ?></p>
                        </div>

                    <?php
                    }
                    ?>
                    
                 </div>

                 
                 <br>
                 <div class="form"> <!--Form for updating users-->
                 
                 <h2>Users</h2>
                 <?php
                 //Student table

                $studentNum = "";

                //SQL - select username, fullname and accesslevel from users record
                
                $sql = "SELECT username, fullname, accessLevel FROM users";
                $result = mysqli_query($link, $sql);
                
                ?>
                <br> 
                <?php
                echo "<table class= 'table'>";
                $counter=0;

                //Whilst the query returns the relevant row casted to the result

                while ($row=mysqli_fetch_row($result))
                {	

                    //Initialise new POST methods and set the field to an empty primitive if null

                    $userName = $row[0] ?? "";
                    $name = $row[1] ?? "";
                    $accessLevel = $row[2] ?? "";

                    $coachAdmin = "";

                    if($accessLevel == 1) // if they are a coach
                    {
                        $coachAdmin = "Coach";
                    }
                    else if($accessLevel == 2) //  if they are an admin
                    {
                        $coachAdmin = "Admin";
                    }

                    $counter++;
                    echo "<tr class='tableRow'>";
                    echo "<td id=member".$counter." onclick='OpenRows(this.id)' class='topRow'><span style='font-weight:bold'>Name: </span><br />". $name."</td>";
                    echo "<td id=member".$counter." onclick='OpenRows(this.id)' class='topRow'><span style='font-weight:bold'>Position: </span><br>". $coachAdmin."</td>";
                    echo "</tr>";
                    echo "<tr id=member".$counter." class='tableRow hidden'>";
                    echo "<td id=member".$counter." class='tableRow hidden' >";
                    ?>
                    <form action="removeUser.php" method="post" onsubmit="">
                        <input type="hidden" name="userNameToRemove" value="<?php echo $userName; ?>">
                        <input type="submit" name="remove" value="Remove User" class="newMemberbutton"  onclick="return confirm('Are you sure?')"> <!--Remove User-->
                    </form>
                    <?php
                    echo "</td>";

                    echo "<td id=member".$counter." class='tableRow hidden'>";
                    ?>
                    <form action="updateUserForm.php" method="post" onsubmit="">
                        <input type="hidden" name="userNameToUpdate" value="<?php echo $userName; ?>">
                        <input type="submit" name="remove" value="Update User" class="newMemberbutton"> <!--Update User-->
                    </form>

                    <?php
                    echo "</td>";
                    echo "</tr>";
                    
                }
                echo "</form>";
                
                
                echo "</table>";
                ?>
                <br>
                
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