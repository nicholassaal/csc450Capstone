<?php
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
// //$connect = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD);
// $connectToDB = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD, $DBF_NAME);

$studentId = $_SESSION["currentUserLoginId"]; //the user logged in currently



function populateTicketForm()
{
    global $connectToDB;
    global $studentId;

    $firstNameChange    = $_POST['firstNameChange'];
    $lastNameChange     = $_POST['lastNameChange'];
    $majorChange        = $_POST['majors'];
    $enrolledRadioBtn   = $_POST['enrolled'];
    $onCampusRadioBtn   = $_POST['onCampus'];

    $sqlReplaceIfExistsId = "SELECT student_id FROM ticketrequestcompletion WHERE student_id = $studentId";
    $replaceIfExistsIdQuery = mysqli_query($connectToDB, $sqlReplaceIfExistsId);
    $ifExistsStudentId = mysqli_fetch_assoc($replaceIfExistsIdQuery);

    // $sqlMajorChangeAccepted = "UPDATE studentmajor SET major_id = $majorUpdateId[major_id] WHERE student_id = '$studentID'"; //using the newly grabbed major_id to the desired student
    //             $majorChangeAcceptedQuery = mysqli_query($connectToDB, $sqlMajorChangeAccepted);

    if ($ifExistsStudentId > 0 || $ifExistsStudentId != NULL) {
        $sqlUpdateTicketRequest = "UPDATE ticketrequest SET ticket_fName_change = '$firstNameChange', 
                                                                ticket_lName_change = '$lastNameChange', 
                                                                ticket_major_change = '$majorChange', 
                                                                ticket_enrollment_change = '$enrolledRadioBtn', 
                                                                ticket_OnCampus_change = '$onCampusRadioBtn'
                                                        WHERE   student_id = '$ifExistsStudentId[student_id]'";
        $ticketRequestUpdateQuery = mysqli_query($connectToDB, $sqlUpdateTicketRequest);

        $sqlUpdateTicketRequestCompletion = "UPDATE ticketrequestcompletion SET ticketComplete_check = 0,
                                                                          ticket_fName_check = NULL,
                                                                          ticket_lName_check = NULL,
                                                                          ticket_major_check = NULL,
                                                                          ticket_enrollment_check = NULL,
                                                                          ticket_onCampus_check = NULL,
                                                                          ticket_fName_change = '$firstNameChange', 
                                                                          ticket_lName_change = '$lastNameChange', 
                                                                          ticket_major_change = '$majorChange', 
                                                                          ticket_enrollment_change = '$enrolledRadioBtn', 
                                                                          ticket_OnCampus_change = '$onCampusRadioBtn'
                                                                WHERE     student_id = '$ifExistsStudentId[student_id]'";
        $updateTicketRequestCompletionQuery = mysqli_query($connectToDB, $sqlUpdateTicketRequestCompletion);

        if ($ticketRequestUpdateQuery && $updateTicketRequestCompletionQuery) {
        } else {
            print_r($ticketRequestUpdateQuery);
        }
    } else {
        $sqlInsertTicketRequest = "INSERT INTO ticketrequest (ticket_fName_change, ticket_lName_change, ticket_major_change, ticket_enrollment_change, ticket_OnCampus_change, student_id)
                VALUES ('$firstNameChange','$lastNameChange','$majorChange','$enrolledRadioBtn','$onCampusRadioBtn', '$studentId')";
        $ticketRequestQuery = mysqli_query($connectToDB, $sqlInsertTicketRequest);

        $sqlInsertTicketRequestCompletion = "INSERT INTO ticketrequestcompletion (ticketComplete_check, ticket_fName_change, ticket_lName_change, ticket_major_change, ticket_enrollment_change, ticket_OnCampus_change, student_id)
                VALUES ('0', '$firstNameChange', '$lastNameChange', '$majorChange', '$enrolledRadioBtn', '$onCampusRadioBtn', '$studentId')";
        $insertTicketRequestCompletionQuery = mysqli_query($connectToDB, $sqlInsertTicketRequestCompletion);

        if ($ticketRequestQuery && $insertTicketRequestCompletionQuery) {
        } else {
            print_r($ticketRequestQuery);
        }
    }
}

function populateMajorDropdown()
{
    global $connectToDB;

    $sqlMajor = "SELECT major_name FROM major";
    $queryMajorName = mysqli_query($connectToDB, $sqlMajor);

    echo "<select name=majors id=majors required>";
    while ($rows = mysqli_fetch_array($queryMajorName)) {
        $majorName = $rows['major_name'];
        echo "<option>$majorName</option>";
    }

    echo "</select>";
} //end of populateMajorDropdown()

if (isset($_POST['sendTicket'])) {
    populateTicketForm();
    header("Refresh:0");
}



function sqlStatementsForTicketRequestTable()
{
    global $connectToDB;
    global $studentId;

    $sqlIfTicketRequestExists = "SELECT student_id FROM ticketrequestcompletion WHERE student_id = '$studentId'";
    $ifTicketRequestExistsQuery = mysqli_query($connectToDB, $sqlIfTicketRequestExists);
    $ifTicketRequestExists = mysqli_fetch_assoc($ifTicketRequestExistsQuery);

    if ($ifTicketRequestExists > 0 || $ifTicketRequestExists != NULL) {
        $sqlTicketRequestCompletionCheck = "SELECT ticketComplete_check FROM ticketrequestcompletion WHERE student_id = $studentId";
        $ticketRequestCompletionCheckQuery = mysqli_query($connectToDB, $sqlTicketRequestCompletionCheck);
        $pendingOrCompletedCheck = mysqli_fetch_assoc($ticketRequestCompletionCheckQuery);

        $pendingOrComplete = $pendingOrCompletedCheck['ticketComplete_check'];

        $sqlTicketRequestInfo = "SELECT * FROM ticketrequestcompletion WHERE student_id = $studentId";
        $ticketRequestInfoQuery = mysqli_query($connectToDB, $sqlTicketRequestInfo);

        echo "<table class = 'ticketRequestTable'>";
        while ($rows = mysqli_fetch_array($ticketRequestInfoQuery)) {
            $firstNameRequest           = $rows['ticket_fName_change'];
            $lastNameRequest            = $rows['ticket_lName_change'];
            $majorRequestChange         = $rows['ticket_major_change'];
            $enrollmentRequestChange    = $rows['ticket_enrollment_change'];
            $onCampusRequestChange      = $rows['ticket_OnCampus_change'];

            if ($enrollmentRequestChange == 0) {
                $enrollmentRequestChange = "Requested Enrollment Status - <b>NOT ENROLLED</b>";
            } else {
                $enrollmentRequestChange = "Requested Enrollment Status - <b>ENROLLED</b>";
            }

            if ($onCampusRequestChange == 0) {
                $onCampusRequestChange = "Requested On-Campus Status - <b>NOT ON-CAMPUS</b>";
            } else {
                $onCampusRequestChange = "Requested On-Campus Status - <b>ON-CAMPUS</b>";
            }

            pendingTicketRequestTable($studentId, $pendingOrComplete, $firstNameRequest, $lastNameRequest, $majorRequestChange, $enrollmentRequestChange, $onCampusRequestChange);
        }
        echo "</table>";
    } else {
        echo "You have no pending Ticket Request!";
    }
} // end of sqlStatementsForTicketRequestTable()


function pendingTicketRequestTable($studentId, $pendingOrComplete, $firstNameRequest, $lastNameRequest, $majorRequestChange, $enrollmentRequestChange, $onCampusRequestChange)
{
    global $connectToDB;

    $sqlCheckIfAccepted = "SELECT ticket_fName_check, ticket_lName_check, ticket_major_check, ticket_enrollment_check, ticket_onCampus_check FROM ticketrequestcompletion WHERE student_id = $studentId";
    $checkIfAcceptedQuery = mysqli_query($connectToDB, $sqlCheckIfAccepted);
    $checkIfAccepted = mysqli_fetch_assoc($checkIfAcceptedQuery);

    $fNameCheck         =  $checkIfAccepted['ticket_fName_check'];
    $lNameCheck         =  $checkIfAccepted['ticket_lName_check'];
    $majorCheck         =  $checkIfAccepted['ticket_major_check'];
    $enrollmentCheck    =  $checkIfAccepted['ticket_enrollment_check'];
    $onCampusCheck      =  $checkIfAccepted['ticket_onCampus_check'];

    if ($pendingOrComplete == 0) {
        echo "<div class = containerForLoading>";
        echo "<div class = 'pendingRequest1'>PENDING</div>";
        echo "<div class = 'pendingRequest2'>PENDING</div>";
        echo "<div class = 'pendingRequest3'>PENDING</div>";
        echo "<div class = 'pendingRequest4'>PENDING</div>";
        echo "<div class = 'pendingRequest5'>PENDING</div>";
        echo "</div>";
    }

    if ($pendingOrComplete == 1) {
        echo "<div class = containerForLoading>";
        if ($fNameCheck == 0) {
            echo "<div class = 'mark exclamation-point1'></div>";
        } else {
            echo "<div class = 'allowedSymbol1'></div>";
        }
        if ($lNameCheck == 0) {
            echo "<div class = 'markNext exclamation-point2'></div>";
        } else {
            echo "<div class = 'allowedSymbol2'></div>";
        }
        if ($majorCheck == 0) {
            echo "<div class = 'markNext exclamation-point3'></div>";
        } else {
            echo "<div class = 'allowedSymbol3'></div>";
        }
        if ($enrollmentCheck == 0) {
            echo "<div class = 'markNext exclamation-point4'></div>";
        } else {
            echo "<div class = 'allowedSymbol4'></div>";
        }
        if ($onCampusCheck == 0) {
            echo "<div class = 'markNext exclamation-point5'></div>";
        } else {
            echo "<div class = 'allowedSymbol5'></div>";
        }
        echo "</div>";
    }


    echo "<tr>";
    echo "<th class = 'studentChangeHeader'> First Name Change</th>";
    echo "<td class = 'childRowsTR'>Requested First Name Change - <b>$firstNameRequest</b></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<th class = 'studentChangeHeader'>Last Name Change</th>";
    echo "<td class = 'childRowsTR'>Requested Last Name Change - <b>$lastNameRequest</b></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<th class = 'studentChangeHeader'>Major Change</th>";
    echo "<td class = 'childRowsTR'>Requested Major Change - <b>$majorRequestChange</b></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<th class = 'studentChangeHeader'>Enrollment Change</th>";
    echo "<td class = 'childRowsTR'>$enrollmentRequestChange</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<th class = 'studentChangeHeader'>On-Campus Change</th>";
    echo "<td class = 'childRowsTR'>$onCampusRequestChange</td>";
    echo "</tr>";
}
