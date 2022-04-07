<?php
    session_start();
    $courseCode = $_GET["id"]; //Retrieve the courseCode, Course page that we are on
    $currentLoggedStudent = $_SESSION["currentUserLoginId"];
    $reviewID = $_POST['reviewID'];


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


    /***************************************************/
    /*REPLY FORM FUNCTION TO SEND REPLIES TO DATABASE */
    /***************************************************/
    function replyForm(){
        global $courseCode;
        global $connectToDB;
        global $reviewID;
        global $currentLoggedStudent;

        $replyMessage = $_POST['replyMessage'];
        $dateWritten = $_POST['dateWritten'];

        //INSERT THE REPLY TO REPLIES TABLE USING CORRECT IDs ALSO 
        if($replyMessage != ''){
            $sqlInsertReply = "INSERT INTO replies (student_id, course_code, reply_message, date_written, studentCourseReview_id, replyToReply_id)
            VALUES ('$currentLoggedStudent', '$courseCode', '$replyMessage', '$dateWritten', '$reviewID', '0')";

            $queryInsertReply = mysqli_query($connectToDB, $sqlInsertReply);

            if($queryInsertReply){
                //echo"SUCCESS for all queries !!!!";
                header("Location: http://localhost/csc450Capstone/CoursePage/CoursePage.php?id=$courseCode");//Send user back to coursePage
            }
            else{
                print_r('Failed to save reply!');
            }
        }
    }//end of replyForm();

    /***************************************************/
    /*REPLY TO REPLY FORMS FUNCTION */
    /***************************************************/
    function replyToReplyForm(){
        global $courseCode;
        global $connectToDB;
        global $reviewID;
        global $currentLoggedStudent;
        
        $replyID = $_POST["replyID"];//The reply id of where the replyToReply_id will be connected to 
        $replyToReplyMessage = $_POST["replyToReplyMessage"];
        $dateWritten = $_POST['dateWritten2'];

        if($replyToReplyMessage != ''){
            $sqlInsertReplyToReply = "INSERT INTO replies (student_id, course_code, reply_message, date_written, studentCourseReview_id, replyToReply_id)
            VALUES ('$currentLoggedStudent', '$courseCode', '$replyToReplyMessage', '$dateWritten', '$reviewID', '$replyID')";
            $queryInsert = mysqli_query($connectToDB, $sqlInsertReplyToReply);

            if($queryInsert){
                header("Location: http://localhost/csc450Capstone/CoursePage/CoursePage.php?id=$courseCode");//Send user back to coursePage
            }
            else{
                echo"FAIL TO INSERT REPLY TO REPLY";
            }
        }
    }//end of replyToReplyForm()

    /***************************************************/
    /*IF USER SUBMITTED A REPLY */
    /***************************************************/
    if(isset($_POST['replySubmitBtn'])){
        replyForm();
    }

    /***************************************************/
    /*IF USER SUBMITTED A REPLY TO A REPLY */
    /***************************************************/
    if(isset($_POST['replyBtn2'])){
        replyToReplyForm();
    }
    
    /***************************************************/
    /*LIKING REVIEW USING THE AUTO INCREMENT BUTTON */
    /***************************************************/
    //ONLY if user likes other reviews posts
    if(isset($_POST['likeReviewBtn']) && $studentReviewID != $currentLoggedStudent){
        $overallReviewRatings = $_POST["overallReviewRatings"];
        $sqlUpdateReviewRating = "UPDATE studentcourse SET overall_review_rating = $overallReviewRatings+1 WHERE studentCourseReview_id = $reviewID AND student_id = $studentReviewID AND course_code = $courseCode";
        $sqlUpdateReviewQuery = mysqli_query($connectToDB, $sqlUpdateReviewRating);
        if ($sqlUpdateReviewQuery) {
            header("Location: http://localhost/csc450Capstone/CoursePage/CoursePage.php?id=$courseCode");
        } else {
            print_r($sqlUpdateReviewQuery);
        }
    } 
    else{//Just send the user back to the course page if they like their own review post. 
        header("Location: http://localhost/csc450Capstone/CoursePage/CoursePage.php?id=$courseCode");
    }

    ?>