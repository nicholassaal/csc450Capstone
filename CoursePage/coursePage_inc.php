<?php
    $numIterator = 1;  
    function displayCourseReviewMessage()
    {
        global $connectToDB;
        global $courseCode;
        global $numIterator;
        
        //Retrieve the review message in studentCourse table
        $sqlStudentCourse = "SELECT * FROM studentcourse WHERE course_code = $courseCode";
    
    
        //Run and assign query 
        $data = mysqli_query($connectToDB, $sqlStudentCourse);
    
        $arrayIndex = 0;
        //$numIterator = 1;
    
        while ($rows = mysqli_fetch_array($data)) {
            
            $courseReviewMessage = $rows['review_message']; //Retrieve the review_message
            $dateOfWrittenReview = $rows['review_date_written'];
            $studentID = $rows['student_id']; //Retrieve the student_id in studentCourse Table
            $studentIdArray[] = $studentID;
    
            /*************** WORKING ON ***************/
    
            $sqlReviewRating = "SELECT overall_review_rating FROM studentcourse WHERE student_id = $studentID AND course_code = $courseCode";
    
            $sqlReviewQuery = mysqli_query($connectToDB, $sqlReviewRating);
            $retrieveReview = mysqli_fetch_assoc($sqlReviewQuery);
    
            $reviewRatings = $retrieveReview['overall_review_rating'];
    
            echo $reviewRatings;
            echo "<form method=POST>";
                echo "<button type = submit name = reviewBtn$numIterator id = reviewBtn$numIterator> Like the Review </button>";
            echo "</form>";
    
            if(isset($_POST['reviewBtn'.$numIterator])){
                $sqlUpdateReviewRating = "UPDATE studentcourse SET overall_review_rating = $reviewRatings+1 WHERE student_id = $studentID AND course_code = $courseCode";
                $sqlUpdateReviewQuery = mysqli_query($connectToDB, $sqlUpdateReviewRating);
                if ($sqlUpdateReviewQuery) {
    
                } else {
                    print_r($sqlUpdateReviewQuery);
                }
            } //if(isset($_POST[]))
    
            /*************** WORKING ON ***************/
    
            //Retrieve the student id and full name using CONCAT()
            $sqlStudentInfo = "SELECT CONCAT(student_fname,' ',student_lname) AS 'fullName' FROM studentInfo
                WHERE student_id = $studentID";
    
            //Run query 
            $sqlStudentTable = mysqli_query($connectToDB, $sqlStudentInfo);
            $retrieveStudentName = mysqli_fetch_assoc($sqlStudentTable);
    
            //Assign the fullname to a variable once retrieved above 
            $studentName = $retrieveStudentName['fullName'];
    
            //Display reviews 
            echo "<div class = 'reviewMessageContainer'> <a name = $studentID>";
                echo "<h1>" . $studentName . "</h1>";
                echo "<button type = button name = submit class = btn id = btn>  
                                <a href = http://localhost/csc450Capstone/profileView/otherProfile.php?uid=$studentIdArray[$arrayIndex]>View Profile</a> 
                            </button>";
                echo "<h2>" . $courseReviewMessage . "</h1>";
                echo "<h4 class=reviewDateWritten>Date Written: " . $dateOfWrittenReview . "</h4>";
            echo "</a>";
    
            //REPLY button 
            echo "<button type = button name = replyBtn id = replyBtn$numIterator onclick=toggleReplyForm()>Reply</button>";
            
            //START OF FORM TO REPLY TO REVIEWS
            echo "<form method=POST id=replyForms$numIterator class=replyForms$numIterator>";
                echo"<textarea style='resize:none;' name='replyMessage' id='replyMessage' cols='50%' rows='10' placeholder='Reply to the review'></textarea>";
                echo"<button type = 'submit' id='replySubmitBtn$numIterator' name='replySubmitBtn$numIterator'>Reply</button>";
                echo"<button type = 'button' id='cancelReplyBtn' name='cancelReplyBtn' onclick='toggleReplyForm()'>Cancel</button>";
            echo "</form>";
        

            if(isset($_POST['replySubmitBtn'.$numIterator])){
                replyForm($connectToDB, $studentID);
            }
            
            viewReplies($studentID);

            echo"</div>";//end of review message div
            $arrayIndex++;
            $numIterator++;
        } //end of while loop
    } //end of displayCourseReviewMessage()
    
    function displayReplies($replyID){
        global $connectToDB;
        global $courseCode;
        //Retrieve all the replies for a certain review message using the replyID 
        $sqlRetrieveReplies = "SELECT * FROM replies WHERE reply_id = $replyID";
        $queryRetrieveReplies = mysqli_query($connectToDB, $sqlRetrieveReplies);
                //Retrieve all the rows that associate with the replyID
                while ($rows = mysqli_fetch_array($queryRetrieveReplies)) {
                    
                    $studentID = $rows['student_id'];//The student's id that wrote the reply
                    $replyMessage = $rows['reply_message'];
                    $replyDateWritten = $rows['date_written'];
    
                    //Retrieve the student id and full name using CONCAT()
                    $sqlStudentInfo = "SELECT CONCAT(student_fname,' ',student_lname) AS 'fullName' FROM studentInfo WHERE student_id = $studentID";
                    $sqlStudentTable = mysqli_query($connectToDB, $sqlStudentInfo);
                    $retrieveStudentName = mysqli_fetch_assoc($sqlStudentTable);
                    $studentName = $retrieveStudentName['fullName'];//Assign the fullname to a variable once retrieved above 
                    
                    echo"<div class=viewReplySection>";
                        echo"<h2 class=replyNames>".$studentName."</h2>";
                        echo"<h3>".$replyMessage."</h3>";
                        echo"<p class=replyDate>Date Written: " . $replyDateWritten . "</p>";
                    echo"</div>";
                }//end of while loop 
    }//end of displayReplies()

    function viewReplies($studentID){
        global $connectToDB;
        $numOfReplies = onlyViewifExists($studentID); 
        
        $sqlRetrieveReviewID = "SELECT studentCourseReview_id FROM studentCourse WHERE student_id = $studentID";
        $queryReviewID = mysqli_query($connectToDB, $sqlRetrieveReviewID);
        echo "<details>";//Details for viewing the replies
            echo"<summary>View Replies (".$numOfReplies.")</summary>";
                while($reviewRows = mysqli_fetch_array($queryReviewID)){
                    $studentCourseReview_id = $reviewRows['studentCourseReview_id']; //The student's id that wrote the reply

                    $sqlRetrieveReplies = "SELECT * FROM reviewReplies";
                    $queryRetrieveReplies = mysqli_query($connectToDB, $sqlRetrieveReplies);
                
                    while($reviewRepliesRows = mysqli_fetch_array($queryRetrieveReplies)){
                        $reviewReplies_id = $reviewRepliesRows['studentCourseReview_id'];
                        $replyID = $reviewRepliesRows['reply_id'];

                        if($studentCourseReview_id == $reviewReplies_id){//If there is a reply, retrieve the reply
                            displayReplies($replyID);
                        }   
                    }//end of inner while loop 
                }//end of outter while loop 
        echo "</details>";
        //END OF VIEW REPLY SECTION
    }//end of viewReplies();
    
    function onlyViewifExists($studentID){
        global $connectToDB;
        $numOfReplies = 0;   
        $arrayOfNumOfReplies[] = 1; 

        $sqlRetrieveReviewID = "SELECT studentCourseReview_id FROM studentCourse WHERE student_id = $studentID";
        $queryReviewID = mysqli_query($connectToDB, $sqlRetrieveReviewID);
        
        if(count($arrayOfNumOfReplies) > 0){
            unset($arrayOfNumOfReplies[0]);
            //unset($arrayOfNumOfReplies[1]);
        }

        while($reviewRows = mysqli_fetch_array($queryReviewID)){
            $studentCourseReview_id = $reviewRows['studentCourseReview_id'];

            $sqlRetrieveReplies = "SELECT * FROM reviewReplies";
            $queryRetrieveReplies = mysqli_query($connectToDB, $sqlRetrieveReplies);

            while($reviewRepliesRows = mysqli_fetch_array($queryRetrieveReplies)){
                $reviewReplies_id = $reviewRepliesRows['studentCourseReview_id'];

                if($studentCourseReview_id == $reviewReplies_id){//If there is a reply, retrieve the reply
                    $arrayOfNumOfReplies[] = $studentCourseReview_id; 
                }   
            }//end of inner while loop 
        }//end of outter while loop
        
        for($i = 1; $i <= count($arrayOfNumOfReplies)-1; $i++){
            if($arrayOfNumOfReplies[$i] == $arrayOfNumOfReplies[$i+1]){
                $numOfReplies+=2;
            }
            else{
                $numOfReplies++;
            }
        }
        
        return $numOfReplies;
    }//end of onlyViewifExists()


    function replyForm($connectToDB, $studentID){
        global $courseCode;

        //Student's reply to a review message inputs 
        $replyMessage = $_POST['replyMessage'];
        $currentLoggedStudent = $_SESSION["currentUserLoginId"];

            $sqlInsertReply = "INSERT INTO reviewMessageReplies (student_id, course_code, reply_message, date_written)
            VALUES ('$currentLoggedStudent', '$courseCode', '$replyMessage', '2002-02-02')";

            $queryInsertReply = mysqli_query($connectToDB, $sqlInsertReply);

            $sqlUpdateReplyID = "SELECT reply_id FROM reviewMessageReplies WHERE student_id = $currentLoggedStudent AND course_code = $courseCode";
            $queryUpdateReplyID = mysqli_query($connectToDB, $sqlUpdateReplyID);
            $retrievedReplyID = mysqli_fetch_assoc($queryUpdateReplyID);
            $replyID = $retrievedReplyID['reply_id'];

            $sqlUpdateReplyID = "UPDATE studentCourse SET reply_id = $replyID WHERE student_id = $studentID AND course_code = $courseCode"; 
            $queryUpdateReplyID = mysqli_query($connectToDB, $sqlUpdateReplyID);
    }//end of replyForm();

    function retrieveReviewReplies($connectToDB,){
        $sqlRetrieveReplies = "SELECT * FROM reviewReplies";
        $queryRetrieveReplies = mysqli_query($connectToDB, $sqlRetrieveReplies);

        while ($rows = mysqli_fetch_array($queryRetrieveReplies)) {
            $studentCourseReview_id = $rows['studentCourseReview_id'];//The student's id that wrote the reply
            $replyID = $rows['reply_id'];
            
        }//end of while loop 
    }//end of retrieveReviewReplies
    
?>