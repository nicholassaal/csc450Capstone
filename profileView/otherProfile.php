<?php 
    session_start();
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
        $i = 0; //variable outside of loop to access the array
        $clickedUserId = $_GET["uid"];

        //Run and assign query 
        $data = mysqli_query($connectToDB, $sqlStudentCourse);
    
        //Headers
        echo "<fieldset class = reviewField>";
        echo "<legend class = reviewLegend>Written reviews: </legend>";
        
        //Nested while loop to iterate through rows in a particular table. 
        while($rows = mysqli_fetch_array($data)) { //Outter is iterating through all rows in studentCourse table
            $studentId = $rows['student_id'];//Retrieve the student_id PK 
            if($studentId == $clickedUserId) { //checks to see if the $studentId found in DB matches the sent over uid to populate the reviews

                $courseCode = $rows['course_code'];//Retrieve the course_code 
                //Create the query for course table selection, where course_code matches the student's course_code in studentCourse table

                $courseCodeArray[] = $courseCode; //storing the $courseCodes into an array to access for the ?id=Course_code(s)
                //print_r($courseCodeArray); //simple print to show array being created

                $sqlStudentCourse = "SELECT * FROM course WHERE course_code = $courseCode";
                //Run query 
                $courseData = mysqli_query($connectToDB, $sqlStudentCourse);
                //Inner while loop iterate through course table, and retrieve the course_description, where studentCourse course_code FK matches a course_code in course table
                while($courseRows = mysqli_fetch_array($courseData)) { 
                    //Retrieve that particular row and display on screen using echo
                    $studentReview = $courseRows['course_name']; 
                        echo "<a href = http://localhost/csc450Capstone/CoursePage/CoursePage.php?id=$courseCodeArray[$i]#$studentId class = reviewBox id = reviewBox>";
                            echo "<p>".$studentReview."</p>";
                        echo "</a>";
                    $i++; //adds 1 to $i
                }// end innerWhile()
            } //end if()
        } //end while()

        echo "</fieldset>"; 
    }//end of displayReviewCourse function()

    function displayStudentInfo() {
        global $connectToDB;
        $clickedUserId = $_GET["uid"];

        //TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING
        //echo "$clickedUserId";
        //TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING

        $sqlStudentInfo = "SELECT student_id, CONCAT(student_fname,' ',student_lname) AS 'fullName' FROM studentInfo WHERE $clickedUserId = student_id"; //selecting a specific table from the already connected to database

        //Run and assign query 
        $data = mysqli_query($connectToDB, $sqlStudentInfo);
    
        //Headers
        echo "<fieldset class = studentField>";
        echo "<legend class = infoLegend>Student Information:</legend>";

        while($rows = mysqli_fetch_array($data)) { 

            //TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING
            //print_r($rows);
            //TESTING TESTING TESTING TESTING TESTING TESTING TESTING TESTING

            $studentId = $rows['student_id'];
            $studentName = $rows['fullName'];
            if ($studentId == $clickedUserId) { //checks to see if the $studentId found in DB matches the sent over uid to populate the reviews
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
            } //end of if($studentId ==...)
        } //end while()
    }//end of displayStudentInfo 

    function displayAboutStudent() {
        global $connectToDB;
        $clickedUserId = $_GET["uid"];
        $sqlStudentInfo = "SELECT * FROM studentInfo";

        //Run and assign query 
        $data = mysqli_query($connectToDB, $sqlStudentInfo);

        //Headers 
        echo "<fieldset class = otherInfoField>";
        echo "<legend class = otherInfoLegend>About Me: </legend>";

        //While loop to retrieve data from studentInfo table. 
        while($rows = mysqli_fetch_array($data)) { 
            $studentId = $rows['student_id'];
            if ($studentId == $clickedUserId) { //checks to see if the $studentId found in DB matches the sent over uid to populate the reviews
                //Added the rest of the About me sections information in the database. 
                $student_social = $rows['student_social'];
                $student_birthday = $rows['student_birthday'];
                $student_phoneNumber = $rows['student_phoneNumber'];
                $student_year = $rows['student_year'];
                $about_student = $rows['about_student'];
                echo "<h3>Socials: </h3>";
                echo "<p>" . $student_social . "</p>";
                echo "<h3>Birthday: </h3>";
                echo "<p>" . $student_birthday . "</p>";
                echo "<h3>Phone Number: </h3>";
                echo "<p>" . $student_phoneNumber . "</p>";
                echo "<h3>Year of study: </h3>";
                echo "<p>" . $student_year . "</p>";
                echo "<h3>About me: </h3>";
                echo "<p>" . $about_student . "</p>";
            }
        }

        echo "</fieldset>";
    }//end of displayAboutStudent()

//creating function to get users profile pictures
function getOtherProfilePicture(){
    global $connectToDB;
    $sqlStudentInfo = "SELECT * FROM studentInfo";
   $clickedUserId = $_GET["uid"];
    //Run and assign query 
    $data = mysqli_query($connectToDB, $sqlStudentInfo);
     //While loop to retrieve data from studentInfo table. 
     while ($rows = mysqli_fetch_array($data)) {
        $studentId = $rows['student_id'];
        if ($studentId == $clickedUserId) { 
            $picture = $rows['user_image'];
            echo  "<img  src='upload/" . $picture . "' alt='img' id = 'otherProfilePictureImage'>";
        }
    }

}//end of getOtherProfilePicture()
//creating function to get users profile pictures for the Nav bar
function navGetProfilePicture(){
    global $connectToDB;
    $sqlStudentInfo = "SELECT * FROM studentInfo";

    //Run and assign query 
    $data = mysqli_query($connectToDB, $sqlStudentInfo);
     //While loop to retrieve data from studentInfo table. 
     while ($rows = mysqli_fetch_array($data)) {
        $studentId = $rows['student_id'];
        if ($studentId == $_SESSION["currentUserLoginId"]) {
            $picture = $rows['user_image'];
            echo  "<img  src='upload/" . $picture . "' alt='img' id ='navImage'>";
        }
    }

}//end of navGetProfilePicture()
    function getClickedUserName(){
        global $connectToDB;
        $clickedUserId = $_GET["uid"];

        $sqlGetName = "SELECT student_fname FROM studentInfo WHERE $clickedUserId = student_id";

        $queryGetName = mysqli_query($connectToDB, $sqlGetName);
        $fetchNameField = mysqli_fetch_assoc($queryGetName);

        $student_name = $fetchNameField['student_fname'];

        echo "".$student_name."'s Profile";
    }//end of getClickUserName()

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" type = "text/css" href = "profiles.css">
    <link rel="stylesheet" type="text/css" href="../globalStyle/navBarStyling.css">
    <style>
        <?php include("profiles.css"); ?>
    </style>
    <title>User Profile</title>
</head>
<body>
    <!-- Start of Nav Script -->
<nav id="navbar">
    <script>
        var lastScrollTop; // This Varibale will store the top position

navbar = document.getElementById('navbar'); // Get The NavBar

window.addEventListener('scroll',function(){
 //on every scroll this funtion will be called
  
  var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
  //This line will get the location on scroll
  
  if(scrollTop > lastScrollTop){ //if it will be greater than the previous
    navbar.style.top='-80px';
    //set the value to the negetive of height of navbar 
  }
  
  else{
    navbar.style.top='0';
  }
  
  lastScrollTop = scrollTop; //New Position Stored
});
    </script>
        <ul class="menu">
            <li class="logo" id="logo"><?php getClickedUserName(); ?></li>
            <li class="item"><a href="http://localhost/csc450Capstone/LandingPage/LandingPage.php">Home</a></li>
            <li class="item">   
            <div id="navPicture" >
            <?php  navGetProfilePicture(); ?>
            </div> 
            </li>
            <li class="item"><a href="http://localhost/csc450Capstone/profileView/profiles.php">Profile</a></li>
            <li class="item"><a href="http://localhost/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a></li>
            <li class="item button"><a href="http://localhost/csc450Capstone/LoginPage/logOut.php">Sign Out</a></li>
    
            <li class="toggle"><span class="bars"></span></li>
        </ul>
    </nav>
    <!-- <div class = "stickyHead">
        <h1 class = "pageName">CSP Student Profile</h1>
        <div class = "wrapButton">
            <ul>
                <li id = "landingBtn"><a href = "http://localhost/csc450Capstone/LandingPage/LandingPage.php">Home</a></li>
                <li id = "profileBtn"><a href = "http://localhost/csc450Capstone/ProfileView/profiles.php">Profile</a></li>
                <li id = "perMajorBtn"><a href = "http://localhost/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a></li>
                <li id = "loginBtn"><a href = "http://localhost/csc450Capstone/LoginPage/logOut.php">Sign Out</a></li>
            </ul>
        </div>
    </div> -->

    <div class = "studentInfo">
        <div class = "studentDescript1">
            <?php
            
             
            getOtherProfilePicture();
             
            ?>
            <!-- <a href = "graphic/cool_guy.png"><img src = "graphic/cool_guy.png" id = "examplePicture"></a> -->
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
        
    </div>
    
</body>
</html>

<script>
    
    // var x = document.getElementById('reviewBox');
    // x.style.display = 'none';
    
</script>