<?php
    date_default_timezone_set('America/Chicago');

    $numIterator = 0;  
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
            $reviewID = $rows['studentCourseReview_id']; 
            $courseReviewMessage = $rows['review_message']; //Retrieve the review_message
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
    
            echo $overallReviewRatings;
            echo "<form method=POST action= formActions.php?id=$courseCode>";
                echo"<input type='hidden' name='reviewID' value= '$reviewID'>";
                echo"<input type='hidden' name='studentReviewID' value= '$studentID'>";
                echo"<input type='hidden' name='overallReviewRatings' value= '$overallReviewRatings'>";
                echo "<button type = submit name = likeReviewBtn id = likeReviewBtn> Like the Review </button>";
            echo "</form>";
    
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
            echo "<button type = button class=replyBtn id = replyBtn$numIterator onclick=f$numIterator()>Reply</button>";
            
            /*****************************************
             START OF FORM TO REPLY TO REVIEWS
             *****************************************/
            //echo "<details class=replyBtnDetails>";
                //echo "<summary id=replyBtnSummary>Reply</summary>";
                    echo "<form method=POST action= formActions.php?id=$courseCode id=replyForms$numIterator class=replyForms$numIterator>";
                        echo"<textarea style='resize:none;' name='replyMessage' id='replyMessage' cols='50%' rows='10' placeholder='Reply to the review'></textarea>";
                        echo"<input type='hidden' name='dateWritten' value= ".date('Y-m-d').">";
                        echo"<input type='hidden' name='reviewID' value= '$reviewID'>";
                        echo"<button type = 'submit' id='replySubmitBtn' name='replySubmitBtn'>Reply</button>";
                        echo"<button type = 'button' id='cancelReplyBtn' name='cancelReplyBtn' onclick='f$numIterator()'>Cancel</button>";
                    echo "</form>";
            //echo "</details>";
            /*****************************************
              VIEW ALL REPLIES TO REVIEW FUNCTION 
             *****************************************/
            viewReplies($studentID, $reviewID);

            echo"</div>";//end of review message div
            $arrayIndex++;
            $numIterator++;
        } //end of while loop

    } //end of displayCourseReviewMessage()

    /*****************************************
     VIEW ALL REPLIES TO REVIEW FUNCTION 
    *****************************************/
    function viewReplies($studentID, $reviewID){
        global $connectToDB;
        global $courseCode;
        
        $sqlRetrieveReviewID = "SELECT studentCourseReview_id FROM studentCourse WHERE student_id = $studentID";
        $queryReviewID = mysqli_query($connectToDB, $sqlRetrieveReviewID);
        echo "<details>";//Details for viewing the replies
            echo"<summary>View Replies</summary>";
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
                                    echo"<h3>".$replyMessage."</h3>";
                                    echo"<p class=replyDate>Date Written: " . $replyDateWritten . "</p>";
                                        //START OF FORM TO REPLY TO REPLIES
                                        echo "<details class=replyToReplyFrom>";
                                            echo "<summary class=replyToReplySummary>Reply</summary>";
                                                echo "<form method=POST action= formActions.php?id=$courseCode id=replyToReplyForms class=replytoReplyForms>";
                                                    echo"<textarea style='resize:none;' name='replyToReplyMessage' id='replyToReplyMessage' cols='50%' rows='10' placeholder='Reply to Reply'></textarea>";
                                                    echo"<input type='hidden' name='dateWritten2' value= ".date('Y-m-d').">";
                                                    echo"<input type='hidden' name='reviewID' value= '$reviewID'>";
                                                    echo"<input type='hidden' name='replyID' value= '$replyID'>";
                                                    echo"<button type = 'submit' id='replyBtn2' name='replyBtn2'>Reply</button>";
                                                    //echo"<button type = 'button' id='cancelReplyBtn' name='cancelReplyBtn' onclick='toggleReplyForms()'>Cancel</button>";
                                                echo "</form>";
                                        echo "</details>";
                                        viewRepliesToReplies($reviewID, $replyID);
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

            while($replyToReplies = mysqli_fetch_array($queryReplyToReplies)){
                $replyMessage = $replyToReplies['reply_message'];
                $replyDateWritten = $replyToReplies['date_written'];
                $studentID = $_SESSION["currentUserLoginId"];
                $studentName = studentName($studentID);//Used studentName function to retrieve the student's name that wrote reply
                echo "<details>";//Details for viewing the replies
                    echo"<summary>View Replies</summary>";
                        //echo"<div class=viewReplyToReplies>";
                            echo"<h2 class=replyNames>".$studentName."</h2>";
                            echo"<h3>".$replyMessage."</h3>";
                            echo"<p class=replyDate>Date Written: " . $replyDateWritten . "</p>";
                        //echo"</div";
                echo"</details>";
            }//end of while loop to retrieve all replies to replies
    }//end of viewRepliesToReplies()

    /*****************************************************
     RETRIEVE THE STUDENT'S NAME THAT WROTE REPLY FUNCTION
    *****************************************************/
    function studentName($studentID){
        global $connectToDB;
        //Retrieve the student's full name using CONCAT() that wrote the reply
        $sqlStudentInfo = "SELECT CONCAT(student_fname,' ',student_lname) AS 'fullName' FROM studentInfo WHERE student_id = $studentID";
        $sqlStudentTable = mysqli_query($connectToDB, $sqlStudentInfo);
        $retrieveStudentName = mysqli_fetch_assoc($sqlStudentTable);
        $studentName = $retrieveStudentName['fullName'];//Assign the fullname to a variable once retrieved above 
        return $studentName;
    }//end of studentName()
    
    /*****************************************************
    IN PROGRESS TO PRINT HOW MANY REPLIES
    *****************************************************/
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
                return $numOfReplies+=2;
            }
        }
        
        return $numOfReplies;
    }//end of onlyViewifExists()
    
?>