<?php 
    //This starts the session for this php page to handle and assign variables
    session_start();
    $SERVER_NAME    = "localhost";   //Server name 
    $DBF_USER       = "root";        //UserName for the localhost database
    $DBF_PASSWORD   = "";       //Password for the localhost database/ When using XAMPPS, make this value emtpy. Use: $DBF_PASSWORD   = "";
    $DBF_NAME       = "CSPCourseReview";    //DB name for the localhost database

    $connectToDB = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD, $DBF_NAME);

    // Check connection
    //$conn->connect_error: The connect_error property in the $conn (Connection) object. This property contains any error message from the last operation.
    if ($connectToDB->connect_error) { //-> is used to point to items contained in an object.
        die("Connection failed: " . $conn->connect_error); //die( ) will kill the current program after displaying the message in the String parameter.
    }

    function studentAdding() { //function used for inserting the students first name, last name, user name, and password
        global $connectToDB; //global variable for the connection to the DB

        $createStudentUser = $_POST["createStudentUser"]; //getting the user's input via POST method to send to the DB
        $createStudentPass = $_POST["createStudentPass"];
        $studentFName = $_POST["studentFName"];
        $studentLName = $_POST["studentLName"];

        

        $sqlInsertStudentName = "INSERT INTO studentinfo (student_fName, student_lName)
                                VALUES('$studentFName', '$studentLName')"; //sending student first name and last name to the DB with the values of the Admin's input

        $queryUser = mysqli_query($connectToDB, $sqlInsertStudentName); //querying that data for the DB (sending variable)

        $sqlRetrieveStudentId = "SELECT student_id FROM studentinfo ORDER BY student_id DESC LIMIT 1"; //selects the last row from student_id inside of studentinfo (table)
                                                                                                       // This is important since we are taking the information that was queried for that new student, and appending that student_id to match with their user login info
        $queryRetrievedStudentId = mysqli_query($connectToDB, $sqlRetrieveStudentId); //querying the the newly selected student_id (last row)

        $fetchStudentId = mysqli_fetch_assoc($queryRetrievedStudentId); //fetching associated data in that collumn at the last row
        $studentId = $fetchStudentId['student_id']; //applying $studentId to the last row of student_id

        
        $sqlInsertStudentUser = "INSERT INTO userlogininfo (user_name, user_password, is_admin, student_id)
                                VALUES('$createStudentUser','$createStudentPass', 0, '$studentId')"; //sending the user credentials for that student being created by the admin

        $queryStudentName = mysqli_query($connectToDB, $sqlInsertStudentUser); //query that user credentials 

        if ($queryUser AND $queryStudentName) { //execute query
            //empty for clean purposes
        } else {
            print_r($queryStudentName); //prints out an error message when something fails
        }
    }


    if(isset($_POST['addNewStudent'])) { //isset is looking for the action of the button being pressed named ['addNewStudent']
        studentAdding(); //when the button is pressed, it will execute the function studentAdding();
    }







?>




<!DOCTYPE html>
<html>

<head>
    <title>ADMIN Student/Staff Update</title>
    <link rel="stylesheet" type="text/css" href="addUpdateDelete.css">
</head>

<body>
    <nav id="navbar">
        <ul>
            <li>
                <h1>Update Student/Staff Info</h1>
            </li>
            <li style="float: right"><a href="http://localhost/csc450Capstone/LoginPage/LoginPage.php">Sign Out</a></li>
            <li style="float: right"><a href="http://localhost/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a>
            </li>
            <li style="float: right"><a href="http://localhost/csc450Capstone/profileView/profiles.php">My Profile</a>
            </li>
            <li style="float: right"><a href="http://localhost/csc450Capstone/LandingPage/LandingPage.php">Home</a></li>
        </ul>
        
    </nav>

    <!--************************************************************************
        *******************       Student editing!       ***********************
        ************************************************************************-->
    <form class = "add" method = "POST">
        <div class = "studentEditContainer">
            <fieldset class = "fieldsetStudent">
                <legend><h1 class = "studentLegend">Student Editing Template</h1></legend>
                <h1>Add New Student</h1>
                    <label for="lname">Enter Student Username:</label>
                        <input type="text" id="createStudentUser" name="createStudentUser"><br><br>
                    <label for="lname">Enter Student Password:</label>
                        <input type="text" id="createStudentPass" name="createStudentPass"><br><br>

                    <label for="fname">Enter First Name:</label>
                        <input type="text" id="studentFName" name="studentFName"><br><br>
                    <label for="lname">Enter Last name:</label>
                        <input type="text" id="studentLName" name="studentLName"><br><br>

                    <input type="submit" value="Submit" name = "addNewStudent" id = "addNewStudent"><br><br>

                <h1>Update Existing Student</h1>
                    <label for = "studentId">Enter Student ID:</label>
                        <input type = "text" id = "studentId" name = "studentId"><br><br>
                    <label for="fname">Enter New First Name:</label>
                        <input type="text" id="studentNewFName" name="studentNewLName"><br><br>
                    <label for="lname">Enter New Last name:</label>
                        <input type="text" id="studentNewLName" name="studentNewLName"><br><br>
                    <input type="submit" value="Submit" name = "updateExistingStudent" id = "updateExistingStudent"><br><br>
            

                <h1>Delete Existing Student Account</h1>
                    <label for="fname">Enter Student User Id:</label>
                        <input type="text" id="StudentUserId" name="StudentUserId"><br><br>
                    <label for="lname">Enter Student Username:</label>
                        <input type="text" id="StudentUsername" name="StudentUsername"><br><br>
                    <input type="submit" value="Submit" name = "deleteExistingUser" id = "deleteExistingUser"><br><br>
            </fieldset>
        <div>

    <!--************************************************************************
        *******************        Staff editing!        ***********************
        ************************************************************************-->
        <div class = "staffEditContainer">
            <fieldset class = "fieldsetStaff">
                <legend><h1 class = "staffLegend">Staff Editing Template</h1></legend>
            <h1>Add New Staff</h1>
                <label for="fname">Enter First Name:</label>
                    <input type="text" id="staffFName" name="staffFName"><br><br>
                <label for="lname">Enter Last name:</label>
                    <input type="text" id="staffLName" name="staffLName"><br><br>
                <input type="submit" value="Submit" name = "addNewStaff" id = "addNewStaff"><br><br>



            <h1>Update Existing Staff</h1>
                <label for="fname">Enter Staff ID:</label>
                    <input type="text" id="staffId" name="staffId"><br><br>
                <label for="fname">Enter New First Name:</label>
                    <input type="text" id="staffNewFName" name="staffNewFName"><br><br>
                <label for="lname">Enter New Last name:</label>
                    <input type="text" id="staffNewLName" name="staffNewLName"><br><br>
                <input type="submit" value="Submit" name = "updateExistingStaff" id = "updateExistingStaff"><br><br>
            </fieldset>    
        </div>
        
    </form> 
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