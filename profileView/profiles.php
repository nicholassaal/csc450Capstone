<!-- 
============================================================================

Josiah Skorseth
skorsetj@csp.edu
CSC 450 Capstone
1/24/2022
Capstone (early stages UI profiles)

url: http://localhost/csc450Capstone/profileView/profiles.php

============================================================================
-->
<?php 
    $SERVER_NAME    = "localhost";   //Server name 
    $DBF_USER       = "root";        //UserName for the localhost database
    $DBF_PASSWORD   = "";       //Password for the localhost database/ When using XAMPPS, make this value emtpy. Use: $DBF_PASSWORD   = "";
    $DBF_NAME       = "CSPCourseReview";    //DB name for the localhost database
    //$connect = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD);
    $connectToDB = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD, $DBF_NAME);

    echo "<br><br><br><br><br>";
    function displayReviewCourse() {
        global $connectToDB;
        $sqlStudentCourse = "SELECT * FROM studentCourse"; //selecting a specific table from the already connected to database

        //Run and assign query 
        $data = mysqli_query($connectToDB, $sqlStudentCourse);
    
        //Headers
        echo "<fieldset class = reviewField>";
        echo "<legend class = reviewLegend>Written reviews: </legend>";
        
        //Nested while loop to iterate through rows in a particular table. 
        while($rows = mysqli_fetch_array($data)) { //Outter is iterating through all rows in studentCourse table
            $studentId = $rows['student_id'];//Retrieve the student_id PK 
            if ($studentId == 1) {//Check if student_id matches the account in the profile view page
                $courseCode = $rows['course_code'];//Retrieve the course_code 
                //Create the query for course table selection, where course_code matches the student's course_code in studentCourse table
                $sqlStudentCourse = "SELECT * FROM course WHERE course_code = $courseCode";
                //Run query 
                $courseData = mysqli_query($connectToDB, $sqlStudentCourse);
                //Inner while loop iterate through course table, and retrieve the course_description, where studentCourse course_code FK matches a course_code in course table
                while($courseRows = mysqli_fetch_array($courseData)) { 
                    //Retrieve that particular row and display on screen using echo
                    $studentReview = $courseRows['course_description']; 
                        echo "<div class = reviewBox>";
                            echo "<p>".$studentReview."</p>";
                        echo "</div>";
                }// end innerWhile()
            }// end if()
        } //end while()

        
        echo "</fieldset>"; 
    }//end of displayReviewCourse function()

    function displayStudentInfo() {
        global $connectToDB;
        $sqlStudentInfo = "SELECT student_id, CONCAT(student_fname,' ',student_lname) AS 'fullName' FROM studentInfo "; //selecting a specific table from the already connected to database

        //Run and assign query 
        $data = mysqli_query($connectToDB, $sqlStudentInfo);
    
        //Headers
        echo "<fieldset class = studentField>";
        echo "<legend class = infoLegend>Student Information:</legend>";

        while($rows = mysqli_fetch_array($data)) { 
            $studentId = $rows['student_id'];
            $studentName = $rows['fullName'];
            if ($studentId == 1) {
                $studentinfoId = $rows['student_id'];
                //Retrieve data from studentMajor table 
                $sqlStudentMajor = "SELECT * FROM studentMajor WHERE student_id = $studentinfoId";
                //Run query 
                $sqlStudentMajorData = mysqli_query($connectToDB, $sqlStudentMajor);
                $studentMajorRows = mysqli_fetch_array($sqlStudentMajorData);
                $enrollmentStatus = $studentMajorRows['enrollment_status'];
                $studentMajorId = $studentMajorRows['major_id'];

                //Retrieve data from major table 
                $sqlMajor = "SELECT * FROM major WHERE major_id = $studentMajorId";
                //Run query 
                $majorData = mysqli_query($connectToDB, $sqlMajor);
                $majorRows = mysqli_fetch_array($majorData);
                $majorName = $majorRows['major_name'];
                $majorDescription = $majorRows['major_description'];

                //Display data that was retrieved from database 
                echo "<p>Name: ".$studentName."</p>";
                echo "<p>University Location: Concordia Saint Paul</p> ";
                echo "<p>Major: ".$majorName."</p>";
                echo "<p>Major Description: ".$majorDescription."</p>";
                    if($enrollmentStatus == 1){
                        echo "<p>Enrollment Status: Enrolled</p>";
                    }
                    else{
                        echo "<p>Enrollment Status: Not Enrolled</p>";
                    }
                }// end if()
            } //end while()
    }//end of displayStudentInfo 

    function displayAboutStudent() {
        global $connectToDB;
        $sqlStudentInfo = "SELECT student_id, about_student FROM studentInfo";

        //Run and assign query 
        $data = mysqli_query($connectToDB, $sqlStudentInfo);

        //Headers 
        echo "<fieldset class = otherInfoField>";
        echo "<legend class = otherInfoLegend>About Me: </legend>";

        //While loop to retrieve data from studentInfo table. 
        while($rows = mysqli_fetch_array($data)) { 
            $studentId = $rows['student_id'];
            if ($studentId == 1) {
                $about_student = $rows['about_student'];
                echo "<p>".$about_student."</p>";
            }
        }

        echo "</fieldset>";
    }//end of displayAboutStudent()


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" type = "text/css" href = "profiles.css">
    <style>
        <?php include("profiles.css"); ?>
    </style>
    <title>User Profile</title>
</head>
<body>
    <div class = "stickyHead">
        <h1 class = "pageName">CSP Student Profile</h1>
        <div class = "wrapButton">
            <ul>
                <li id = "landingBtn"><a href = "http://localhost/csc450Capstone/LandingPage/LandingPage.php">Home</a></li>
                <li id = "loginBtn"><a href = "http://localhost/csc450Capstone/LoginPage/LoginPage.php">Login</a></li>
                <li id = "profileBtn"><a href = "http://localhost/csc450Capstone/ProfileView/profiles.php">Profile</a></li>
                <li id = "perMajorBtn"><a href = "http://localhost/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a></li>
            </ul>
        </div>
    </div>

    <div class = "studentInfo">
        <div class = "studentDescript1">
            <a href = "graphic/cool_guy.png"><img src = "graphic/cool_guy.png" id = "examplePicture"></a>
        </div>
        <div class = "studentDescript2">
            <?php displayStudentInfo(); ?>
        </div>
    </div>

    <div>
        <?php displayReviewCourse(); ?>
    </div>

    <div>
        <?php displayAboutStudent(); ?>
        <!-- <fieldset class = "otherInfoField">
            <legend class = "otherInfoLegend">Other Info: </legend>
            <p>SAMPLE INFO</p>
            <p>SAMPLE INFO</p>
            <p>SAMPLE INFO</p>
            <p>SAMPLE INFO</p>
            <p>SAMPLE INFO</p>
            <p>SAMPLE INFO</p>
        </fieldset> -->
    </div>

    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <p>Hi There Gurt</p>
</body>
</html>
