<?php
    //This starts the session for this php page to handle and assign variables
    session_start();
    $SERVER_NAME    = "localhost";   //Server name 
    $DBF_USER       = "root";        //UserName for the localhost database
    $DBF_PASSWORD   = "";       //Password for the localhost database/ When using XAMPPS, make this value emtpy. Use: $DBF_PASSWORD   = "";
    $DBF_NAME       = "CSPCourseReview";    //DB name for the localhost database

    $connectToDB = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD, $DBF_NAME);
    
    // Check connection
    //$conn->connect_error: The connect_error property in the $conn (Connection) object. This property contains any error message from the last operation.
    if ($connectToDB->connect_error) { //-> is used to point to items contained in an object.
        die("Connection failed: " . $conn->connect_error); //die( ) will kill the current program after displaying the message in the String parameter.
    }

    function loginFunction() {
        global $connectToDB;

        //Check if inputs of userName and password have been both declared in the form< method="POST"> container
        if(isset($_POST['userName']) && isset($_POST['password']) ){ 

            $userName = $_POST['userName'];//Retrieve the user inputs for the login info
            $password = $_POST['password'];

            echo "<div class='checkLogin'>"; //container to check the user's login info they inputted

            if(empty($userName)){//If username is not filled in
                echo "<p>Please enter in a User Name</p>";
            }
            else if(empty($password)){//If password is not filled in
                echo "<p>Please enter in a password</p>";
            }
            else{//Check is user's login info is correct using the userLoginInfo from the database 
                $sqlLogin = "SELECT * FROM userLoginInfo WHERE user_name = '$userName' AND user_password = '$password' "; 
                

                //Run and assign query to $login
                $login = mysqli_query($connectToDB, $sqlLogin);
                //retrieve the person's Id of the signed in user to be used for future pages (their primary key)
                

                //if the login query returns a row in the databast userLoginInfo table
                //user's inputs is an existing record and will successfully sign in 
                if(mysqli_num_rows($login) == 1){
                    //retrieve the current users primary key (user_id) when successfully types in their user_name and password (along with grabbing Is_admin field)
                    $sqlLoginId = "SELECT user_id, Is_admin FROM userLoginInfo WHERE user_name = '$userName' AND user_password = '$password'";
                    //query the username and password to the database (while searching for the user_id)
                    $grabUserId = mysqli_query($connectToDB, $sqlLoginId);
                    //fetching the association of that row (the matching username and password row)
                    $userRow = mysqli_fetch_assoc($grabUserId);
                    //storing the actual data type 'user_id' from that row to the $_SESSION variable called 'currentUserLoginId'
                    $_SESSION["currentUserLoginId"] = $userRow['user_id'];

                    //if (checks to see if the user logging in is an admin or not an admin)
                    if ($userRow['Is_admin'] == 1) {
                        //Go to the admin view page when the admin is logged in.
                        header("Location: http://localhost/csc450Capstone/AdminPages/adminHome.php");
                    } else {
                        //Go to the landing page if the login was successful (if their account is of student status)
                        header("Location: http://localhost/csc450Capstone/LandingPage/LandingPage.php");
                    }

                    
                }
                //if login query does not return an existing record...........
                else{
                    echo "<p>Incorrect User name or password</p>";
                }
            }
        }//end of outter if statement
        echo "</div>"; 
    }//end of loginFunction()
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href ="LogInPage.css"> <!--linking the CSS-->
    <title>Form</title>
</head>

    <body>
        <header>
            <h1>CSP Student Review Login Page</h1> <!--Nav Bar, used an Unorder lists-->
            <!-- <nav> 
                <ul class="navigation">
                    <li><a href="http://localhost/csc450Capstone/LoginPage/LoginPage.php">Login Page</a></li>
                    <li><a href="http://localhost/csc450Capstone/LandingPage/LandingPage.php">Home</a></li>
                    <li><a href="http://localhost/csc450Capstone/profileView/profiles.php">Profile</a></li>
                    <li><a href="http://localhost/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a></li>
                </ul>
            </nav> -->
        </header>

        <div class="loginContainer"> <!--Image and Login info-->
            <img src="image/CSPpicture.JPG" alt="Picture of CSP">

            <section id = "userInformation"> <!--Container for login user informatoin -->
                <h1 id="loginHeader">Login</h1>
                <p>Login using your college user name and password.</p>

                <form action ="http://localhost/csc450Capstone/LoginPage/LoginPage.php" method="POST">
                    <lable for ="userName">Username</lable> <!-- Creating a lable for input type of "text" then giving a name and
                                                                id to match the lable name-->
                    <input type="text" name="userName" id = "userName">

                    <lable for ="password">Password</lable> <!-- password input type and changed name and id to password-->
                    <input type="password" name="password" id = "password">
                    
                    <!--Submit button-->
                    <input type="submit" name="btnSubmit" value="Login"  />
                    
                    <!-- Called php loginFunction() for login functionalities  -->
                    <?php loginFunction(); ?>
                </form>

            </section>
        </div>

        
        <footer>
            <p>Capstone Project Group 1 - CSP major/program course review web application. Login Page</p>
        </footer>
    </body>
</html>