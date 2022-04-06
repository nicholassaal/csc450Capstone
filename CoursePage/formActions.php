<?php
    session_start();
    $courseCode = $_GET["id"]; //Retrieve the courseCode, Course page that we are on
    $studentReviewID = $_POST['studentReviewID']; //Retrieve the studentReviewID, the student that wrote the review 
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
        global $studentReviewID;
        global $currentLoggedStudent;

        $replyMessage = $_POST['replyMessage'];
        $dateWritten = $_POST['dateWritten'];

        //INSERT THE REPLY MESSAGE TO THE replies table 
        if($replyMessage != ''){
            $sqlInsertReply = "INSERT INTO replies (student_id, course_code, reply_message, date_written)
            VALUES ('$currentLoggedStudent', '$courseCode', '$replyMessage', '$dateWritten')";
            
            //RETRIEVE THE REVIEW MESSAGE ID OF WHERE THE REPLY MESSAGE WAS WRITTEN TO
            $sqlRetrieveReviewID = "SELECT studentCourseReview_id FROM studentCourse WHERE student_id = $studentReviewID AND course_code = $courseCode";

            //RETRIEVE THRE REPLY ID OF STUDENT THAT WROTE REPLY, THE LATEST REPLY_ID THAT WAS INSERTED INTO THE DATABASE
            $sqlRetrieveReplyID = "SELECT reply_id FROM replies ORDER BY reply_id DESC LIMIT 1";

            $queryInsertReply = mysqli_query($connectToDB, $sqlInsertReply);

            $queryReviewID = mysqli_query($connectToDB, $sqlRetrieveReviewID);
            $retrievedReviewID = mysqli_fetch_assoc($queryReviewID);
            $reviewID = $retrievedReviewID['studentCourseReview_id'];

            $queryReplyID = mysqli_query($connectToDB, $sqlRetrieveReplyID);
            $retrievedReplyID = mysqli_fetch_assoc($queryReplyID);
            $replyID = $retrievedReplyID['reply_id'];
                
            echo"<br>REVIEW ID ".$reviewID."<br><br>";
            echo "REPLY ID ".$replyID."<br>";

            $sqlInsertIntoReviewReplies = "INSERT INTO reviewReplies (studentCourseReview_id, reply_id)
            VALUE('$reviewID', '$replyID')";
            $queryInsertReviewReplies = mysqli_query($connectToDB, $sqlInsertIntoReviewReplies);

            if($queryInsertReply && $queryReviewID && $queryReplyID && $queryInsertReviewReplies){
                //echo"SUCCESS for all queries !!!!";
                header("Location: http://localhost/csc450Capstone/CoursePage/CoursePage.php?id=$courseCode");
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
        global $studentReviewID;
        global $currentLoggedStudent;
        echo"<br><br> THE COURSE CODE IS ".$courseCode."";
        echo"<br><br> THE STUDENT ID FOR THE REVIEW IS ".$studentReviewID."";
        echo"<br><br> THE CURRENT USER ID IS ".$currentLoggedStudent."";
        
        $replyID = $_POST["replyID"];
        $replyToReplyMessage = $_POST["replyToReplyMessage"];

        echo"<br><br>REPLY ID IS ".$replyID."<br>";
        echo"<br>THE REPLY TO REPLY MESSAGE IS ".$replyToReplyMessage."<br>";

        if($replyToReplyMessage != ''){
            // $sqlRetrieveReviewID = "SELECT studentCourseReview_id FROM studentCourse WHERE student_id = $studentReviewID AND course_code = $courseCode";
            // $queryReviewID = mysqli_query($connectToDB, $sqlRetrieveReviewID);
            // $retrievedReviewID = mysqli_fetch_assoc($queryReviewID);
            // $reviewID = $retrievedReviewID['studentCourseReview_id'];

            $sqlInsertReplyMessage = "UPDATE reviewReplies SET replyToReply = '$replyToReplyMessage'
                WHERE reply_id = $replyID";
            $queryInsert = mysqli_query($connectToDB, $sqlInsertReplyMessage);

            if($sqlInsertReplyMessage){
                echo"SUCCESS INSERT REPLY TO REPLY";
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