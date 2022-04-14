<?php 
    $SERVER_NAME    = "localhost";   //Server name 
    $DBF_USER       = "root";        //UserName for the localhost database
    $DBF_PASSWORD   = "";       //Password for the localhost database/ When using XAMPPS, make this value emtpy. Use: $DBF_PASSWORD   = "";
    $DBF_NAME       = "CSPCourseReview";    //DB name for the localhost database
    //$connect = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD);
    $connectToDB = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD, $DBF_NAME);

    $studentId = $_SESSION["currentUserLoginId"];//the user logged in currently

    function populateTicketForm() {
        global $connectToDB;
        global $studentId;
        
        $firstNameChange    = $_POST['firstNameChange'];
        $lastNameChange     = $_POST['lastNameChange'];
        $majorChange        = $_POST['majors'];
        $enrolledRadioBtn   = $_POST['enrolled'];
        $onCampusRadioBtn   = $_POST['onCampus'];
        
        $sqlReplaceIfExistsId = "SELECT student_id FROM ticketrequest WHERE student_id = $studentId";
        $replaceIfExistsIdQuery = mysqli_query($connectToDB, $sqlReplaceIfExistsId);
        $ifExistsStudentId = mysqli_fetch_assoc($replaceIfExistsIdQuery);

        // $sqlMajorChangeAccepted = "UPDATE studentmajor SET major_id = $majorUpdateId[major_id] WHERE student_id = '$studentID'"; //using the newly grabbed major_id to the desired student
        //             $majorChangeAcceptedQuery = mysqli_query($connectToDB, $sqlMajorChangeAccepted);

        if ($ifExistsStudentId > 0) {
            $sqlUpdateTicketRequest = "UPDATE ticketrequest SET ticket_fName_change = '$firstNameChange', 
                                                                ticket_lName_change = '$lastNameChange', 
                                                                ticket_major_change = '$majorChange', 
                                                                ticket_enrollment_change = '$enrolledRadioBtn', 
                                                                ticket_OnCampus_change = '$onCampusRadioBtn'
                                                        WHERE   student_id = '$ifExistsStudentId[student_id]'";

            $ticketRequestUpdateQuery = mysqli_query($connectToDB, $sqlUpdateTicketRequest);

            if ($ticketRequestUpdateQuery) {
                echo"You Updated your currently registered Ticket Request!";
            } else {
                print_r($ticketRequestUpdateQuery);
            } 

        } else {
            $sqlInsertTicketRequest = "INSERT INTO ticketrequest (ticket_fName_change, ticket_lName_change, ticket_major_change, ticket_enrollment_change, ticket_OnCampus_change, student_id)
                VALUES ('$firstNameChange','$lastNameChange','$majorChange','$enrolledRadioBtn','$onCampusRadioBtn', '$studentId')";

            $ticketRequestQuery = mysqli_query($connectToDB, $sqlInsertTicketRequest);

            if ($ticketRequestQuery) {
                echo"TICKET WAS SENT SUCCESSFULLY!";
            } else {
                print_r($ticketRequestQuery);
            } 
        }

         
    }

    function populateMajorDropdown() { 
        global $connectToDB;

        $sqlMajor = "SELECT major_name FROM major";
        $queryMajorName = mysqli_query($connectToDB, $sqlMajor);

        echo"<select name=majors id=majors required>";
        while($rows = mysqli_fetch_array($queryMajorName)) { 
            $majorName = $rows['major_name'];
            echo"<option>$majorName</option>";
        }
        
        echo"</select>";
    }//end of populateMajorDropdown()

    if(isset($_POST['sendTicket'])) {
        populateTicketForm();
    }

?>