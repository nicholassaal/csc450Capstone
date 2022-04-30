<?php
session_start();

// Hosted server connection
$SERVER_NAME    = "localhost:3306";   //Server name 
$DBF_USER       = "thewooz7_admin";        //UserName for the localhost database
$DBF_PASSWORD   = "password";       //Password for the localhost database/ When using XAMPPS, make this value emtpy. Use: $DBF_PASSWORD   = "";
$DBF_NAME       = "thewooz7_cspcoursereview";    //DB name for the localhost database
//$connect = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD);
$connectToDB = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD, $DBF_NAME);


// $SERVER_NAME    = "localhost";   //Server name 
// $DBF_USER       = "root";        //UserName for the localhost database
// $DBF_PASSWORD   = "";       //Password for the localhost database/ When using XAMPPS, make this value emtpy. Use: $DBF_PASSWORD   = "";
// $DBF_NAME       = "CSPCourseReview";    //DB name for the localhost database
// //$connect = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD);
// $connectToDB = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD, $DBF_NAME);
// echo "<br><br><br><br><br>";


//creating function to get users profile pictures for the Nav bar
function navGetProfilePicture()
{
    global $connectToDB;
    $sqlStudentInfo = "SELECT * FROM studentinfo";

    //Run and assign query 
    $data = mysqli_query($connectToDB, $sqlStudentInfo);
    //While loop to retrieve data from studentInfo table. 
    while ($rows = mysqli_fetch_array($data)) {
        $studentId = $rows['student_id'];
        if ($studentId == $_SESSION["currentUserLoginId"]) {
            $testid = $studentId;
            $picture = $rows['user_image'];
            echo  "<img  src='/csc450Capstone/profileView/upload/" . $picture . "' alt='img' id ='navImage'>";
            //echo"$testid";
        }
    }
} //end of navGetProfilePicture()
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../globalStyle/navBarStyling.css">
    <link rel="stylesheet" href="LandingPage.css">

    <title>Landing Page</title>

</head>

<body>

    <nav id="navbar">
        <script>
            var lastScrollTop; // This Varibale will store the top position

            navbar = document.getElementById('navbar'); // Get The NavBar

            window.addEventListener('scroll', function() {
                //on every scroll this funtion will be called

                var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                //This line will get the location on scroll

                if (scrollTop > lastScrollTop) { //if it will be greater than the previous
                    navbar.style.top = '-80px';
                    //set the value to the negetive of height of navbar 
                } else {
                    navbar.style.top = '0';
                }

                lastScrollTop = scrollTop; //New Position Stored
            });
        </script>

        <ul class="menu">
            <li class="logo" id="logo">CSP Home Page</li>
            <li class="item"><a href="https://thewoodlandwickcandleco.com/csc450Capstone/LandingPage/LandingPage.php">Home</a></li>
            <li class="item">
                <div id="navImage">
                    <?php navGetProfilePicture() ?>
                </div>
            </li>
            <li class="item"><a href="https://thewoodlandwickcandleco.com/csc450Capstone/profileView/profiles.php">Profile</a></li>
            <li class="item"><a href="https://thewoodlandwickcandleco.com/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a></li>
            <li class="item button"><a href="https://thewoodlandwickcandleco.com/csc450Capstone/LoginPage/logOut.php">Sign Out</a></li>
            <li class="toggle"><span class="bars"></span></li>
        </ul>
        <!-- <ul class="menu">
            <li class="logo" id="logo">CSP Home Page</li>
            <li class="item"><a href="https://localhost/csc450Capstone/ticketRequest/ticketRequest.php">Ticket Request</a></li>
            <li class="item"><a href="https://localhost/csc450Capstone/LandingPage/LandingPage.php">Home</a></li>
            <li class="item">
                <div id="navImage">
                    <?php // navGetProfilePicture() 
                    ?>
                </div>


            </li>
            <li class="item"><a href="http://localhost/csc450Capstone/profileView/profiles.php">Profile</a></li>
            <li class="item"><a href="http://localhost/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a></li>
            <li class="item button"><a href="http://localhost/csc450Capstone/LoginPage/logOut.php">Sign Out</a></li>
            <li class="item button secondary"><a href="#">Sign Up</a></li>
                <li class="toggle"><span class="bars"></span></li>
        </ul>  -->
    </nav>

    <div class="welcomeText">

        <h1 id="firstboxh">Welcome to the CSP Review</h1>
        <p id="firstboxp"> CSP Review is your one stop shop for the connections and information guaranteed to put you ahead of those who have come before you.</p>
    </div>

    <div class="welcomeText2">
        <h1 id="box2h">What is CSP Review</h1>
        <ul class="box2p">
            <li>This application allows students to review courses they have finish and see responses from fellow class mates.</li></br>
            <li>The review tool allows you to have better knowledge on what you will learn in a course along with allowing you to create connections and network with those who have taken the course before you.</li>
        </ul>
    </div>

    <div class="welcomeText">
        <h1 id="firstboxh">Who can write review?</h1>
        <p id="firstboxp">Any CSP student in the major can write, view, and reply to reviews.</p>
    </div>

    <div class="welcomeText2">
        <h1 id="box2h">What do these reviews provide?</h1>
        <ul class="box2p">
            <li>All sensitive data such as grades and GPA of each user will not be shown.</li></br>
            <li>Data collected will include:</li>
            <li>- Reviews on what you learned in the course.</li>
            <li>- Suggestions for how to prepare for courses.</li>
            <li>- What was most challenging about the course.</li>
            <li>- Anything else the student would like to include.</li>
        </ul>
    </div>

    <div class="welcomeText">
        <h1 id="firstboxh">How it helps the CSP:</h1>
        <ul class="box2p">
            <li>The data provided will help CSP know what aspects of courses are working and what are not.</li></br>
            <li>Information will help CSP adapt to the future.</li></br>
            <li>Helps CSP staff and students better connect with each other.</li>
        </ul>
    </div>

    <div class="welcomeText2">
        <h1 id="box2h">This is the future.</h1>
        <ul class="box2p">
            <li>Join us in helping CSP students learn about their courses and better prepare for achieving excellence.</li>
        </ul>
    </div>

    <footer>
        <a href="">Group 1 CSC 450 Capstone Neng Yang | Josiah Skorseth | Mitchell Williamson | Nicholas Saal</a>
    </footer>

</body>

</html>