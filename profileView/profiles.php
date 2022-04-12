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
session_start();
$SERVER_NAME    = "localhost";   //Server name 
$DBF_USER       = "root";        //UserName for the localhost database
$DBF_PASSWORD   = "";       //Password for the localhost database/ When using XAMPPS, make this value emtpy. Use: $DBF_PASSWORD   = "";
$DBF_NAME       = "CSPCourseReview";    //DB name for the localhost database
//$connect = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD);
$connectToDB = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD, $DBF_NAME);
echo "<br><br><br><br><br>";

function displayReviewCourse()
{
    global $connectToDB;

    $sqlStudentCourse = "SELECT * FROM studentCourse"; //selecting a specific table from the already connected to database
    $i = 0; //variable outside of loop to access the array

    //Run and assign query 
    $data = mysqli_query($connectToDB, $sqlStudentCourse);

    //Headers
    echo "<fieldset class = reviewField>";
    echo "<legend class = reviewLegend>Written reviews: </legend>";

    //Nested while loop to iterate through rows in a particular table. 
    while ($rows = mysqli_fetch_array($data)) { //Outter is iterating through all rows in studentCourse table
        $studentId = $rows['student_id']; //Retrieve the student_id PK 
        if ($studentId == $_SESSION["currentUserLoginId"]) { //Check if student_id matches the account in the profile view page
            $courseCode = $rows['course_code']; //Retrieve the course_code 
            //Create the query for course table selection, where course_code matches the student's course_code in studentCourse table

            $courseCodeArray[] = $courseCode; //storing the $courseCodes into an array to access for the ?id=Course_code(s)
            //print_r($courseCodeArray); //simple print to show array being created

            $sqlStudentCourse = "SELECT * FROM course WHERE course_code = $courseCode";
            //Run query 
            $courseData = mysqli_query($connectToDB, $sqlStudentCourse);
            //Inner while loop iterate through course table, and retrieve the course_description, where studentCourse course_code FK matches a course_code in course table
            while ($courseRows = mysqli_fetch_array($courseData)) {
                //Retrieve that particular row and display on screen using echo
                $studentReview = $courseRows['course_name'];
                echo "<a href = http://localhost/csc450Capstone/CoursePage/CoursePage.php?id=$courseCodeArray[$i]#$studentId class = reviewBox>";
                echo "<p>" . $studentReview . "</p>";
                echo "</a>";
                $i++; //adds 1 to $i
            } // end innerWhile()
        } // end if()
    } //end while()




    echo "</fieldset>";
} //end of displayReviewCourse function()

function displayStudentInfo()
{
    global $connectToDB;
    $sqlStudentInfo = "SELECT student_id, CONCAT(student_fname,' ',student_lname) AS 'fullName' FROM studentInfo "; //selecting a specific table from the already connected to database

    //Run and assign query 
    $data = mysqli_query($connectToDB, $sqlStudentInfo);

    //Headers
    echo "<fieldset class = studentField>";
    echo "<legend class = infoLegend>Student Information:</legend>";

    while ($rows = mysqli_fetch_array($data)) {
        $studentId = $rows['student_id'];
        $studentName = $rows['fullName'];
        if ($studentId == $_SESSION["currentUserLoginId"]) {
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
            echo "<p>Name: " . $studentName . "</p>";
            echo "<p>University Location: Concordia Saint Paul</p> ";
            echo "<p>Major: " . $majorName . "</p>";
            echo "<p>Major Description: " . $majorDescription . "</p>";
            if ($enrollmentStatus == 1) {
                echo "<p>Enrollment Status: Enrolled</p>";
            } else {
                echo "<p>Enrollment Status: Not Enrolled</p>";
            }
        } // end if()
    } //end while()
} //end of displayStudentInfo 

//creating function to get users profile pictures
function getProfilePicture(){
    global $connectToDB;
    $sqlStudentInfo = "SELECT * FROM studentInfo";

    //Run and assign query 
    $data = mysqli_query($connectToDB, $sqlStudentInfo);
     //While loop to retrieve data from studentInfo table. 
     while ($rows = mysqli_fetch_array($data)) {
        $studentId = $rows['student_id'];
        if ($studentId == $_SESSION["currentUserLoginId"]) {
            $picture = $rows['user_image'];
            echo  "<img  src='upload/" . $picture . "' alt='img' id ='profilePictureImage'>";
        }
    }

}
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

function displayAboutStudent()
{
    global $connectToDB;
    $sqlStudentInfo = "SELECT * FROM studentInfo";

    //Run and assign query 
    $data = mysqli_query($connectToDB, $sqlStudentInfo);

    //Headers 
    echo "<fieldset class = otherInfoField>";
    echo "<legend class = otherInfoLegend>Additional Information: </legend>";

    //While loop to retrieve data from studentInfo table. 
    while ($rows = mysqli_fetch_array($data)) {
        $studentId = $rows['student_id'];
        if ($studentId == $_SESSION["currentUserLoginId"]) {
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
} //end of displayAboutStudent()

//Validate if old password first()
function checkOldPassword()
{
    global $connectToDB;

    //Student's inputted old password
    $inputtedOldPassword = $_POST['oldPassword'];
    //Current student id using Sessions
    $studentId = $_SESSION["currentUserLoginId"];

    $sqlStudentInfo = "SELECT user_password FROM userLoginInfo WHERE student_id = '$studentId'";

    $queryPassword = mysqli_query($connectToDB, $sqlStudentInfo);
    $fetchStudentPassword = mysqli_fetch_assoc($queryPassword); //fetching associated record in the database 
    $oldPassword = $fetchStudentPassword['user_password']; //retrieve the user_password value 

    if ($inputtedOldPassword != $oldPassword) {
        return false;
    } else {
        return true;
    }
} //end of checkOldPassword()

//Confirm the new password inputted by the student 
function confirmNewPassword()
{
    $newPassword = $_POST['newPassword'];
    $confirmedNewPassword = $_POST['confirmPassword'];

    if ($newPassword != $confirmedNewPassword) {
        return false;
    } else {
        return true;
    }
} //end of confirmNewPassword

function updateOldPassword()
{
    global $connectToDB;

    //Student's inputted new password
    $inputtedOldPassword = $_POST['newPassword'];
    $studentId = $_SESSION["currentUserLoginId"];

    $sqlUpdatePassword = "UPDATE userLoginInfo SET user_password = '$inputtedOldPassword' WHERE student_id = '$studentId'";
    $queryPasswordUpdate = mysqli_query($connectToDB, $sqlUpdatePassword);
} //end of updateOldPassword()

function updateAboutMe()
{
    global $connectToDB;

    //Student's inputted About me Section
    $social = $_POST['social'];
    $phoneNumber = $_POST['phoneNumber'];
    $birthday = $_POST['birthday'];
    $schoolYear = $_POST['schoolYear'];
    $additionalInfo = $_POST['additionalInfo'];

    $studentId = $_SESSION["currentUserLoginId"];

    $sqlstudentInfoUpdate = "UPDATE studentinfo
        SET student_social= CASE
                                WHEN '$social' = '' THEN student_social
                                ELSE '$social'
                            END,
        student_phoneNumber=CASE
                                WHEN '$phoneNumber' = '' THEN student_phoneNumber
                                ELSE '$phoneNumber'
                            END, 
        student_birthday =  CASE
                                WHEN '$birthday' = '' THEN student_birthday
                                ELSE '$birthday'
                            END, 
        student_year =      CASE
                                WHEN '$schoolYear' = '' THEN student_year
                                ELSE '$schoolYear'
                            END, 
        about_student =     CASE
                                WHEN '$additionalInfo' = '' THEN about_student
                                ELSE '$additionalInfo'
                            END 
        WHERE student_id = $studentId";

    $queryUpdateStudentInfo = mysqli_query($connectToDB, $sqlstudentInfoUpdate);
} //end of updateAboutMe()

function showMessage($message)
{
    echo "<script>";
    echo "alert('$message');";
    echo "window.location.href = 'http://localhost/csc450Capstone/ProfileView/profiles.php';";
    echo "</script>";
}


if (isset($_POST['submitButton'])) {
    updateAboutMe();

    if (!empty($_POST['oldPassword']) && !empty($_POST['newPassword']) && !empty($_POST['confirmPassword'])) {
        if (!checkOldPassword() && !confirmNewPassword()) {
            showMessage("Your confirmation for the both the old password and new password was incorrect. Please re-try both passwords again.");
        }
        if (!checkOldPassword()) {
            showMessage("Your confirmation for the old password was incorrect. Please try again.");
        }
        if (!confirmNewPassword()) {
            showMessage("Your confirmation for the new password was incorrect. Please try again.");
        }
        if (checkOldPassword() && confirmNewPassword()) {
            showMessage("Password has successfully been updated!");
        }
    }
} //end of isset if statement for submit button. 

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="profiles.css">
    <link rel="stylesheet" type="text/css" href="../globalStyle/navBarStyling.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
            <li class="logo" id="logo">CSP Student Profile</li>
            <li class="item"><a href="http://localhost/csc450Capstone/LandingPage/LandingPage.php">Home</a></li>
            <li class="item">   
            
            <?php  navGetProfilePicture(); ?>
             
            </li>
            <li class="item"><a href="http://localhost/csc450Capstone/profileView/profiles.php">Profile</a></li>
            <li class="item"><a href="http://localhost/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a></li>
            <li class="item button"><a href="http://localhost/csc450Capstone/LoginPage/logOut.php">Sign Out</a></li>
    
            <li class="toggle"><span class="bars"></span></li>
        </ul>
    </nav>
<!-- End of Nav Script -->
    <!-- <div class="stickyHead">
        <h1 class="pageName">CSP Student Profile</h1>
        <div class="wrapButton">
            <ul>
                <li id="landingBtn"><a href="http://localhost/csc450Capstone/LandingPage/LandingPage.php">Home</a></li>
                <li id="profileBtn"><a href="http://localhost/csc450Capstone/ProfileView/profiles.php">Profile</a></li>
                <li id="perMajorBtn"><a href="http://localhost/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a></li>
                <li id="loginBtn"><a href="http://localhost/csc450Capstone/LoginPage/logOut.php">Sign Out</a></li>
            </ul>
        </div>
    </div> -->

<!-- code for updating profile picture -->
      <form id="editProfilePictureform" method="POST" action="" enctype="multipart/form-data">
      <button id ="closeButton" type="button" onclick="toggleEditProfilePicture()">X</button>
      <input type="file" id="uploadfile" name="uploadfile" value="Change"/>
        
      <div>
          <button type="submit" name="upload">UPLOAD</button>
        </div>
  </form>

    <!-- End of profile picture update code -->
      <?php
  
  // If upload button is clicked ...
  $msg = "";
  if (isset($_POST['upload'])) {
  
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];    
    $folder = "upload/".$filename;
    $studentId = $_SESSION["currentUserLoginId"];
    
        // Get all the submitted data from the form
        
        global $connectToDB;
        $sqlStudentInfo = "SELECT * FROM studentInfo";
        $data = mysqli_query($connectToDB, $sqlStudentInfo);
        $users = mysqli_fetch_all($data, MYSQLI_ASSOC);

     

        // Execute query
        $sql = "UPDATE studentinfo SET user_image = '$filename' WHERE student_id = '$studentId'";
       
        // this lets us move the uploaded image into the folder: upload
        if (move_uploaded_file($tempname, $folder))  {
            $msg = "Image uploaded successfully";
          
        }else{
            $msg = "Failed to upload image";
      }
     $result = mysqli_query($connectToDB,$sql);
  }

?>
<!-- End of profile picture update code -->


    <!--FORM to update/edit the user's profile information (Passwords, and About me sections) -->
    <form class="editProfileform" id="editProfileform" method="POST">
        <!-- button to close out of the form -->
        <button id ="closeButton" type="button" onclick="toggleEditProfile()">X</button>


        <h1 id="formHeader">Edit Profile Information</h1>
        <h3 id="passwordHeader">Change Password</h3>
       
        <div>
       
            <label for="oldPassword">Enter old password</label> <!-- Creating a label for input type of "text" then giving a name and id to match the lable name-->
            <input type="password" name="oldPassword" id="oldPassword">

            <label for="newPassword">Enter new password</label> <!-- Repeat above, but just change label to newPassword-->
            <input type="password" name="newPassword" id="newPassword">

            <label for="confirmPassword">Confirm new password</label> <!-- Repeat above, but just change label to confirmPassword-->
            <input type="password" name="confirmPassword" id="confirmPassword">
        </div>
        <input type="checkbox" onclick="showPassword()"> Show password
        <!--Reveal the passwords if user wants to using JavaScript-->

        <h3 id="changeAboutMe">Edit About Me Section</h3>
        <div>
            <!-- Allow users to update their ABOUT ME section on the their profile pages. -->
            <label for="social">Socials</label> <!-- type=text for socials -->
            <input type="text" name="social" id="social">

            <label for="phoneNumber">Phone number</label> <!-- type=tel for telephone number -->
            <input type="tel" name="phoneNumber" id="phoneNumber" placeholder="1234321785" pattern="[0-9]{3}[0-9]{3}[0-9]{4}">

            <label for="birthday">Birth Date</label> <!-- Again, Repeat but change the input type -->
            <input type="date" name="birthday" id="birthday">

            <label for="schoolYear">Year of study</label> <!-- select dropdown list for school year EX:senior -->
            <select name="schoolYear" id="schoolYear">
                <option value=""></option>
                <option value="Freshman">Freshman</option>
                <option value="Sophomore">sophomore</option>
                <option value="Junior">Junior</option>
                <option value="Senior">Senior</option>
            </select>
            <br>
            <br>
            <label for="additionalInfo">Add any additional information.</label>
            <textarea name="additionalInfo" id="additionalInfo" cols="25" rows="5"></textarea> <!-- textarea for any additional Info-->


            <!--Turn off overlay form-->
            <!-- <button type="button" onclick="turnOFFoverlayForm()">Cancel</button> -->

            <button type="submit" name="submitButton" id="submitButton" class="submitButton">Submit</button>
        </div>
    </form>
    <!--End of form-->

    <div class="studentInfo">
        <div class="studentDescript1">
            <!-- Edit profile picture button with camera icon -->
             <button type="button" id="editProfilePictureButton" onclick="toggleEditProfilePicture()"><i class="fa fa-camera" ></i></button>
            <!-- using created function to pull correct picture from the database -->
            <div >
            <?php  getProfilePicture(); ?>
            </div>
       
           <!-- button for editing accound information -->
            <button type="button" id="editProfileButton" onclick="toggleEditProfile()">Edit Account</button>
           
        </div>

        <div class="studentDescript2">
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
 // toggle function that will allow the user to exit the form by hitting the Edit Account and X button for better UX
 function toggleEditProfile() {
    var nav = document.getElementById('editProfileform');
  if (nav.offsetWidth == 0 && nav.offsetHeight == 0 ) {
    nav.style.display = 'block';
  } else {
    nav.style.display = 'none';
  }
}//end of toggleEditProfile button function

function toggleEditProfilePicture() {
    var nav = document.getElementById('editProfilePictureform');
  if (nav.offsetWidth == 0 && nav.offsetHeight == 0 ) {
    nav.style.display = 'block';
  } else {
    nav.style.display = 'none';
  }
}//end of toggleEditProfilePicture button function


    //Create the functions to show password for the users if they check the check box 
    function showPassword() {
        //retrieve the two passwords
        var oldPassword = document.getElementById("oldPassword");
        var newPassword = document.getElementById("newPassword");
        var confirmedPassword = document.getElementById("confirmPassword");

        //if the two types for each passwords are type="password", change the type to a text  
        if (oldPassword.type === "password" && newPassword.type === "password" && confirmedPassword.type === "password") {
            oldPassword.type = "text";
            newPassword.type = "text";
            confirmedPassword.type = "text";
        } else { //otherwise change types back to password to hide passwords again. 
            oldPassword.type = "password";
            newPassword.type = "password";
            confirmedPassword.type = "password";
        }
    } //end of showPassword function 
</script>