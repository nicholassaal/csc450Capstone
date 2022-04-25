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

// Check connection
//$conn->connect_error: The connect_error property in the $conn (Connection) object. This property contains any error message from the last operation.
if ($connectToDB->connect_error) { //-> is used to point to items contained in an object.
    die("Connection failed: " . $conn->connect_error); //die( ) will kill the current program after displaying the message in the String parameter.
}

function displayCourses()
{
    global $connectToDB;
    $sqlStudentCourse = "SELECT * FROM course"; //selecting a specific table from the already connected to database

    //Run and assign query 
    $data = mysqli_query($connectToDB, $sqlStudentCourse);

    //div class for css
    echo "<div class='flex-container'>";

    $j = 0; //iteration number being initialized for the indexes of the array

    //While loop to populate each div container on the major page 
    while ($rows = mysqli_fetch_array($data)) {
        $courseCode = $rows['course_code']; //Retrieve course_code
        $courseName = $rows['course_name']; //Retrieve course_name
        $courseDes = $rows['course_description']; //Retrieve course_name

        $courseCodeArray[] = $courseCode; //store $courseCodes into an array

        //Populate the div containers using data from the course table in the database
        echo "<div >";
        echo "<a href=http://thewoodlandwickcandleco.com/csc450Capstone/CoursePage/CoursePage.php?id=$courseCodeArray[$j] class='fill-div'>"; //fetching from the array by iterating $j to check each index
        echo "<img  id = 'courseImage'src='Images/courseImage2.jfif' alt='waaaaaaa' />";
        echo "<h1>" . $courseName . "</h1>";
        echo "<h2>" . $courseDes . "</h1>";
        echo "</a>";
        echo "</div>";

        $j++;
    }
    echo "</div>";
} //end of displayCourses()

$randomNum = 1;
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
            $picture = $rows['user_image'];
            echo  "<img  src='/csc450Capstone/profileView/upload/" . $picture . "' alt='img' id ='navImage'>";
        }
    }
} //end of navGetProfilePicture()

?>



<!DOCTYPE html>
<html>

<head>
    <title>Majors</title>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="majorStyle1.css">
    <link rel="stylesheet" type="text/css" href="../globalStyle/navBarStyling.css">

</head>

<body>


    <!-- Start of Nav Script -->
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
            <li class="logo" id="logo">CSP Major Page</li>
            <li class="item"><a href="https://thewoodlandwickcandleco.com/csc450Capstone/ticketRequest/ticketRequest.php">Ticket Request</a></li>
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
            <li class="logo" id="logo">CSP Major Page</li>
            <li class="item"><a href="http://localhost/csc450Capstone/LandingPage/LandingPage.php">Home</a></li>
            <li class="item">
                <div id="navImage">
                    <?php //navGetProfilePicture() ?>
                </div>
            </li>
            <li class="item"><a href="http://localhost/csc450Capstone/profileView/profiles.php">Profile</a></li>
            <li class="item"><a href="http://localhost/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a></li>
            <li class="item button"><a href="http://localhost/csc450Capstone/LoginPage/logOut.php">Sign Out</a></li>

            <li class="toggle"><span class="bars"></span></li>
        </ul> -->
    </nav>
    <!-- End of Nav Script -->
    <?php displayCourses(); ?>

    <script>
        var prevScrollpos = window.pageYOffset;
        window.onscroll = function() {
            var currentScrollPos = window.pageYOffset;
            if (prevScrollpos > currentScrollPos) {
                document.getElementById("navbar").style.top = "0";
            } else {
                document.getElementById("navbar").style.top = "-150px";
            }
            prevScrollpos = currentScrollPos;
        }
    </script>
    <footer>
        <a href="">Group 1 CSC 450 Capstone Neng Yang | Josiah Skorseth | Mitchell Williamson | Nicholas Saal</a>
    </footer>
</body>

</html>