<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Page Title</title>
</head>

<?php
    session_start();

    //Instantiate new POST methods and set field to empty primitive if null

    $user = $_POST['username'] ?? ""; 
    $pass = $_POST['password'] ?? "";
    $credit = $_GET['credit'] ?? "";

    //If the relevant fields are null/empty 
    
    if ($user == "" || $pass == "") 
    {
        header("Location: loginForm.php?invaliddetails"); //Invalid credentials 
        exit (0);
    }
    
    if(strpbrk($user, ';:"=-+/*_%&|\'')) //if splitted string username contains any of the following characters
    {
        header("Location: loginForm.php?invalidcharacters"); //Invalid credentials 
        exit (0);
    }
    if(strpbrk($pass, ';:"=-+/*&_%|\'')) //if splitted string password contains any of the following characters
    {
        header("Location: loginForm.php?invalidcharacters"); //Invalid credentials 
        exit (0);
    }
    
    //Extend thread in connect.php

    include "connect.php";

    //SQL - select userPass from users

    $sql2 = "SELECT userPass FROM users";
    $result = mysqli_query($link, $sql2);
    $sql = "";

    $correct = false;

    //whilst the featched row is true to the result

    while($row=mysqli_fetch_row($result))
    {
        $storedPassword = $row[0];
        
        if(password_verify($pass,$storedPassword)) //verifies that the password matches the hashed password
        {
            //SQL - select all from users where the userName is equal to the user selected

            $sql = "SELECT * FROM users WHERE userName ='$user'";
            $pass = "";
            $correct = true; //password acccepted 
            break; 
        }
        else 
        {
            $correct = false; //password not acccepted 
            
        }
    }

    if(!$correct) //If correct false
    {
       header("Location: loginForm.php?password_credentials"); //Incorrect password credentials
       exit(0);
    }
    $pass="";
    
    //This will select all of my user records
    
    $result2 = mysqli_query($link, ($sql));
    
    //Checking user details are correct against the database
    if (mysqli_num_rows($result2) == 1) {
        $row = mysqli_fetch_array($result2);
    
    //Stores user's accessLevel for secure page
        
    //Checks if cookie has not been created

        if(!isset($_SESSION["User"]))
        {
    
            //creates cookie
            //setcookie("User", $row['userName'], time()+9000);

            $_SESSION['User'] = $row['userName'];
            $_SESSION['Name'] = $row[2];

            //Secure Page / If session valid 

            $_SESSION['valid'] = true;
            $_SESSION['accessLevel'] = $row['accessLevel'];

            if ($row[4] == 1) // if reset password is true
            {
                ?>
                <form action="resetUserPasswordForm.php" id="resetPass" method="post" enctype="multipart/form-data">
                    <input name="userName" type="hidden" value="<?php echo $user; ?>">
                </form>
                <script>
                    document.getElementById("resetPass").submit();
                </script>
                <?php
                exit(0);
            }

            deleteRecords();

            exit(0);
        }
        else
        {
            //checks cookie matches the username
            if ($_SESSION["User"] == $row['userName']) 
            {
                echo "Welcome ".$_SESSION["User"];
            } 
            else 
            {
                //creates cookie
                $_SESSION['User'] = $row['userName'];
                $_SESSION['Name'] = $row[2];

            }

            //Secure Page where cookie exsists
            $_SESSION['valid'] = true;
            $_SESSION['accessLevel'] = $row['accessLevel'];

            if ($row[4] == 1) // if reset password is true
            {
                ?>
                <form action="resetUserPasswordForm.php" id="resetPass" method="post" enctype="multipart/form-data">
                    <input name="userName" type="hidden" value="<?php echo $user; ?>">
                </form>
                <script>
                    document.getElementById("resetPass").submit();
                </script>
                <?php
                exit(0);
            }

            deleteRecords();

            exit(0);
        }
    } else {
        //Login Page
        session_destroy();
        header("location: LoginForm.php?credit=false");
        exit;
    }


    function deleteRecords()
    {
        //If session valid and access level is 2

        if($_SESSION['accessLevel'] == 2)
            {
                global $link;
                
                //will check all records in archived students and delete if older than 4 years
                $sqlSelect = "SELECT studentNum FROM archivestudents WHERE timeOfArchive <= now() - INTERVAL 1460 DAY";
                
                $result = mysqli_query($link, $sqlSelect);
                
                //Whilst the query has returned the relevant row response

                $numOfRows = mysqli_num_rows($result) ?? 0; //database result casted to the num_rows query
                if($numOfRows == 0) 
                {
                    header("location: securehomepage.php"); //Row deleted
                    exit(0);
                }

                while($row = mysqli_fetch_row($result))
                {
                    

                    //SQL - delete from archivestudents where the studentNum is the first row

                    $sqlDelete = "DELETE FROM archivestudents WHERE studentNum = '$row[0]'";
                    if (mysqli_query($link, $sqlDelete))
                    {

                        header("location: securehomepage.php?deletedArchivedRecords=success"); //Row deleted

                    }
                    else 
                    {
                        header("location: securehomepage.php?deletedArchivedRecords=fail"); //Row not deleted

                    }
                }
                
            }
    }
?>

<body>
</body>
</html>