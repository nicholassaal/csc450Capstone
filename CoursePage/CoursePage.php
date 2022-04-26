<?php
session_start();
include "coursePage_inc.php";
date_default_timezone_set('America/Chicago');


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

function featuredCourseReviews()
{
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
        echo "<h3 class=subHeader>Featured Reviews</h3>";
        echo "<div class=lower-flex-container>";
        for ($i = count($topReviews) - 1; $i >= count($topReviews) - 3; $i--) {
            $storedFeaturedReviews[] = $topReviews[$i];
        }
        for ($t = 0; $t < count($storedFeaturedReviews); $t++) {
            $sqlSelectingFeatured = "SELECT * FROM studentcourse WHERE overall_review_rating = $storedFeaturedReviews[$t] AND course_code = $courseCode";
            $selectingFeaturedQuery = mysqli_query($connectToDB, $sqlSelectingFeatured);
            $studentCourseTableRow = mysqli_fetch_array($selectingFeaturedQuery);

            $topReviews = $studentCourseTableRow['review_message'];
            $topStudentId = $studentCourseTableRow['student_id'];

            $sqlSelectingFeatured = "SELECT CONCAT(student_fname,' ',student_lname) AS 'fullName' FROM studentinfo WHERE student_id = $topStudentId";
            $topStudentQuery = mysqli_query($connectToDB, $sqlSelectingFeatured);
            $studentTableRow = mysqli_fetch_array($topStudentQuery);

            $topStudentName = $studentTableRow['fullName'];

            if ($topStudentQuery && $selectingFeaturedQuery) {
                echo "<div>";
                echo "<h1>" . $topStudentName . "</h1>";
                echo "<h2>" . $topReviews . "</h2>";
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


function correctTitle()
{
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
    <title><?php correctTitle(); ?></title>
    <link rel="stylesheet" type="text/css" href="CoursePage.css">
    <link rel="stylesheet" type="text/css" href="../globalStyle/navBarStyling.css">
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
            <li class="logo" id="logo">CSP Course Page</li>
            <li class="item"><a href="http://thewoodlandwickcandleco.com/csc450Capstone/LandingPage/LandingPage.php">Home</a></li>
            <li class="item">
                <div id="navImage">
                    <?php navGetProfilePicture() ?>
                </div>
            </li>
            <li class="item"><a href="http://thewoodlandwickcandleco.com/csc450Capstone/profileView/profiles.php">Profile</a></li>
            <li class="item"><a href="http://thewoodlandwickcandleco.com/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a></li>
            <li class="item button"><a href="http://thewoodlandwickcandleco.com/csc450Capstone/LoginPage/logOut.php">Sign Out</a></li>

            <li class="toggle"><span class="bars"></span></li>
        </ul>

        <!-- <ul class="menu">
            <li class="logo" id="logo">CSP Course Page</li>
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

    <div class="upper-flex-container">

        <!-- Display course title at the top using the php function -->
        <?php displayCourseTitle(); ?>
        <?php writtenReviewCheck(); ?>
    </div>

    <!-- Leave review overlay. Displayed using button above. Hidden when function tied to cancel button is called -->
    <form method="POST" id="leaveReviewForm" action="formActions.php?id=<?php echo $courseCode; ?>">
        <div class="leaveReviewForm">
            <div>
                <h3>What did you learn?</h3>
                <br>
                <textarea id="question1" name="question1" rows="5" cols="30" required></textarea>
            </div>
            <div>
                <h3>How would you suggest others prepare for this course?</h3>
                <textarea id="question2" name="question2" rows="5" cols="30" required></textarea>
            </div>
            <div>
                <h3>What did you find the most challenging about this course?</h3>
                <textarea id="question3" name="question3" rows="5" cols="30" required></textarea>
            </div>
            <div class="addComment">
                <h3>Additional comments:</h3>
                <textarea id="reviewMessage" name="reviewMessage" rows="5" cols="30" required></textarea>
            </div>
            <!--Turn off overlay form-->

        </div>
        <!-- hidden values needed to be sent over to the form action page. -->
        <input type='hidden' name='dateWritten' value="<?php echo "" . date("Y-m-d") . ""; ?>">
        <!--Turn off overlay form-->
        <button type="button" onclick="toggleLeavingReview()" class="reviewButton">Cancel</button>
        <button type="submit" name="submitReviewButton" id="submitReviewButton">Submit</button>
    </form>

    <div id="featuredReviews">
        <?php featuredCourseReviews(); ?>
    </div>


    <h3 class="subHeader">All Reviews</h3>
    <!-- <div class="review-flex-container"> -->
    <!--Called php function to the review message for that specific course -->
    <?php displayCourseReviewMessage(); ?>
    <!-- </div> -->

    <footer>
        <a href="">Group 1 CSC 450 Capstone Neng Yang | Josiah Skorseth | Mitchell Williamson | Nicholas Saal</a>
    </footer>

</body>

</html>

<script>
    document.getElementById("leaveReviewForm").style.display = "none";
    /******************************************
     *********   HIDE ALL REPLY FROMS   *********
     ********************************************/
    var maxReviewsNum = <?php echo $numIterator ?>;
    for (let i = 0; i < maxReviewsNum; i++) {
        document.getElementById("replyForms" + i).style.display = "none";
    }

    var maxReviewsNum = <?php echo $numIterator2 ?>;
    var replyToReplyForms = document.getElementsByClassName("replytoReplyForms");
    for (let j = 0; j < maxReviewsNum; j++) {
        replyToReplyForms[j].style.display = "none";
    }

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

    /******************************************
     *******     TOGGLE REVIEW FORM      *******
     ********************************************/
    function toggleLeavingReview() {
        var reviewForm = document.getElementById('leaveReviewForm');
        if (reviewForm.offsetWidth == 0 && reviewForm.offsetHeight == 0) {
            reviewForm.style.display = 'block';
        } else {
            reviewForm.style.display = 'none';
            document.getElementById('question1').value = '';
            document.getElementById('question2').value = '';
            document.getElementById('question3').value = '';
            document.getElementById('reviewMessage').value = '';
        }
    } //end of toggleEditProfilePicture button function


    /******************************************
     *****   TOGGLE EDIT REVIEW FORMS *****
     ********************************************/
    const editReviewBtns = document.querySelectorAll('.editReviewFormBtn');
    for (let i = 0; i < editReviewBtns.length; i++) {
        editReviewBtns[i].addEventListener('click', () => {
            for (let j = 0; j < editReviewBtns.length; j++) {
                editReviewBtns[j].classList.remove('active');
            }

            editReviewBtns[i].innerHTML = "Cancel";
            editReviewBtns[i].classList.add('active');

            var editreplyForms = document.getElementById("editReviewForm");
            if (editreplyForms.offsetWidth == 0 && editreplyForms.offsetHeight == 0) {
                editreplyForms.style.display = 'block';
            } else {
                editReviewBtns[i].style.color = "white";
                editReviewBtns[i].innerHTML = "Edit";
                editreplyForms.style.display = 'none';
            }
        })
    } //end of for loop for editFormBtns

    /******************************************
     *********   TOGGLE REPLY FROMS   *********
     ********************************************/
    const replyBtns = document.querySelectorAll('.replyBtn');
    for (let i = 0; i < replyBtns.length; i++) {
        replyBtns[i].addEventListener('click', () => {
            for (let j = 0; j < replyBtns.length; j++) {
                replyBtns[j].classList.remove('active');
            }

            replyBtns[i].innerHTML = "Cancel";
            replyBtns[i].style.color = "rgb(255, 112, 112)";
            replyBtns[i].classList.add('active');

            var replyForms = document.getElementById("replyForms" + i);
            if (replyForms.offsetWidth == 0 && replyForms.offsetHeight == 0) {
                replyForms.style.display = 'block';
            } else {
                replyBtns[i].style.color = "white";
                replyBtns[i].innerHTML = "Reply";
                document.getElementsByClassName("replyMessage")[i].value = '';
                replyForms.style.display = 'none';
            }
        })
    } //end of for loop for replyBtns

    /******************************************
     *****   TOGGLE REPLY TO REPLY FROMS   *****
     ********************************************/
    const replyToReplyBtns = document.querySelectorAll('.replyToReplyBtn');
    for (let i = 0; i < replyToReplyBtns.length; i++) {
        replyToReplyBtns[i].addEventListener('click', () => {
            for (let j = 0; j < replyToReplyBtns.length; j++) {
                replyToReplyBtns[j].classList.remove('active');
            }
            replyToReplyBtns[i].innerHTML = "Cancel";
            replyToReplyBtns[i].style.color = "rgb(255, 112, 112)";
            replyToReplyBtns[i].classList.add('active');

            var replyForms = document.getElementById("replytoReplyForms" + i);
            if (replyForms.offsetWidth == 0 && replyForms.offsetHeight == 0) {
                replyForms.style.display = 'block';
            } else {
                replyToReplyBtns[i].style.color = "white";
                replyToReplyBtns[i].innerHTML = "Reply";
                document.getElementsByClassName("replyToReplyMessage")[i].value = '';
                replyForms.style.display = 'none';
            }
        })
    } //end of for loop for replyToReplyBtns
</script>