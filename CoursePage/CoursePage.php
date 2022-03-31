<?php

include "coursePage_inc.php";
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
$courseCode = $_GET["id"]; //Retrieve the course_code that was sent over from the Major Page



function displayCourseTitle()
{
    global $connectToDB;
    global $courseCode;

    $sqlStudentCourse = "SELECT * FROM course WHERE course_code =  $courseCode"; //Retrieve the course info using the course_code that was sent from what the user Clicked on in MajorPage

    //Run and assign query 
    $data = mysqli_query($connectToDB, $sqlStudentCourse);


    while ($rows = mysqli_fetch_array($data)) {
        $courseName = $rows['course_name']; //Retrieve course_name
        $courseDes = $rows['course_description']; //Retrieve course_name

    }

    //Display course info (course_name, course_description)
    echo "<h1>" . $courseName . "</h1>";
    echo "<h2>" . $courseDes . "</h1>";
} //end of displayCourseTitle()

function featuredCourseReviews() {
    global $connectToDB;
    global $courseCode;

    $sqlFeaturedReviews = "SELECT * FROM studentcourse WHERE course_code = $courseCode";

    $sqlFeaturedQuery = mysqli_query($connectToDB, $sqlFeaturedReviews);

    while ($rowsOverallReview = mysqli_fetch_array($sqlFeaturedQuery)) {
        $topReviewsNumbers = $rowsOverallReview['overall_review_rating'];
        $topReviews[] = $topReviewsNumbers;
    } //end of while()

    sort($topReviews); //sorting the array created for 'overall_review_rating' from least to greatest [1,2,3,4...]

    if (count($topReviews) >= 3) {
        echo "<h3>Featured Reviews</h3>";
        echo "<div class=lower-flex-container>";
        for($i = count($topReviews)-1; $i >= count($topReviews)-3; $i--) {
            $storedFeaturedReviews[] = $topReviews[$i];   
        }
        for($t = 0; $t < count($storedFeaturedReviews); $t++) {
            $sqlSelectingFeatured = "SELECT * FROM studentcourse WHERE overall_review_rating = $storedFeaturedReviews[$t] AND course_code = $courseCode";
            $selectingFeaturedQuery = mysqli_query($connectToDB, $sqlSelectingFeatured);
            $studentCourseTableRow = mysqli_fetch_array($selectingFeaturedQuery);

            $topReviews = $studentCourseTableRow['review_message'];
            $topStudentId = $studentCourseTableRow['student_id'];

            $sqlSelectingFeatured = "SELECT CONCAT(student_fname,' ',student_lname) AS 'fullName' FROM studentInfo WHERE student_id = $topStudentId";
            $topStudentQuery = mysqli_query($connectToDB, $sqlSelectingFeatured);
            $studentTableRow = mysqli_fetch_array($topStudentQuery);

            $topStudentName = $studentTableRow['fullName'];
                
            if($topStudentQuery && $selectingFeaturedQuery) {
                echo "<div>";
                    echo "<h1>".$topStudentName."</h1>";
                    echo "<h2>".$topReviews."</h2>";
                echo "</div>";
            } else {
                print_r($connectToDB);
                print_r($selectingFeaturedQuery);
            }
        } //end of 2nd for()
        echo "</div>";

    } else {
        echo "<script> document.getElementById(featuredReviews).style.display = none; </script>";
    }
    

    
    


    //print_r($topReviews);
} //end of featuredCourseReviews()

function displayCourseReviewMessage()
{
    global $connectToDB;
    global $courseCode;

    
    //Retrieve the review message in studentCourse table
    $sqlStudentCourse = "SELECT * FROM studentcourse WHERE course_code = $courseCode";


    //Run and assign query 
    $data = mysqli_query($connectToDB, $sqlStudentCourse);

    $arrayIndex = 0;
    $ReviewRating = 1;

    while ($rows = mysqli_fetch_array($data)) {
        
        $courseReviewMessage = $rows['review_message']; //Retrieve the review_message
        $studentID = $rows['student_id']; //Retrieve the student_id in studentCourse Table

        $studentIdArray[] = $studentID;

        /*************** WORKING ON ***************/

        $sqlReviewRating = "SELECT overall_review_rating FROM studentcourse WHERE student_id = $studentID AND course_code = $courseCode";

        $sqlReviewQuery = mysqli_query($connectToDB, $sqlReviewRating);
        $retrieveReview = mysqli_fetch_assoc($sqlReviewQuery);

        $reviewRatings = $retrieveReview['overall_review_rating'];

        echo $reviewRatings;
        echo "<form method=POST>";
            echo "<button type = submit name = reviewBtn$ReviewRating id = reviewBtn$ReviewRating> Like the Review </button>";
        echo "</form>";

        if(isset($_POST['reviewBtn'.$ReviewRating])){
            $sqlUpdateReviewRating = "UPDATE studentcourse SET overall_review_rating = $reviewRatings+1 WHERE student_id = $studentID AND course_code = $courseCode";
            $sqlUpdateReviewQuery = mysqli_query($connectToDB, $sqlUpdateReviewRating);
            if ($sqlUpdateReviewQuery) {

            } else {
                print_r($sqlUpdateReviewQuery);
            }
        } //if(isset($_POST[]))

        /*************** WORKING ON ***************/

        //Retrieve the student id and full name using CONCAT()
        $sqlStudentInfo = "SELECT CONCAT(student_fname,' ',student_lname) AS 'fullName' FROM studentInfo
            WHERE student_id = $studentID";

        //Run query 
        $sqlStudentTable = mysqli_query($connectToDB, $sqlStudentInfo);
        $retrieveStudentName = mysqli_fetch_assoc($sqlStudentTable);

        //Assign the fullname to a variable once retrieved above 
        $studentName = $retrieveStudentName['fullName'];

        //Display reviews 
        echo "<div> <a name = $studentID>";
        echo "<h1>" . $studentName . "</h1>";
        echo "<button type = button name = submit class = btn id = btn>  
                        <a href = http://localhost/csc450Capstone/profileView/otherProfile.php?uid=$studentIdArray[$arrayIndex]>View Profile</a> 
                      </button>";
        echo "<h2>" . $courseReviewMessage . "</h1>";
        echo "</a> </div>";
        $arrayIndex++;
        $ReviewRating++;
    
    } //end of while loop 
} //end of displayCourseReviewMessage()

function correctTitle() {
    global $connectToDB;
    $courseCode = $_GET["id"];

    $sqlStudentCourse = "SELECT * FROM course WHERE course_code =  $courseCode"; //Retrieve the course info using the course_code that was sent from what the user Clicked on in MajorPage

    //Run and assign query 
    $data = mysqli_query($connectToDB, $sqlStudentCourse);


    while ($rows = mysqli_fetch_array($data)) {
        $courseName = $rows['course_name']; //Retrieve course_name
    }

    echo $courseName;
}

// if(isset($_POST['reviewBtn'])){
//     echo "<br><br><br><br><br><br><br><br><br><br><br>";
//     echo "CONGRATS YOU PRESSED A BUTTON, WELL DONE!";
// }
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
            echo  "<img  src='/csc450Capstone/profileView/upload/" . $picture . "' alt='img' id ='navImage'>";
        }
    }

}//end of navGetProfilePicture()
?>

<!DOCTYPE html>
<html>

<head>
    <title><?php correctTitle(); ?></title>
    <link rel="stylesheet" type="text/css" href="CoursePage.css">
    <link rel="stylesheet" type="text/css" href="../globalStyle/navBarStyling.css">
</head>

<body>
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
            <li class="logo" id="logo">CSP Course Page</li>
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

    <div class="upper-flex-container">

        <!-- Display course title at the top using the php function -->
        <?php displayCourseTitle(); ?>

        <!-- <h1>Course Name</h1>
        <h2>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Iure facere ea eaque, vel odit minus id,
            perferendis eos tenetur earum est doloremque possimus dignissimos nam at voluptatibus optio unde esse. Lorem
            ipsum dolor sit amet consectetur adipisicing elit. Harum, ea ad vitae accusamus aliquid minus perferendis,
            provident dolore explicabo quod nemo eos! Totam ducimus quasi enim repellat, harum libero debitis!</h2> -->
        <button type="button" id="editProfileButton" onclick="turnOnOverlayForm()">Leave a Review</button>
    </div>

    <!-- Leave review overlay. Displayed using button above. Hidden when function tied to cancel button is called -->

    <form method="POST" class="leaveReviewForm" id="leaveReviewForm">
        <div>
            <h3>Question 1</h3>
            <textarea rows="5" cols="50"></textarea>
        </div>
        <div>
            <h3>Question 2</h3>
            <textarea rows="5" cols="50"></textarea>
        </div>
        <div>
            <h3>Question 3</h3>
            <textarea rows="5" cols="50"></textarea>
        </div>
        <div>
            <h3>Any Additional Comments?</h3>
            <textarea rows="5" cols="50"></textarea>
        </div>
        <!--Turn off overlay form-->
        <button type="button" onclick="turnOFFoverlayForm()">Cancel</button>

        <button type="submit" name="submitButton" id="submitButton" class="submitButton">Submit</button>
    </form>

    <div id = "featuredReviews">
            <?php featuredCourseReviews(); ?>
    </div>
    

    <form method="POST">
        <h3>All Reviews</h3>
        <div class="review-flex-container">
            <!--Called php function to the review message for that specific course -->
            <?php displayCourseReviewMessage(); ?>
        </div>
    </form>
    <script>
        document.getElementById("leaveReviewForm").style.display = "none";

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
        //Function to display the leave review overlay
        function turnOnOverlayForm() {
            document.getElementById("leaveReviewForm").style.display = "block";
        } //end of overlayForm()

        //function to turn off the overlay form 
        function turnOFFoverlayForm() {
            document.getElementById("leaveReviewForm").style.display = "none";
        }
    </script>
</body>

</html>