<?php
//This starts the session for this php page to handle and assign variables
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

// $connectToDB = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD, $DBF_NAME);

// Check connection
//$conn->connect_error: The connect_error property in the $conn (Connection) object. This property contains any error message from the last operation.
if ($connectToDB->connect_error) { //-> is used to point to items contained in an object.
    die("Connection failed: " . $conn->connect_error); //die( ) will kill the current program after displaying the message in the String parameter.
}

function populateMajorDropdown()
{
    global $connectToDB;

    $sqlMajor = "SELECT major_name FROM major";
    $queryMajorName = mysqli_query($connectToDB, $sqlMajor);

    echo "<select name=majors id=majors>";
    while ($rows = mysqli_fetch_array($queryMajorName)) {
        $majorName = $rows['major_name'];
        echo "<option>$majorName</option>";
    }

    echo "</select>";
} //end of populateMajorDropdown()

function populateProfDropdown()
{
    global $connectToDB;

    $sqlProf = "SELECT CONCAT(prof_fName,' ',prof_lName) AS 'fullProfName' FROM professor";
    $queryProfessorTable = mysqli_query($connectToDB, $sqlProf);


    echo "<select name='teacher' id='teacher'>";
    while ($rows = mysqli_fetch_array($queryProfessorTable)) {
        $profName = $rows['fullProfName'];
        echo "<option>$profName</option>";
    }
    echo "</select>";
} //end of populateProfDropdown()

function addACourse()
{
    global $connectToDB; //global variable for the connection to the DB

    $courseName = $_POST["courseName"]; //getting the user's input via POST method to send to the DB
    $teacher = $_POST["teacher"];
    $majorName = $_POST["majors"];
    $msg = $_POST["msg"];
    $yearTaught = $_POST["yearTaught"];

    $splitTeacherName = explode(" ", $teacher);

    //RETRIEVE THE MAJOR ID.................
    $sqlRetrieveMajorId = "SELECT major_id FROM major WHERE major_name ='$majorName'";
    $queryMajorId = mysqli_query($connectToDB, $sqlRetrieveMajorId);
    $fetchMajorId = mysqli_fetch_assoc($queryMajorId); //fetching associated data 
    $majorId = $fetchMajorId['major_id'];

    //ADD THE COURSE INTO THE COURSE TABLE
    $sqlcourseTable = "INSERT INTO course (course_name, course_description, major_id) VALUES ('$courseName', '$msg', '$majorId')";
    $queryInsertCourse = mysqli_query($connectToDB, $sqlcourseTable);

    //RETRIEVE THE PROFESSOR ID.................
    $sqlRetrieveProfId = "SELECT prof_id FROM professor WHERE prof_fName = '$splitTeacherName[0]' AND prof_lName = '$splitTeacherName[1]'";
    $queryProfId = mysqli_query($connectToDB, $sqlRetrieveProfId);
    $fetchProfId = mysqli_fetch_assoc($queryProfId); //fetching associated data 
    $profId = $fetchProfId['prof_id'];

    //RETRIEVE THE COURSE CODE.................
    $sqlRetrieveCourseCode = "SELECT course_code FROM course ORDER BY course_code DESC LIMIT 1";
    $queryCourseCode = mysqli_query($connectToDB, $sqlRetrieveCourseCode);
    $fetchCourseCode = mysqli_fetch_assoc($queryCourseCode); //fetching associated data 
    $courseCode = $fetchCourseCode['course_code'];

    //ADD THE PROFESSOR THAT IS TEACHING THE COURSE INTO THE professorcourse table 
    $sqlProfCourseTable = "INSERT INTO professorcourse (prof_id, course_code, year_taught) VALUES ('$profId', '$courseCode', '$yearTaught')";
    $queryInsertProfCourse = mysqli_query($connectToDB, $sqlProfCourseTable);
} //end of addACourse()

function courseUpdate()
{
    global $connectToDB; //global variable for the connection to the DB

    $courseName     = $_POST["courseName"]; //getting the user's input via POST method to send to the DB
    $courseId       = $_POST["courseId"];
    $majorName      = $_POST["majors"];
    $msg            = $_POST["msg"];

    $sqlRetrieveMajorId = "SELECT major_id FROM major WHERE major_name ='$majorName'";
    $queryMajorId = mysqli_query($connectToDB, $sqlRetrieveMajorId);
    $fetchMajorId = mysqli_fetch_assoc($queryMajorId); //fetching associated data 
    $majorId = $fetchMajorId['major_id'];

    $sqlUpdatecourse = "UPDATE course SET course_name = '$courseName', course_description = '$msg', major_id = '$majorId' WHERE course_code = '$courseId'";
    $queryUpdateCourse = mysqli_query($connectToDB, $sqlUpdatecourse); //Run the SQL query 


    if ($queryUpdateCourse) { //check if successfull or not
        
    } else {
        print_r($queryUpdateCourse);
    }
} //end of courseUpdate()


function courseDelete()
{
    global $connectToDB;

    $courseId = $_POST["courseIdDel"];
    $courseName = $_POST["courseNameDel"];

    $sqlDeleteCourse = "DELETE FROM course WHERE course_code = '$courseId' AND course_name = '$courseName'";
    $sqlDeleteStudentCourse = "DELETE FROM studentcourse WHERE course_code = '$courseId'";
    $sqlDeleteProfCourse = "DELETE FROM professorcourse WHERE course_code = '$courseId'";

    $queryChildDelete = mysqli_query($connectToDB, $sqlDeleteStudentCourse)
        and mysqli_query($connectToDB, $sqlDeleteProfCourse);

    $queryDelete = mysqli_query($connectToDB, $sqlDeleteCourse);

    if ($queryChildDelete and $queryDelete) {
        echo "Course - " . $courseName . " - was deleted!";
    } else {
        print_r($connectToDB);
        echo "ERROR: <br>";
        mysqli_error($connectToDB);
        echo "<br>";
    }
}

function displayCourseTable()
{
    global $connectToDB;

    $sqlcourseTable = "SELECT * FROM course";
    $querycourseTable = mysqli_query($connectToDB, $sqlcourseTable);

    echo "<fieldset class = courseFieldSet>"; //Writing out a fieldset and legend for format purposes for CSSing and UX
    echo "<legend><h2 class = courseLegend>Course's Info</h2></legend>";
    echo "<table class = courseTable>";
    echo "<tr>";
    echo "<th class = courseHeader>Course Code</th>";
    echo "<th class = courseHeader>Course Name</th>";
    echo "<th class = courseHeader>Major</th>";
    echo "</tr>";

    while ($courseRow = mysqli_fetch_array($querycourseTable)) {
        $courseCode = $courseRow['course_code'];
        $courseName = $courseRow['course_name'];
        $majorId = $courseRow['major_id'];

        $sqlMajorTable = "SELECT * FROM major WHERE major_id = $majorId";
        $queryMajorTable = mysqli_query($connectToDB, $sqlMajorTable);

        $majorTableRow = mysqli_fetch_assoc($queryMajorTable);
        $majorName = $majorTableRow['major_name'];

        echo "<tr>";
        echo "<td class = courseHeader>" . $courseCode . "</td>";
        echo "<td class = courseHeader>" . $courseName . "</td>";
        echo "<td class = courseHeader>" . $majorName . "</td>";
        echo "</tr>";
    } //end of while loop 
    echo "</table>";
    echo "</fieldset>";
    if ($querycourseTable && $queryMajorTable) {
    } else {
        print_r($querycourseTable); //error print if something goes wrong
        print_r($queryMajorTable);
    }
} // end of displayCourseTable()


if (isset($_POST['updateCourse'])) { //isset is looking for the action of the button being pressed named ['updateCourse']
    courseUpdate(); //when the button is pressed, it will execute the function studentAdding();
}
if (isset($_POST['addCourse'])) { //isset is looking for the action of the button being pressed named ['updateCourse']
    addACourse(); //when the button is pressed, it will execute the function studentAdding();
}
if (isset($_POST['deleteCourse'])) {
    courseDelete();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="courseUpdate.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <title>Review page </title>
</head>

<body>

    <nav id="navbar">
        <ul>
            <li><a class="adminHome" href="https://thewoodlandwickcandleco.com/csc450Capstone/AdminPages/adminHome.php">Admin Home</a></li>
            <li><a href="https://thewoodlandwickcandleco.com/csc450Capstone/LoginPage/logOut.php">Sign Out</a></li>
            <li><a href="https://thewoodlandwickcandleco.com/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a></li>
            <li><a href="https://thewoodlandwickcandleco.com/csc450Capstone/LandingPage/LandingPage.php">Users Home</a></li>

            <!-- <li><a class="adminHome" href="http://localhost/csc450Capstone/AdminPages/adminHome.php">Admin Home</a></li>
        <li><a href="http://localhost/csc450Capstone/LoginPage/logOut.php">Sign Out</a></li>
        <li><a href="http://localhost/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a></li>
        <li><a href="http://localhost/csc450Capstone/LandingPage/LandingPage.php">Users Home</a></li> -->
        </ul>
    </nav>
    <div class="wrapper">



        <!--************************************************************************
            *******************         ADD A COURSE         ***********************
            ************************************************************************-->
        <h1 class="formHeaders">Add a course</h1>
        <form action="" method="POST" class="form-area">
            <div class="msg-area">
                <label for="msg">Course Description</label>
                <textarea id="msg" name="msg"></textarea>
            </div>
            <div class="details-area">
                <label for="courseName">Course Name</label>
                <input type="text" name="courseName" id="courseName">

                <label for="teachers">Select the professor:</label>
                <?php populateProfDropdown() ?>
                <br>
                <label for="yearTaught">Year Taught</label>
                <input type="text" name="yearTaught" id="yearTaught">

                <label for="major">Select the major:</label>
                <?php populateMajorDropdown() ?>

                <br>
                <button type="submit" value="Submit" name="addCourse" id="addCourse">Submit</button>
            </div>
        </form>

        <!--************************************************************************
            *******************        UPDATE A COURSE       ***********************
            ************************************************************************-->
        <h1 class="formHeaders">Update a course</h1>
        <form action="" method="POST" class="form-area">
            <div class="msg-area">
                <label for="msg">Course Description</label>
                <textarea id="msg" name="msg"></textarea>
            </div>
            <div class="details-area">
                <label for="courseId">Course Id</label>
                <input type="text" name="courseId" id="courseId">

                <label for="courseName">Course Name</label>
                <input type="text" name="courseName" id="courseName">

                <label for="majors">Select the major:</label>

                <?php populateMajorDropdown() ?>

                <button type="submit" value="Submit" name="updateCourse" id="updateCourse">Submit</button>
            </div>
        </form>


        <!--************************************************************************
            *******************        DELETE A COURSE       ***********************
            ************************************************************************-->
        <h1 class="formHeaders">Delete a course</h1>
        <form action="" method="POST" class="form-area">
            <div class="details-area">
                <label for="courseId">Course Id</label>
                <input type="text" name="courseIdDel" id="courseIdDel">

                <label for="courseName">Course Name</label>
                <input type="text" name="courseNameDel" id="courseNameDel">

                <button type="submit" value="Submit" name="deleteCourse" id="deleteCourse">Submit</button>
            </div>
        </form>

    </div>

    <?php displayCourseTable() ?>
</body>

</html>

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