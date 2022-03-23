<?php
    session_start();

    $SERVER_NAME    = "localhost";   //Server name 
    $DBF_USER       = "root";        //UserName for the localhost database
    $DBF_PASSWORD   = "";       //Password for the localhost database/ When using XAMPPS, make this value emtpy. Use: $DBF_PASSWORD   = "";
    $DBF_NAME       = "CSPCourseReview";    //DB name for the localhost database
    //$connect = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD);
    $connectToDB = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD, $DBF_NAME);

    // Check connection
    //$conn->connect_error: The connect_error property in the $conn (Connection) object. This property contains any error message from the last operation.
    if ($connectToDB->connect_error) { //-> is used to point to items contained in an object.
        die("Connection failed: " . $conn->connect_error); //die( ) will kill the current program after displaying the message in the String parameter.
    }



    
    function displayCourses() {
        global $connectToDB;
        $sqlStudentCourse = "SELECT * FROM course"; //selecting a specific table from the already connected to database

        //Run and assign query 
        $data = mysqli_query($connectToDB, $sqlStudentCourse);

        //div class for css
        echo "<div class='flex-container'>";

        $j = 0; //iteration number being initialized for the indexes of the array

        //While loop to populate each div container on the major page 
        while($rows = mysqli_fetch_array($data)) {
            $courseCode = $rows['course_code'];//Retrieve course_code
            $courseName = $rows['course_name'];//Retrieve course_name
            $courseDes = $rows['course_description'];//Retrieve course_name

            $courseCodeArray[] = $courseCode; //store $courseCodes into an array

            //Populate the div containers using data from the course table in the database
            echo"<div>";
                echo"<a href=http://localhost/csc450Capstone/CoursePage/CoursePage.php?id=$courseCodeArray[$j] class='fill-div'>"; //fetching from the array by iterating $j to check each index
                    echo"<img src='Images/courseImage2.jfif' alt='waaaaaaa' />";
                    echo"<h1>".$courseName."</h1>";
                    echo"<h2>".$courseDes."</h1>";
                echo"</a>";
            echo"</div>";

            $j++;
        } 
        echo"</div>";
    }//end of displayCourses()

    $randomNum = 1;

?>



<!DOCTYPE html>
<html>

<head>
    <title>Majors</title>
    <link rel="stylesheet" type="text/css" href="majorStyle.css">
</head>

<body>
    <nav id="navbar">
        <ul>
            <li>
                <h1>Computer Science Courses</h1>
            </li>
            <li style="float: right"><a href="http://localhost/csc450Capstone/LoginPage/logOut.php">Sign Out</a></li>
            <li style="float: right"><a href="http://localhost/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a>
            </li>
            <li style="float: right"><a href="http://localhost/csc450Capstone/profileView/profiles.php">My Profile</a>
            </li>
            <li style="float: right"><a href="http://localhost/csc450Capstone/LandingPage/LandingPage.php">Home</a></li>
        </ul>
    </nav>
        <!-- displayCourse() function  -->
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
</body>

</html>