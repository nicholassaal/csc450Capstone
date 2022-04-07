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
        

        $insertTicketRequest = "INSERT INTO ticketrequest (ticket_fName_change, ticket_lName_change, ticket_major_change, ticket_enrollment_change, ticket_OnCampus_change, student_id)
                        VALUES ('$firstNameChange','$lastNameChange','$majorChange','$enrolledRadioBtn','$onCampusRadioBtn', '$studentId')";
        $ticketRequestQuery = mysqli_query($connectToDB, $insertTicketRequest);

        if ($ticketRequestQuery) {
            echo"TICKET WAS SENT SUCCESSFULLY!";
        } else {
            mysqli_error($connectToDB);
            print_r($connectToDB);
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