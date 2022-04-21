<?php
session_start();

$SERVER_NAME    = "localhost";   //Server name 
$DBF_USER       = "root";        //UserName for the localhost database
$DBF_PASSWORD   = "";       //Password for the localhost database/ When using XAMPPS, make this value emtpy. Use: $DBF_PASSWORD   = "";
$DBF_NAME       = "CSPCourseReview";    //DB name for the localhost database
//$connect = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD);
$connectToDB = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD, $DBF_NAME);
echo "<br><br><br><br><br>";


//creating function to get users profile pictures for the Nav bar
function navGetProfilePicture()
{
    global $connectToDB;
    $sqlStudentInfo = "SELECT * FROM studentInfo";

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
            <li class="item"><a href="http://localhost/csc450Capstone/ticketRequest/ticketRequest.php">Ticket Request</a></li>
            <li class="item"><a href="http://localhost/csc450Capstone/LandingPage/LandingPage.php">Home</a></li>
            <li class="item">
                <div id="navImage">
                    <?php navGetProfilePicture() ?>
                </div>


            </li>
            <li class="item"><a href="http://localhost/csc450Capstone/profileView/profiles.php">Profile</a></li>
            <li class="item"><a href="http://localhost/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a></li>
            <li class="item button"><a href="http://localhost/csc450Capstone/LoginPage/logOut.php">Sign Out</a></li>
            <!-- <li class="item button secondary"><a href="#">Sign Up</a></li> -->
            <li class="toggle"><span class="bars"></span></li>
        </ul>
    </nav>

    <div class="welcomeText">

        <h1 id="firstboxh">Welcome To The CSP Review</h1>
        <p id="firstboxp"> CSP Review is your one stop shop for the connections and Information guaranteed to put you ahead of those who have come before you </p>
    </div>

    <div class="welcomeText2">
        <h1 id="box2h">What is CSP Review</h1>
        <ul class="box2p">
            <li>This application allows students to review corses they have finish and actually see responces from fellow class mates</li></br>
            <li>The review tool allows you to have better knowlege on what you will learn in a corse along with allowing you to create connections and network with those who have taken the corse before you</li></br>
            <li></li></br>
        </ul>
    </div>

    <div class="welcomeText">
        <h1 id="firstboxh">Who Can Review?</h1>
        <p id="firstboxp"> Anyone is allowed to view reviews, but only those who have completed a corse are allow to review </p>
    </div>

    <div class="welcomeText2">
        <h1 id="box2h">What Data Is Being Found</h1>
        <ul class="box2p">
            <li>All sensitive data such as grades,GPA of each user will not be shown</li></br>
            <li>Data collected will include</li></br>
            <li>Final grade of completed corse</li></br>
            <li>Rating for professors</li></br>
            <li>Ratings for how prepared you felt going into the class</li></br>
            <li>Reviews on what you learned in the class</li></br>
            <li>What you could like to change in the corse</li></br>
            <li>Much more</li></br>
        </ul>
    </div>

    <div class="welcomeText">
        <h1 id="firstboxh">How it helps the University</h1>
        <ul class ="box2p">
            <li>Data help the university know whats working and what is not</li></br>
            <li>Information will help universitys adapt to the future</li></br>
            <li>Helps the university staff and students better connect with eachother</li></br>
        </ul>
    </div>

    <div class="welcomeText2">
        <h1 id="box2h">This Is The Future</h1>
        <ul class="box2p">
            <li>Data can be collected from the users attending universitys all around the country </li></br>
            <li>That data can be used to provide whats great or outdated about a major at that university </li></br>
            <li>Industry leaders can give input on new corses that need to be implemented for the ever changing future</li></br>
            <li>This allows university students to be more prepared for there desided career after graduation</li></br>
        </ul>
    </div>

    <footer>
        <a href="">Group 1 CSC 450 Capstone Neng Yang | Josiah Skorseth | Mitchell Williamson | Nicholas Saal</a>
    </footer>

</body>

</html>