<?php
    date_default_timezone_set('America/Chicago');

    $numIterator = 0;  
    function displayCourseReviewMessage()
    {
        echo"<div class='review-flex-container'>";
        global $connectToDB;
        global $courseCode;
        global $numIterator;
        
        //Retrieve the review message in studentCourse table
        $sqlStudentCourse = "SELECT * FROM studentcourse WHERE course_code = $courseCode";
    
    
        //Run and assign query 
        $data = mysqli_query($connectToDB, $sqlStudentCourse);
    
        $arrayIndex = 0;

        while ($rows = mysqli_fetch_array($data)) {
            $reviewID = $rows['studentCourseReview_id']; 
            $courseReviewMessage = $rows['review_message']; //Retrieve the review_message
            $q1Answer = $rows['q1Answer'];
            $q2Answer = $rows['q2Answer'];
            $q3Answer = $rows['q3Answer'];
            $dateOfWrittenReview = $rows['review_date_written'];
            $studentID = $rows['student_id']; //Retrieve the student_id in studentCourse Table
            $studentIdArray[] = $studentID;
    
            /*****************************************
             ***         LIKING REVIEWS            ***
             *****************************************/
            $sqlReviewRating = "SELECT overall_review_rating FROM studentcourse WHERE student_id = $studentID AND course_code = $courseCode";
    
            $sqlReviewQuery = mysqli_query($connectToDB, $sqlReviewRating);
            $retrieveReview = mysqli_fetch_assoc($sqlReviewQuery);
    
            $overallReviewRatings = $retrieveReview['overall_review_rating'];
    
            echo"<p class=overallRatingsP>$overallReviewRatings</p>";

            echo "<form method=POST action= formActions.php?id=$courseCode >";
                echo"<input type='hidden' name='reviewID' value= '$reviewID'>";
                echo"<input type='hidden' name='studentReviewID' value= '$studentID'>";
                echo"<input type='hidden' name='overallReviewRatings' value= '$overallReviewRatings'>";
                echo "<button type = submit name = likeReviewBtn id = likeReviewBtn><div class = 'carret up'></div></button>";
            echo "</form>";

            /*****************************************
            ***         Display Reviews            ***
            *****************************************/
    
            //Retrieve the student id and full name using CONCAT()
            $sqlStudentInfo = "SELECT CONCAT(student_fname,' ',student_lname) AS 'fullName' FROM studentinfo
                WHERE student_id = $studentID";
    
            //Run query 
            $sqlStudentTable = mysqli_query($connectToDB, $sqlStudentInfo);
            $retrieveStudentName = mysqli_fetch_assoc($sqlStudentTable);
    
            //Assign the fullname to a variable once retrieved above 
            $studentName = $retrieveStudentName['fullName'];
            
            //EDIT REVIEW BUTTON
            if($studentID == $_SESSION['currentUserLoginId']){
                echo "<button type='button' class='editReviewFormBtn'>Edit</button>";
            }
            echo"<div class=reviewBackGround>";
                //Display reviews 
                echo "<div class = 'reviewMessageContainer'> <a name = $studentID>";
                    
                /*****************************************
                ***   CALLING EDITING REVIEWS FORM     ***
                *****************************************/
                editReviewForm($studentID, $reviewID);

                    echo "<h2>" . $studentName . "</h2>";
                    echo "<button type = button name = submit class = btn id = btn>  
                                    <a href = http://thewoodlandwickcandleco.com/csc450Capstone/profileView/otherProfile.php?uid=$studentIdArray[$arrayIndex]>View Profile</a> 
                                </button>";
                    //QUESTION 1 CONTAINER
                    echo"<div class=questionsDivContainer>";
                        echo"<div class=q1Review>";
                            echo"<h3 class = questionHeaders>What did you learn?</h3>";
                            echo"<p>$q1Answer</p>";
                        echo"</div>";
                        //QUESTION 2 CONTAINER
                        echo"<div class=q2Review>";
                            echo"<h3 class = questionHeaders>How would you suggest others prepare for this course?</h3>";
                            echo"<p>$q2Answer</p>";
                        echo"</div>";
                        //QUESTION 3 CONTAINER
                        echo"<div class=q3Review>";
                            echo"<h3 class = questionHeaders>What did you find the most challenging about this course?</h3>";
                            echo"<p>$q3Answer</p>";
                        echo"</div>";
                    echo"</div>";//end of questionsDivContainer
                    //ADDITIONAL REVIEW MESSAGE CONTAINER
                    echo"<div class = reviewMessage>";
                        echo"<h3 class = questionHeaders>Student Review:</h3>";
                        echo"<p class= courseReviewMessage>$courseReviewMessage</p>";
                    echo"</div>";
                    echo "<h4 class=reviewDateWritten>Date Written: " . $dateOfWrittenReview . "</h4>";
                echo "</a>";

                //REPLY button 
                    echo "<button type = button class=replyBtn>Reply</button>";
                    /*****************************************
                     START OF FORM TO REPLY TO REVIEWS
                    *****************************************/
                            echo "<form method=POST action= formActions.php?id=$courseCode id=replyForms$numIterator class=replyForms>";
                                echo"<textarea style='resize:none;'name='replyMessage' class='replyMessage' id='replyMessage' cols='50%' rows='10' placeholder='Reply to the review'></textarea>";
                                echo"<input type='hidden' name='dateWritten' value= ".date('Y-m-d').">";
                                echo"<input type='hidden' name='studentReviewID' value= '$studentID'>";
                                echo"<input type='hidden' name='reviewID' value= '$reviewID'>";
                                echo"<button type = 'submit' id='replySubmitBtn' name='replySubmitBtn'>Reply</button>";
                            echo "</form>";
                    /*****************************************
                     VIEW ALL REPLIES TO REVIEW FUNCTION 
                    *****************************************/
                    viewReplies($studentID, $reviewID);
                echo"</div>";//end of review message div
            echo"</div>";//outter background div
            $arrayIndex++;
            $numIterator++;
        } //end of while loop

        echo"</div>";//End of outer review container
    } //end of displayCourseReviewMessage()

    /*****************************************
            EDIT REVIEW FORM FUNCTION 
    *****************************************/
    function editReviewForm($studentID, $reviewID){ 
        global $connectToDB;
        global $courseCode;
        
        if($studentID == $_SESSION['currentUserLoginId']){
            $sqlRetrieveReview = "SELECT * FROM studentcourse WHERE studentCourseReview_id = $reviewID AND student_id = $studentID AND course_code = $courseCode";
            $queryReview = mysqli_query($connectToDB, $sqlRetrieveReview);
            $reviewRow = mysqli_fetch_assoc($queryReview);

            $q1Answer = $reviewRow['q1Answer'];
            $q2Answer = $reviewRow['q2Answer'];
            $q3Answer = $reviewRow['q3Answer'];
            $reviewMessage = $reviewRow['review_message'];
            

            echo "<form method='POST' action='formActions.php?id=$courseCode' class='editReviewForm' id='editReviewForm'>
                    <div class='leaveReviewForm' >
                        <div>
                            <h3>What did you learn?</h3>
                            <br>
                            <textarea name='editQ1' rows='5' cols='30' required>$q1Answer</textarea>
                        </div>
                        <div>
                            <h3>How would you suggest others prepare for this course?</h3>
                            <textarea name='editQ2' rows='5' cols='30' required>$q2Answer</textarea>
                        </div>
                        <div>
                            <h3>What did you find the most challenging about this course?</h3>
                            <textarea name='editQ3' rows='5' cols='30' required>$q3Answer</textarea>
                        </div>
                        <div class='addComment'>
                            <h3>Additional comments:</h3>
                            <textarea name='editReviewMessage' rows='5' cols='30' required>$reviewMessage</textarea>
                        </div>
                    </div>
                    <input type='hidden' name='dateWritten' value= ".date('Y-m-d').">
                    <input type='hidden' name='reviewID' value= ".$reviewID.">
                <button type='submit' name='editReviewBtn' id='editReviewBtn'>Submit Edit</button>
            </form>";
        }
        
    }//end of editReviewForm() function  

    /*****************************************
     VIEW ALL REPLIES TO REVIEW FUNCTION 
    *****************************************/
    $numIterator2 = 0;
    function viewReplies($studentID, $reviewID){
        global $connectToDB;
        global $courseCode;
        global $numIterator2;

        $sqlRetrieveReplies = "SELECT * FROM replies WHERE studentCourseReview_id = $reviewID AND replyToReply_id = '0'";
        $queryRetireveReplies = mysqli_query($connectToDB, $sqlRetrieveReplies);
        $numberOfReplies = mysqli_num_rows($queryRetireveReplies);

        $sqlRetrieveReviewID = "SELECT studentCourseReview_id FROM studentcourse WHERE student_id = $studentID";
        $queryReviewID = mysqli_query($connectToDB, $sqlRetrieveReviewID);
        echo "<details>";//Details for viewing the replies
            echo"<summary>View Replies (".$numberOfReplies.")</summary>";
                while($reviewRows = mysqli_fetch_array($queryReviewID)){
                    $studentCourseReview_id = $reviewRows['studentCourseReview_id']; //The student's id that wrote the reply

                    $sqlRetrieveReplies = "SELECT * FROM replies WHERE studentCourseReview_id = $studentCourseReview_id AND course_code = $courseCode AND replyToReply_id = 0";
                    $queryRetrieveReplies = mysqli_query($connectToDB, $sqlRetrieveReplies);

                            /*****************************************
                             RETRIEVE AND VIEW ALL REPLIES TO REVIEW 
                            *****************************************/
                            //Retrieve all the replies row that was written for that review 
                            while ($rows = mysqli_fetch_array($queryRetrieveReplies)) {
                                $replyID = $rows['reply_id'];
                                $studentID = $rows['student_id'];//The student's id that wrote the reply
                                $replyMessage = $rows['reply_message'];
                                $replyDateWritten = $rows['date_written'];
                                $replyToReplyID = $rows['replyToReply_id'];
                
                                $studentName = studentName($studentID);//Used studentName function to retrieve the student's name that wrote reply
                                
                                /*****************************************
                                        REPLY TO REPLIES FORM  
                                *****************************************/
                                echo"<div class=viewReplySection>";
                                    echo"<h2 class=replyNames>".$studentName."</h2>";
                                    echo"<p class=replyMessageP>".$replyMessage."</p>";
                                    echo"<p class=replyDate>Date Written: " . $replyDateWritten . "</p>";
                                        //START OF FORM TO REPLY TO REPLIES
                                        echo "<button type = button class=replyToReplyBtn>Reply</button>";
                                                echo "<form method=POST action=formActions.php?id=$courseCode id=replytoReplyForms$numIterator2 class=replytoReplyForms>";
                                                    echo"<textarea style='resize:none;' name='replyToReplyMessage' class='replyToReplyMessage' id='replyToReplyMessage' cols='50%' rows='10' placeholder='Reply'></textarea>";
                                                    echo"<input type='hidden' name='dateWritten2' value= ".date('Y-m-d').">";
                                                    echo"<input type='hidden' name='reviewID' value= '$reviewID'>";
                                                    echo"<input type='hidden' name='studentReviewID' value= '$studentID'>";
                                                    echo"<input type='hidden' name='replyID' value= '$replyID'>";
                                                    echo"<button type = 'submit' id='replyBtn2' name='replyBtn2'>Reply</button>";
                                                echo "</form>";
                                                
                                        viewRepliesToReplies($reviewID, $replyID);
                                        $numIterator2++;
                                echo"</div>";//end of viewRepliesSection <div>
                    }//end of inner while loop to retrieve replies
                }//end of outter while loop to retrieve the review id
        echo "</details>";
        //END OF VIEW REPLY SECTION
    }//end of viewReplies();

    /*****************************************
     VIEW ALL REPLIES TO REPLIES FUNCTION 
    *****************************************/
    function viewRepliesToReplies($reviewID, $replyID){
        global $connectToDB;
        global $courseCode;
            
            $sqlRepliesToReplies = "SELECT * FROM replies WHERE studentCourseReview_id = $reviewID AND replyToReply_id = $replyID";//Get all replies to replies that match a reply_id
            $queryReplyToReplies = mysqli_query($connectToDB, $sqlRepliesToReplies);
            $numberOfRepliesToReplies = mysqli_num_rows($queryReplyToReplies);
            echo "<details class=replyToRepiesDetails>";//Details for viewing the replies
                echo"<summary>View Replies (".$numberOfRepliesToReplies.")</summary>";
                    while($replyToReplies = mysqli_fetch_array($queryReplyToReplies)){
                        $replyMessage = $replyToReplies['reply_message'];
                        $replyDateWritten = $replyToReplies['date_written'];
                        $studentID = $_SESSION["currentUserLoginId"];
                        $studentName = studentName($studentID);//Used studentName function to retrieve the student's name that wrote reply
                                echo"<div class=replyToRepiesDiv>";
                                    echo"<h2 class=replyNames>".$studentName."</h2>";
                                    echo"<p class=replyMessageP>".$replyMessage."</p>";
                                    echo"<p class=replyToReplyDate>Date Written: " . $replyDateWritten . "</p>";
                                echo"</div>";
                    }//end of while loop to retrieve all replies to replies
            echo "</details>";
        }//end of viewRepliesToReplies()

    /*****************************************************
     RETRIEVE THE STUDENT'S NAME THAT WROTE REPLY FUNCTION
    *****************************************************/
    function studentName($studentID){
        global $connectToDB;
        //Retrieve the student's full name using CONCAT() that wrote the reply
        $sqlStudentInfo = "SELECT CONCAT(student_fname,' ',student_lname) AS 'fullName' FROM studentinfo WHERE student_id = $studentID";
        $sqlStudentTable = mysqli_query($connectToDB, $sqlStudentInfo);
        $retrieveStudentName = mysqli_fetch_assoc($sqlStudentTable);
        $studentName = $retrieveStudentName['fullName'];//Assign the fullname to a variable once retrieved above 
        return $studentName;
    }//end of studentName()
    
    /*****************************************************
                CHECK IF THE USER ALREADY WROTE A REVIEW
    *****************************************************/
    function writtenReviewCheck(){
        global $connectToDB;
        global $courseCode;

        $currentLoggedStudent = $_SESSION['currentUserLoginId'];
        $sqlCheckReview = "SELECT * FROM studentcourse WHERE student_id = $currentLoggedStudent AND course_code = $courseCode";
        $queryCheckReview = mysqli_query($connectToDB, $sqlCheckReview);
        
        if(mysqli_num_rows($queryCheckReview) == 1){
            echo"<button type='button' id='checkIfReviewExist'>You already written a review</button>";
        }
        else{
            echo"<button type='button' id='leaveReview' onclick='toggleLeavingReview()'>Leave a Review</button>";
        }
    }//end of writtenReviewCheck()

   /*****************************************************
        Display the number
    *****************************************************/
    function howManyRepliesWritten($reviewID){
        global $connectToDB;
        global $courseCode;

        $sqlRetrieveReplies = "SELECT * FROM replies WHERE studentCourseReview_id = $reviewID";
        $queryRetireveReplies = mysqli_query($connectToDB, $sqlRetrieveReplies);
        $numberOfReplies = mysqli_num_rows($queryRetireveReplies);
        return $numberOfReplies;
    }//end of howManyRepliesWritten() function 
?>