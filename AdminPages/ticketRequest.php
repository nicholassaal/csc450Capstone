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


    /*****************************************************
     **********   POPULATE STUDENT DDL BLOCK    **********
     *****************************************************/

    function populateStudentDropDown() { 
        global $connectToDB;
        $sqlTicketStudentId = "SELECT student_id FROM ticketrequest";
        $queryTicketStudentId = mysqli_query($connectToDB, $sqlTicketStudentId);

        // echo "<form method = 'POST'>";
        echo"<select name = studentSelect id = studentSelect size = '1'>";
            echo "<option value = '-1'>Please Select a Student</option>";
            while($studentTicketRows = mysqli_fetch_array($queryTicketStudentId)){
                $studentID = $studentTicketRows['student_id'];
                $sqlStudentInfo = "SELECT * FROM studentInfo WHERE student_id = $studentID";
                $queryStudentInfo = mysqli_query($connectToDB, $sqlStudentInfo);

                while($rows = mysqli_fetch_array($queryStudentInfo)) { 
                    $studentName    = $rows['student_fName']." ".$rows['student_lName'];
                    $studentInfoID  = $rows['student_id'];
                    echo"<option value = $studentInfoID>$studentName</option>";

                }//end Inner while()
            }// end outer while()
        echo"</select>";
        echo "<input type = submit name = ddlSubmit id = ddlSubmit class = ddlSubmit value = 'Select this Student'>";
        // echo "</form>";
    }//end of populateMajorDropdown()

    /*****************************************************
     **********   POPULATE STUDENT DDL BLOCK    **********
     *****************************************************/

    /* ~~~~~~~~~~~~~~~~~~~~~ SPACER ~~~~~~~~~~~~~~~~~~~~~ */

    /*****************************************************
     **********   DISPLAY TICKET TABLE BLOCK    **********
     *****************************************************/

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

    /*****************************************************
     **********   DISPLAY TICKET TABLE BLOCK    **********
     *****************************************************/

    /* ~~~~~~~~~~~~~~~~~~~~~ SPACER ~~~~~~~~~~~~~~~~~~~~~ */

    /*****************************************************
     **********   ORIGINAL STUDENT INFO BLOCK   **********
     *****************************************************/

    function displayOriginalStudentInfo() {
        global $connectToDB;
        if(isset($_POST['ddlSubmit'])) {
            $_SESSION["studentID"] = $_POST['studentSelect'];

            $studentInfoID = $_POST['studentSelect'];

            if ($studentInfoID > 0) { //this is to check if the value being sent over form the DDL is someone selected, if the default value is selected ('Please select a student') it will populate nothing since its value is -1
                $sqlStudentMajor = "SELECT * FROM studentMajor WHERE student_id = $studentInfoID"; //connecting and querying data from studentMajor only when $studentInfoID being passed form DDL matches with someone in the DB
                $studentMajorQuery = mysqli_query($connectToDB, $sqlStudentMajor);

                while ($studentMajorRows = mysqli_fetch_assoc($studentMajorQuery)) { //loop to fetch_associated for majorID and studentEnrollment
                    $majorId            = $studentMajorRows['major_id'];
                    $studentEnrollment  = $studentMajorRows['enrollment_status']; 

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
                    $studentFirstName   = $studentInfoRows['student_fName'];
                    $studentLastName    = $studentInfoRows['student_lName'];
                    $studentOnCampus    = $studentInfoRows['student_on_campus'];
                    if ($studentOnCampus == 0) { //checking for 'IF FALSE' first ----->  0 = is off-campus * 1 = is on-campus
                        $wordVersionOnCampus = "Student is off-campus";
                    } else {
                        $wordVersionOnCampus = "Student is currently on-campus";
                    }
                }//end of while()

                //passing the variables found above while() into 'throwValuesIntoHTMLFields' so that data can be placed into HTML READONLY sections
                throwValuesIntoHTMLFieldsOriginal($studentFirstName, $studentLastName, $majorName, $wordVersionEnrollment, $wordVersionOnCampus);      
            }else {
                //if no-one is selected (the default value), then nothing will be passed into 'throwValuesIntoHTMLFields', this will leave the input fields empty
                throwValuesIntoHTMLFieldsOriginal('','','','',''); 
            }
        } else {
            //This is the default version of PHP, since no-one was ever selected (via the button was never pressed/the page is loaded) it will still populate the page.
            throwValuesIntoHTMLFieldsOriginal('','','','',''); 
        }     
    } //end of displayOriginalStudentInfo()

    function throwValuesIntoHTMLFieldsOriginal($studentFirstName, $studentLastName, $majorName, $wordVersionEnrollment, $wordVersionOnCampus) { //This function is HTML code to allow for values to be passed into each given field via student selected
        echo "<div class= wrapper>";
                echo "<h1 class = 'formHeaders'>Original Student Info</h1>";
                echo "<div class = 'form-area'>";
                    echo "<div class='details-area'>";
                        echo "<label for='originalFirstName'>Student First Name</label>";
                        echo "<div class = changesInputDiv>";
                            echo "<input type='text' name='originalFirstName' id='originalFirstName' READONLY value = '$studentFirstName'>"; //passing in $studentFirstName as value for READONLY input 
                        echo "</div>";

                        echo "<label for='originalLastName'>Student Last Name</label>";
                        echo "<div class = changesInputDiv>";
                            echo "<input type='text' name='originalLastName' id='originalLastName' READONLY value = '$studentLastName'>"; //passing in $studentLastName as value for READONLY input 
                        echo "</div>";

                        echo "<label for='originalMajor'>Major</label>";
                        echo "<div class = changesInputDiv>";
                            echo "<input type='text' name='originalMajor' id='originalMajor' READONLY value = '$majorName'>"; //passing in $studentMajor as value for READONLY input 
                        echo "</div>";

                        echo "<label for='originalEnrollment'>Enrollment Status</label>";
                        echo "<div class = changesInputDiv>";
                            echo "<input type='text' name='originalEnrollment' id='originalEnrollment' READONLY value = '$wordVersionEnrollment'>"; //passing in $studentEnrollment as value for READONLY input 
                        echo "</div>";

                        echo "<label for='originalOnCampus'>On-Campus Status</label>";
                        echo "<div class = changesInputDiv>";
                            echo "<input type='text' name='originalOnCampus' id='originalOnCampus' READONLY value = '$wordVersionOnCampus'>"; //passing in $studentOnCampus as value for READONLY input 
                        echo "</div>";

                    echo "</div>";
                echo "</div>";
            echo "</div>";
    } //end of throwValuesIntoHTMLFields()

    /*****************************************************
     **********   ORIGINAL STUDENT INFO BLOCK   **********
     *****************************************************/
    
    /* ~~~~~~~~~~~~~~~~~~~~~ SPACER ~~~~~~~~~~~~~~~~~~~~~ */

    /*****************************************************
     **********   CHECK STUDENT CHANGES BLOCK   **********
     *****************************************************/

    function displayCheckStudentChanges() {
        global $connectToDB;
        if(isset($_POST['ddlSubmit'])) {
            $_SESSION["studentID"] = $_POST['studentSelect'];

            $studentInfoID = $_POST['studentSelect'];

            //this is to c heck if the value being sent over form the DDL is someone selected, if the default value is selected ('Please select a student') it will populate nothing since its value is -1
            if($studentInfoID > 0) { 

                $sqlTicketRequest = "SELECT * FROM ticketrequest WHERE student_id = $studentInfoID";
                $ticketRequestQuery = mysqli_query($connectToDB, $sqlTicketRequest);

                while ($ticketRequestRows = mysqli_fetch_assoc($ticketRequestQuery)) {
                    $checkStudentFName      = $ticketRequestRows['ticket_fName_change'];
                    $checkStudentLName      = $ticketRequestRows['ticket_lName_change'];
                    $checkMajorChange       = $ticketRequestRows['ticket_major_change'];
                    $checkEnrollmentChange  = $ticketRequestRows['ticket_enrollment_change'];
                    $checkOnCampusChange    = $ticketRequestRows['ticket_OnCampus_change'];

                    if($checkEnrollmentChange == 0) { //checking for 'IF FALSE' first ----->  0 = not enrolled * 1 = is enrolled
                        $wordVersionEnrollmentChange = "Student is not enrolled";
                    } else {
                        $wordVersionEnrollmentChange = "Student is currently enrolled";
                    }

                    if($checkOnCampusChange == 0) { //checking for 'IF FALSE' first ----->  0 = is off-campus * 1 = is on-campus
                        $wordVersionCampusChange = "Student is off-campus";
                    } else {
                        $wordVersionCampusChange = "Student is currently on-campus";
                    }
                } //end of while()

                //passing the variables found above while() into 'throwValuesIntoHTMLCheckChanges' so that data can be placed into HTML input sections
                throwValuesIntoHTMLCheckChanges($checkStudentFName, $checkStudentLName, $checkMajorChange, $checkEnrollmentChange, $wordVersionEnrollmentChange, $checkOnCampusChange, $wordVersionCampusChange);
            } else {
                //if no-one is selected (the default value), then nothing will be passed into 'throwValuesIntoHTMLCheckChanges', this will leave the input fields empty
                throwValuesIntoHTMLCheckChanges('','','','','', '', ''); 
            }
        } else {
            //This is the default version of PHP, since no-one was ever selected (via the button was never pressed/the page is loaded) it will still populate the page.
            throwValuesIntoHTMLCheckChanges('','','','','', '', ''); 
        }
    } //end of displayCheckStudentChanges()

    //additional note: This function is necessary even though majority of it is HTML because we need to be able to pass in variables reflexively with what the admin clicks and student's requests
    //---------------> Since this is the case, I would have wrote this out 3 separate times in other ways to solve this issue.
    function throwValuesIntoHTMLCheckChanges($checkStudentFName, $checkStudentLName, $checkMajorChange, $checkEnrollmentChange, $wordVersionEnrollmentChange, $checkOnCampusChange, $wordVersionCampusChange) {
        echo "<div class = 'wrapper'>";
            echo "<h1 class = 'formHeaders'>Check Student Changes</h1>";
            echo "<div class = 'form-area'>";
                echo "<div class='details-area'>";
                    echo "<label for='firstNameChange'>Student First Name</label>";
                    echo "<div class = changesInputDiv>";
                        echo "<input type='text' name='firstNameChange' id='firstNameChange' READONLY value = '$checkStudentFName'>";
                        echo "<label class = chkboxContainer>acceptable?";
                            echo "<input type = 'hidden' name = 'changeChkBox1' value = '0'>";
                            echo "<input type = 'checkbox' name = 'changeChkBox1' id = 'changeChkBox' value = '1'>";
                            echo "<span class = 'newChkBox'></span>";
                        echo "</label>";
                    echo "</div>";
                   
                    echo "<label for='lastNameChange'>Student Last Name</label>";
                    echo "<div class = changesInputDiv>";
                        echo "<input type='text' name='lastNameChange' id='lastNameChange' READONLY value = '$checkStudentLName'>";
                        echo "<label class = chkboxContainer>acceptable?";
                            echo "<input type = 'hidden' name = 'changeChkBox2' value = '0'>";
                            echo "<input type = 'checkbox' name = 'changeChkBox2' id = 'changeChkBox' value = '1'>";
                            echo "<span class = 'newChkBox'></span>";
                        echo "</label>";
                    echo "</div>";

                    echo "<label for='majorChange'>Major Change</label>";
                    echo "<div class = changesInputDiv>";
                        echo "<input type='text' name='majorChange' id='majorChange' READONLY value = '$checkMajorChange'>";
                        echo "<label class = chkboxContainer>acceptable?";
                            echo "<input type = 'hidden' name = 'changeChkBox3' value = '0'>";
                            echo "<input type = 'checkbox' name = 'changeChkBox3' id = 'changeChkBox' value = '1'>";
                            echo "<span class = 'newChkBox'></span>";
                        echo "</label>";
                    echo "</div>";

                    echo "<label for='enrollmentChange'>Enrollment Change</label>";
                    echo "<div class = changesInputDiv>";
                        echo "<input type='text' name='enrollmentChange' id='enrollmentChange' READONLY value = '$wordVersionEnrollmentChange'>";
                        echo "<label class = chkboxContainer>acceptable?";
                            echo "<input type = 'hidden' name = 'changeChkBox4' value = '0'>";
                            echo "<input type = 'checkbox' name = 'changeChkBox4' id = 'changeChkBox' value = '1'>";
                            echo "<span class = 'newChkBox'></span>";
                            echo "<input type = 'hidden' name = 'numericEnrollmentChange' value = '$checkEnrollmentChange'"; //This hidden field is meant to have the numeric value for updating the database
                        echo "</label>";
                    echo "</div>";
                    
                    echo "<label for='onCampusChange'>On-Campus Change</label>";
                    echo "<div class = changesInputDiv>";
                        echo "<input type='text' name='onCampusChange' id='onCampusChange' READONLY value = '$wordVersionCampusChange'>";
                        echo "<label class = chkboxContainer>acceptable?";
                            echo "<input type = 'hidden' name = 'changeChkBox5' value = '0'>";
                            echo "<input type = 'checkbox' name = 'changeChkBox5' id = 'changeChkBox' value = '1'>";
                            echo "<span class = 'newChkBox'></span>";
                            echo "<input type = 'hidden' name = 'numericOnCampusChange' value = '$checkOnCampusChange'"; //This hidden field is meant to have the numeric value for updating the database
                        echo "</label>";
                    echo "</div>";
                echo "</div>";
            echo "</div>";
        echo "</div>";
    } //end of throwValuesIntoHTMLCheckChanges()

    /*****************************************************
     **********   CHECK STUDENT CHANGES BLOCK   **********
     *****************************************************/

     /* ~~~~~~~~~~~~~~~~~~~~~ SPACER ~~~~~~~~~~~~~~~~~~~~~ */

    /***********************************************************
     **********   UPDATE STUDENT INFO INTO DB BLOCK   **********
     ***********************************************************/

    function updateStudentInformation() {
        global $connectToDB;
        if(isset($_POST['acceptChanges'])){
            $studentID = $_SESSION["studentID"];
            if ($studentID > 0) {

                $checkBox1          = $_POST['changeChkBox1'];
                $checkBox2          = $_POST['changeChkBox2'];
                $checkBox3          = $_POST['changeChkBox3'];
                $checkBox4          = $_POST['changeChkBox4'];
                $checkBox5          = $_POST['changeChkBox5'];

                $firstNameChange    = $_POST['firstNameChange'];
                $lastNameChange     = $_POST['lastNameChange'];
                $majorChange        = $_POST['majorChange'];
                $enrollmentChange   = $_POST['numericEnrollmentChange'];
                $onCampusChange     = $_POST['numericOnCampusChange'];
                
                /**************************** Confirming choice for checkBox1 ****************************/
                if($checkBox1 == 1) {
                    $sqlfNameChangeAccepted = "UPDATE studentinfo SET student_fName = '$firstNameChange' WHERE student_id = '$studentID'";
                    $fNameChangeQuery = mysqli_query($connectToDB, $sqlfNameChangeAccepted);

                    $sqlfNameChangeCompletionTable = "UPDATE ticketrequestcompletion SET ticket_fName_check = '1' WHERE student_id = '$studentID'";
                    $fNameChangeCompletionQuery = mysqli_query($connectToDB, $sqlfNameChangeCompletionTable);

                    if ($fNameChangeQuery && $fNameChangeCompletionQuery) {
                        echo "STUDENT WAS UPDATED!";
                    } else {
                        print_r($fNameChangeQuery);
                    }
                } else { //This is just a thought for auto populating a response to the user for what was denied

                    $sqlfNameChangeCompletionTable = "UPDATE ticketrequestcompletion SET ticket_fName_check = '0' WHERE student_id = '$studentID'";
                    $fNameChangeCompletionQuery = mysqli_query($connectToDB, $sqlfNameChangeCompletionTable);

                    if ($fNameChangeCompletionQuery) {
                        echo "<br>Student will be notified of the changes!";
                    } else {
                        print_r($fNameChangeCompletionQuery);
                    }

                    $fNameChangeQuery = TRUE;
                    $firstNameNotAccepted = "First name change was not accepted to be changed!";
                } //end of checking NameChanged

                /**************************** Confirming choice for checkBox2 ****************************/
                if ($checkBox2 == 1) {
                    $sqllNameChangeAccepted = "UPDATE studentinfo SET student_lName = '$lastNameChange' WHERE student_id = '$studentID'";
                    $lNameChangeQuery = mysqli_query($connectToDB, $sqllNameChangeAccepted);

                    $sqllNameChangeCompletionTable = "UPDATE ticketrequestcompletion SET ticket_lName_check = '1' WHERE student_id = '$studentID'";
                    $lNameChangeCompletionQuery = mysqli_query($connectToDB, $sqllNameChangeCompletionTable);

                    if ($lNameChangeQuery && $lNameChangeCompletionQuery) {
                        echo "STUDENT WAS UPDATED!";
                    } else {
                        print_r($lNameChangeQuery);
                    }
                } else {

                    $sqllNameChangeCompletionTable = "UPDATE ticketrequestcompletion SET ticket_lName_check = '0' WHERE student_id = '$studentID'";
                    $lNameChangeCompletionQuery = mysqli_query($connectToDB, $sqllNameChangeCompletionTable);

                    if ($lNameChangeCompletionQuery) {
                        echo "<br>Student will be notified of the changes!";
                    } else {
                        print_r($lNameChangeCompletionQuery);
                    }

                    $lNameChangeQuery = TRUE;
                    $lastNameNotAccepted = "Last name change was not accepted to be changed!";
                }

                /**************************** Confirming choice for checkBox3 ****************************/
                if ($checkBox3 == 1) {                   
                    $sqlGetMajorIdForChange = "SELECT major_id FROM major WHERE major_name = '$majorChange'"; //checking the name of the requested major to get the major_id
                    $majorIdForChangeQuery = mysqli_query($connectToDB, $sqlGetMajorIdForChange);
                    $majorUpdateId = mysqli_fetch_assoc($majorIdForChangeQuery);

                    $sqlMajorChangeAccepted = "UPDATE studentmajor SET major_id = $majorUpdateId[major_id] WHERE student_id = '$studentID'"; //using the newly grabbed major_id to the desired student
                    $majorChangeAcceptedQuery = mysqli_query($connectToDB, $sqlMajorChangeAccepted);

                    $sqlMajorChangeCompletion = "UPDATE ticketrequestcompletion SET ticket_major_check = '1' WHERE student_id = '$studentID'";
                    $majorChangeCompletionQuery = mysqli_query($connectToDB, $sqlMajorChangeCompletion);


                    if ($majorChangeAcceptedQuery && $majorChangeCompletionQuery) {
                        echo "STUDENT WAS UPDATED!";
                    } else {
                        print_r($majorChangeAcceptedQuery);
                    }
                } else {

                    $sqlMajorChangeCompletion = "UPDATE ticketrequestcompletion SET ticket_major_check = '0' WHERE student_id = '$studentID'";
                    $majorChangeCompletionQuery = mysqli_query($connectToDB, $sqlMajorChangeCompletion);

                    if ($majorChangeCompletionQuery) {
                        echo "<br>Student will be notified of the changes!";
                    } else {
                        print_r($majorChangeCompletionQuery);
                    }

                    $majorChangeAcceptedQuery = TRUE;
                    $majorChangeNotAccepted = "Major change was not accepted to be changed!";
                }
                /**************************** Confirming choice for checkBox4 ****************************/
                if ($checkBox4 == 1) {
                    $sqlEnrollmentChangeAccepted = "UPDATE studentmajor SET enrollment_status = '$enrollmentChange' WHERE student_id = '$studentID'";
                    $enrollmentChangeAcceptedQuery = mysqli_query($connectToDB, $sqlEnrollmentChangeAccepted);

                    $sqlEnrollmentChangeCompletion = "UPDATE ticketrequestcompletion SET ticket_enrollment_check = '1' WHERE student_id = '$studentID'";
                    $erollmentChangeCompletionQuery = mysqli_query($connectToDB, $sqlEnrollmentChangeCompletion);

                    if ($enrollmentChangeAcceptedQuery && $erollmentChangeCompletionQuery) {
                        echo "STUDENT WAS UPDATED!";
                    } else {
                        print_r($enrollmentChangeAcceptedQuery);
                    }
                } else {

                    $sqlMajorChangeCompletion = "UPDATE ticketrequestcompletion SET ticket_enrollment_check = '0' WHERE student_id = '$studentID'";
                    $majorChangeCompletionQuery = mysqli_query($connectToDB, $sqlMajorChangeCompletion);

                    if ($majorChangeCompletionQuery) {
                        echo "<br>Student will be notified of the changes!";
                    } else {
                        print_r($majorChangeCompletionQuery);
                    }

                    $enrollmentChangeAcceptedQuery = TRUE;
                    $enrollmentChangeNotAccepted = "It says that you are still enrolled with your school!";
                }

                /**************************** Confirming choice for checkBox5 ****************************/
                if ($checkBox5 == 1) {
                    $sqlOnCampusChangeAccepted = "UPDATE studentinfo SET student_on_campus = '$onCampusChange' WHERE student_id = '$studentID'";
                    $onCampusChangeAcceptedQuery = mysqli_query($connectToDB, $sqlOnCampusChangeAccepted);

                    $sqlOnCampusChangeCompletion = "UPDATE ticketrequestcompletion SET ticket_onCampus_check = '1' WHERE student_id = '$studentID'";
                    $onCampusChangeCompletionQuery = mysqli_query($connectToDB, $sqlOnCampusChangeCompletion);

                    if ($onCampusChangeAcceptedQuery && $onCampusChangeCompletionQuery) {
                        echo "STUDENT WAS UPDATED!";
                    } else {
                        print_r($onCampusChangeAcceptedQuery);
                    }
                } else {

                    $sqlOnCampusChangeCompletion = "UPDATE ticketrequestcompletion SET ticket_onCampus_check = '0' WHERE student_id = '$studentID'";
                    $onCampusChangeCompletionQuery = mysqli_query($connectToDB, $sqlOnCampusChangeCompletion);

                    if ($onCampusChangeCompletionQuery) {
                        echo "<br>Student will be notified of the changes!";
                    } else {
                        print_r($onCampusChangeCompletionQuery);
                    }
                    
                    $onCampusChangeAcceptedQuery = TRUE;
                    $onCampusChangeNotAccepted = "Says under file that you are still on campus!";
                }

                if ($fNameChangeQuery && $lNameChangeQuery && $majorChangeAcceptedQuery && $enrollmentChangeAcceptedQuery && $onCampusChangeAcceptedQuery) {
                    $sqlResolvedTicketRequest = "DELETE FROM ticketrequest WHERE student_id = $studentID";
                    $resolvedTicketRequestQuery = mysqli_query($connectToDB, $sqlResolvedTicketRequest);
                    if ($resolvedTicketRequestQuery) {
                        echo "<br>Ticket has been resolved, deletion will commence!";
                    } else {
                        echo "<br>Ticket was not resolved!<br>";
                        print_r($resolvedTicketRequestQuery);
                    }
                } 
            } else {
                echo "Please Select a Student!";
            }
        } //end of if(isset($_POST['acceptChanges']))    
    } //end of updateStudentInformation()

    /***********************************************************
     **********   UPDATE STUDENT INFO INTO DB BLOCK   **********
     ***********************************************************/

     /* ~~~~~~~~~~~~~~~~~~~~~ SPACER ~~~~~~~~~~~~~~~~~~~~~ */

    /*********************************************************
     **********   DISCARD REQUESTED CHANGES BLOCK   **********
     *********************************************************/



    function discardRequestedChanges() {
        global $connectToDB;
        if(isset($_POST['discardChanges'])) {
            $studentID = $_SESSION["studentID"];
            if($studentID > 0) {
                $sqlDiscardTicketRequest = "DELETE FROM ticketrequest WHERE student_id = $studentID";
                $discardTicketRequestQuery = mysqli_query($connectToDB, $sqlDiscardTicketRequest);

                if($discardTicketRequestQuery) {
                    echo "<br>Ticket Request was discarded!";
                } else {
                    print_r($discardTicketRequestQuery);
                }

            } else {
                echo "Please select a student!";
            }
        } //end of if(isset($_POST['']))
    } //end of discardRequestedChanges()
    
    /*********************************************************
     **********   DISCARD REQUESTED CHANGES BLOCK   **********
     *********************************************************/

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ticketRequest.css">
    <title>Admin Ticket Request</title>
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
        <form method = "POST">
            <div class = "dropDownWrap">
                <?php populateStudentDropDown(); ?>
            </div>

        
            <div class = "ticketRequestContainer">
                <?php displayOriginalStudentInfo(); ?>
                <?php displayCheckStudentChanges(); ?>   
            </div>

            <div class = btnContainer>
                <input type="button"  value="Lock In Selection" name = "lockIn" id = "lockIn" onclick = "lockedInSelection();">
                <input type="submit"  value="Accept Selected" name = "acceptChanges" id = "acceptChanges">
                <input type="submit"  value="Discard All" name = "discardChanges" id = "discardChanges">
            </div>
        </form>
        
    </fieldset>
    <?php displayTicketTable(); updateStudentInformation(); discardRequestedChanges();?>
    



</body>
</html>

<script> 
    //ACCEPT SELECTED & DISCARD ALL will automatically be disabled so that the admin's can't accidently click on them without checking first
    document.getElementById("acceptChanges").disabled = true;
    document.getElementById("discardChanges").disabled = true;

    function lockedInSelection() { //after the admin clicks 'lockIn' button, then ACCEPT SELECTED & DISCARD ALL will be readily available to them
        document.getElementById("acceptChanges").disabled = false;
        document.getElementById("discardChanges").disabled = false;
    }

</script>