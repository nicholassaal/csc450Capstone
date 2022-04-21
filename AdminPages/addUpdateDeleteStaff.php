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

    function addNewStaff() {
        global $connectToDB;

        $staffFName = $_POST['staffFName'];
        $staffLName = $_POST['staffLName'];

        $sqlAddStaff = "INSERT INTO professor (prof_fName, prof_lName)
                        VALUES ('$staffFName', '$staffLName')";

        $queryAddStaff = mysqli_query($connectToDB, $sqlAddStaff);

        if ($queryAddStaff) {
            echo"<br><br><br><br><br>";
            echo"Successfull Added new Staff - ".$staffFName."!";
        } else {
            print_r($queryAddStaff);
        }

    } //end of addNewStaff();

    function professorStaffUpdate() {
        global $connectToDB;//global variable to connect to DB 

        //Retrieve all the admin's inputs
        $staffId = $_POST["staffId"]; 
        $staffNewFName = $_POST["staffNewFName"];
        $staffNewLName = $_POST["staffNewLName"];


        //SQL query for updating the professor/staff's name base on the student_id that was entered.
        $sqlUpdateProfName = "UPDATE professor SET prof_fName = '$staffNewFName', prof_lName = '$staffNewLName' WHERE prof_id = '$staffId'"; 

        $queryUpdateProf = mysqli_query($connectToDB, $sqlUpdateProfName); //Run the SQL query 

        if ($queryUpdateProf) { //check if successfull or not
            echo"<br><br><br><br><br>";
            echo"Successfull UPDATED staff '.$staffId.'";
        } else {
            print_r($queryUpdateProf); 
        }
    }//end of professorStaffUpdate()




    if (isset($_POST['addNewStaff'])) {
        addNewStaff();
    }
    if (isset($_POST['updateExistingStaff'])) {
        professorStaffUpdate();
    }
?>

<!DOCTYPE html>
<html>

<head>
    <title>ADMIN Staff Update</title>
    <link rel="stylesheet" type="text/css" href="addUpdateDelete.css">
    <style>
        <?php include("addUpdateDelete.css"); ?>
    </style>
</head>

<body>
    <nav id="navbar">
        <ul>
            <li><a class="adminHome" href="http://localhost/csc450Capstone/AdminPages/adminHome.php">Admin Home</a></li>
            <li><a href="http://localhost/csc450Capstone/LoginPage/logOut.php">Sign Out</a></li>
            <li><a href="http://localhost/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a></li>
            <li><a href="http://localhost/csc450Capstone/LandingPage/LandingPage.php">Users Home</a></li>
        </ul>
        
    </nav>
    

    <!--************************************************************************
        *******************        Staff editing!        ***********************
        ************************************************************************-->
        <form class = "add" method = "POST">
            <div class = "staffEditContainer">
                <fieldset class = "fieldsetStaff">
                    <legend><h1 class = "staffLegend">Staff Editing Template</h1></legend>
                <h1 class = title>Add New Staff</h1>
                    <label for="fname">Enter First Name:</label>
                        <input type="text" id="staffFName" name="staffFName"><br><br>
                    <label for="lname">Enter Last name:</label>
                        <input type="text" id="staffLName" name="staffLName"><br><br>
                    <input type="submit" value="Submit" name = "addNewStaff" id = "addNewStaff"><br><br>



                <h1 class = title>Update Existing Staff</h1>
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
    <br>
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