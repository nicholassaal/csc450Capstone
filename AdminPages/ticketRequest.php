<?php 
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

    function populateStudentDropDown() { 
        global $connectToDB;
        $sqlTicketStudentId = "SELECT student_id FROM ticketrequest";
        $queryTicketStudentId = mysqli_query($connectToDB, $sqlTicketStudentId);

        echo "<form method = 'POST'>";
            echo"<select name = studentSelect id = studentSelect size = '1'>";
                echo "<option value = '-1'>Please Select a Student</option>";
                while($studentTicketRows = mysqli_fetch_array($queryTicketStudentId)){
                    $studentID = $studentTicketRows['student_id'];
                    $sqlStudentInfo = "SELECT * FROM studentInfo WHERE student_id = $studentID";
                    $queryStudentInfo = mysqli_query($connectToDB, $sqlStudentInfo);

                    while($rows = mysqli_fetch_array($queryStudentInfo)) { 
                        $studentName = $rows['student_fName']." ".$rows['student_lName'];
                        $studentInfoID = $rows['student_id'];
                        echo"<option value = $studentInfoID>$studentName</option>";

                    }//end Inner while()
                }// end outer while()
            echo"</select>";
            echo "<input type = submit name = ddlSubmit id = ddlSubmit class = ddlSubmit value = 'Select this Student'>";
        echo "</form>";
    }//end of populateMajorDropdown()


    function displayTicketTable() {
        global $connectToDB;

        $sqlTicketTable = "SELECT * FROM ticketRequest";
        $ticketQuery = mysqli_query($connectToDB, $sqlTicketTable);

        if ($ticketQuery) {
            echo "<fieldset class = ticketFieldset>"; //Writing out a fieldset and legend for format purposes for CSSing and UX
                echo "<legend><h2 class = ticketLegend>Student Request Changes</h2></legend>";
                echo "<form method = 'POST'>";
                    echo "<table class = ticketTable>";
                        echo "<tr>";
                            echo "<th class = ticketHeader>First Name Change</th>";
                            echo "<th class = ticketHeader>Last Name Change</th>";
                            echo "<th class = ticketHeader>Major Change</th>";
                            echo "<th class = ticketHeader>Enrollment Change</th>";
                            echo "<th class = ticketHeader>On-Campus Change</th>";
                            echo "<th class = ticketHeader>Student Id</th>";
                        echo "</tr>";
                
                    while ($ticketRows = mysqli_fetch_assoc($ticketQuery)){
                        echo "<tr>"; //Starting row searches that will apply for each of the following specified columns
                            echo "<td class = ticketRows>".$ticketRows['ticket_fName_change']."</td>"; //this is also applied into the table creating rows for each and every row from the table
                            echo "<td class = ticketRows>".$ticketRows['ticket_lName_change']."</td>";
                            echo "<td class = ticketRows>".$ticketRows['ticket_major_change']."</td>";
                            echo "<td class = ticketRows>".$ticketRows['ticket_enrollment_change']."</td>";
                            echo "<td class = ticketRows>".$ticketRows['ticket_OnCampus_change']."</td>";
                            echo "<td class = ticketRows>".$ticketRows['student_id']."</td>";
                        echo "</tr>";
                    } //end of while()
                    echo "</table>";
                echo "</form>";
            echo "</fieldset>";
        } else {
            print_r($ticketQuery); //error print if something goes wrong
        }
    }// end of displayTicketTable()

    function displayOriginalStudentInfo() {
        global $connectToDB;
        if(isset($_POST['ddlSubmit'])) {

            $studentInfoID = $_POST['studentSelect'];

            if ($studentInfoID > 0) { //this is to check if the value being sent over form the DDL is someone selected, if the default value is selected ('Please select a student') it will populate nothing
                $sqlStudentMajor = "SELECT * FROM studentMajor WHERE student_id = $studentInfoID"; //connecting and querying data from studentMajor only when $studentInfoID being passed form DDL matches with someone in the DB
                $studentMajorQuery = mysqli_query($connectToDB, $sqlStudentMajor);

                while ($studentMajorRows = mysqli_fetch_assoc($studentMajorQuery)) { //loop to fetch_associated for majorID and studentEnrollment
                    $majorId = $studentMajorRows['major_id'];
                    $studentEnrollment = $studentMajorRows['enrollment_status']; 
                    if ($studentEnrollment == 0) { //checking for 'IF FALSE' first ----->  0 = not enrolled * 1 = is enrolled
                        $wordVersionEnrollment = "Student is not enrolled";
                    } else {
                        $wordVersionEnrollment = "Student is currently enrolled";
                    }
                } //end of while()

                $sqlMajor = "SELECT major_name FROM major WHERE major_id = $majorId"; //connecting and querying data from major only when major_id = $majorId which was grabbed from studentMajor (previous query)
                $majorQuery = mysqli_query($connectToDB, $sqlMajor);

                while ($majorRows = mysqli_fetch_assoc($majorQuery)) { //loop to fetch_associated for majorName
                    $majorName = $majorRows['major_name'];
                }//end of while()


                $sqlStudentInfo = "SELECT * FROM studentinfo WHERE student_id = $studentInfoID"; //connecting and querying data from studentinfo only when $studentInfoID being passed form DDL matches with someone in the DB
                $studentInfoQuery = mysqli_query($connectToDB, $sqlStudentInfo);

                while ($studentInfoRows = mysqli_fetch_assoc($studentInfoQuery)) { //loop to fetch_associated for studentFirstName, studentLastName, and studentOnCampus
                    $studentFirstName = $studentInfoRows['student_fName'];
                    $studentLastName = $studentInfoRows['student_lName'];
                    $studentOnCampus = $studentInfoRows['student_on_campus'];
                    if ($studentOnCampus == 0) { //checking for 'IF FALSE' first ----->  0 = not enrolled * 1 = is enrolled
                        $wordVersionOnCampus = "Student is off-campus";
                    } else {
                        $wordVersionOnCampus = "Student is currently on-campus";
                    }
                }//end of while()

                throwValuesIntoHTMLFields($studentFirstName, $studentLastName, $majorName, $wordVersionEnrollment, $wordVersionOnCampus); //passing the variables found above while() into 'throwValuesIntoHTMLFields' so that data can be placed into HTML READONLY sections
                
            }else {
                throwValuesIntoHTMLFields('','','','',''); //if no-one is selected (the default value), then nothing will be passed into 'throwValuesIntoHTMLFields', this will leave the input fields empty
            }
        } else {
            throwValuesIntoHTMLFields('','','','',''); //This is the default version of PHP, since no-one was ever selected (via the button was never pressed) it will still populate the page.
        }     
    }

    function throwValuesIntoHTMLFields($studentFirstName, $studentLastName, $majorName, $wordVersionEnrollment, $wordVersionOnCampus) { //This function is HTML code to allow for values to be passed into each given field via student selected
        echo "<div class= wrapper>";
                echo "<h1 class = 'formHeaders'>Original Student Info</h1>";
                echo "<form action='' method= 'POST' class = 'form-area'>";
                    echo "<div class='details-area'>";
                        echo "<label for='originalFirstName'>Student First Name</label>";
                        echo "<input type='text' name='originalFirstName' id='originalFirstName' READONLY value = '$studentFirstName'>"; //passing in $studentFirstName as value for READONLY input 

                        echo "<label for='originalLastName'>Student Last Name</label>";
                        echo "<input type='text' name='originalLastName' id='originalLastName' READONLY value = '$studentLastName'>"; //passing in $studentLastName as value for READONLY input 

                        echo "<label for='originalMajor'>Major</label>";
                        echo "<input type='text' name='originalMajor' id='originalMajor' READONLY value = '$majorName'>"; //passing in $studentMajor as value for READONLY input 

                        echo "<label for='originalEnrollment'>Enrollment Status</label>";
                        echo "<input type='text' name='originalEnrollment' id='originalEnrollment' READONLY value = '$wordVersionEnrollment'>"; //passing in $studentEnrollment as value for READONLY input 
 
                        echo "<label for='originalOnCampus'>On-Campus Status</label>";
                        echo "<input type='text' name='originalOnCampus' id='originalOnCampus' READONLY value = '$wordVersionOnCampus'>"; //passing in $studentOnCampus as value for READONLY input 
                    echo "</div>";
                echo "</form>";
            echo "</div>";
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ticketRequest.css">
    <title>Ticket Request</title>
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

    

    <fieldset class = "overallWrapper">
        <legend class = "ticketLegend">Check Student Changes</legend>
        <div class = "dropDownWrap">
            <?php populateStudentDropDown(); ?>
        </div>
        
        <?php displayOriginalStudentInfo(); ?>

        <!-- <div class="wrapper">
            <h1 class = "formHeaders">Original Student Info</h1>
            <form action="" method= "POST" class="form-area">
                <div class="details-area">
                    <label for="originalFirstName">Student First Name</label>
                    <input type="text" name="originalFirstName" id="originalFirstName" READONLY>

                    <label for="originalLastName">Student Last Name</label>
                    <input type="text" name="originalLastName" id="originalLastName" READONLY>

                    <label for="originalMajor">Major</label>
                    <input type="text" name="originalMajor" id="originalMajor" READONLY>

                    <label for="originalEnrollment">Enrollment Status</label>
                    <input type="text" name="originalEnrollment" id="originalEnrollment" READONLY>

                    <label for="originalOnCampus">On-Campus Status</label>
                    <input type="text" name="originalOnCampus" id="originalOnCampus" READONLY>
                </div>
            </form>
        </div> -->

        <div class="wrapper">
            <h1 class = "formHeaders">Check Student Changes</h1>
            <form action="" method= "POST" class="form-area">
                <div class="details-area">
                    <label for="firstNameChange">Student First Name</label>
                    <input type="text" name="firstNameChange" id="firstNameChange">

                    <label for="lastNameChange">Student Last Name</label>
                    <input type="text" name="lastNameChange" id="lastNameChange">

                    <label for="majorChange">Major Change</label>
                    <input type="text" name="majorChange" id="majorChange">

                    <label for="enrollmentChange">Enrollment Change</label>
                    <input type="text" name="enrollmentChange" id="enrollmentChange">

                    <label for="onCampusChange">On-Campus Change</label>
                    <input type="text" name="onCampusChange" id="onCampusChange">
                </div>
            </form>
        </div>

        <button type="submit"  value="Submit" name = "acceptChanges" id = "acceptChanges">Accept</button>
        <button type="submit"  value="Submit" name = "discardChanges" id = "discardChanges">Discard</button>
    </fieldset>
    <?php displayTicketTable(); ?>
    



</body>
</html>