<?php
include("ticketRequest_inc.php");

//creating function to get users profile pictures for the Nav bar

function navGetProfilePicture()
{
    global $connectToDB;
    $sqlStudentInfo = "SELECT * FROM studentinfo";

    //Run and assign query 
    $data = mysqli_query($connectToDB, $sqlStudentInfo);
    //While loop to retrieve data from studentInfo table. 
    while ($rows = mysqli_fetch_array($data)) {
        $studentId = $rows['student_id'];
        $image = $rows['user_image'];
        if ($studentId == $_SESSION["currentUserLoginId"]) {
            if($image === null){
                echo  "<img  src='../profileView/upload/defaultProfile.jpg' alt='img' id ='profilePictureImage'>";
            }
            else {
                echo  "<img  src='../profileView/upload/" . $image . "' alt='img' id ='profilePictureImage'>";
            }
        }
    }
} //end of navGetProfilePicture()
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../globalStyle/navBarStyling.css">
    <link rel="stylesheet" href="ticketRequest.css">
    <title>Ticket Request</title>
</head>

<body>

    <!-- ************************************************* SCROLL FUNCTIONALITY ************************************************* -->
    <nav id="navbar">
        <script>
            var lastScrollTop; // This Varibale will store the top position

            navbar = document.getElementById('navbar'); // Get The NavBar

            window.addEventListener('scroll', function() {
                //on every scroll this funtion will be called

                var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                //This line will get the location on scroll

                if (scrollTop > lastScrollTop) { //if it will be greater than the previous
                    navbar.style.top = '-80px'; //set the value to the negetive of height of navbar       
                } else {
                    navbar.style.top = '0';
                }

                lastScrollTop = scrollTop; //New Position Stored
            });
        </script>
        <!-- ************************************************* SCROLL FUNCTIONALITY ************************************************* -->

        <!-- ************************************************** URL's FOR NAV BAR *************************************************** -->
        <ul class="menu">
            <li class="logo" id="logo">CSP Ticket Request Page</li>
            <li class="item"><a href="https://thewoodlandwickcandleco.com/csc450Capstone/LandingPage/LandingPage.php">Home</a></li>
            <li class="item">
                <div id="navImage">
                    <?php navGetProfilePicture() ?>
                </div>
            </li>
            <li class="item"><a href="https://thewoodlandwickcandleco.com/csc450Capstone/profileView/profiles.php">Profile</a></li>
            <li class="item"><a href="https://thewoodlandwickcandleco.com/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a></li>
            <li class="item button"><a href="https://thewoodlandwickcandleco.com/csc450Capstone/LoginPage/logOut.php">Sign Out</a></li>
            <li class="toggle"><span class="bars"></span></li>
        </ul>

        <!-- <ul class="menu">
            <li class="logo" id="logo">Ticket Request</li>
            <li class="item"><a href="http://localhost/csc450Capstone/ticketRequest/ticketRequest.php">Ticket Request</a></li>
            <li class="item"><a href="http://localhost/csc450Capstone/LandingPage/LandingPage.php">Home</a></li>
            <li class="item"><a href="http://localhost/csc450Capstone/profileView/profiles.php">Profile</a></li>
            <li class="item"><a href="http://localhost/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a></li>
            <li class="item button"><a href="http://localhost/csc450Capstone/LoginPage/logOut.php">Sign Out</a></li>
            <li class="item button secondary"><a href="#">Sign Up</a></li>
            <li class="toggle"><span class="bars"></span></li>
        </ul> -->
    </nav>
    <!-- ************************************************** URL's FOR NAV BAR *************************************************** -->

    <!-- ************************************************* FORM FOR TICKET REQ. ************************************************* -->
    <form method="POST">
        <div class="outside-container">
            <fieldset class=overallTicketField>
                <legend class=ticketLegend name=ticketLegend>Ticket Request Form</legend>
                <div class="div_container">

                    <div class="inner_Left_Div">
                        <label class="firstNameChange">First Name Change:</label>
                        <input type="text" id="firstNameChangeInput" name="firstNameChange" required><br><br>

                        <label class="lastNameChange">Last Name Change:</label>
                        <input type="text" id="lastNameChangeInput" name="lastNameChange" required><br><br>

                        <label class="majorChange">Major Change:</label>
                        <?php populateMajorDropdown(); ?>
                    </div>

                    <div class="inner_Right_Div">
                        <!-- Container for the tables and the button to float to the right of the fieldset -->
                        <!-- ************************** ENROLLMENT Status table ************************** -->
                        <table class="tableEnrolled">
                            <tr>
                                <th colspan="2">Are you enrolled?</th>
                            </tr>
                            <tr>
                                <th scope="col" class="radio_Yes">Yes</th>
                                <th scope="col" class="radio_No">No</th>
                            </tr>
                            <tr>
                                <td><input type="radio" id="enrolled1" name="enrolled" value="1" required></td>
                                <td><input type="radio" id="enrolled2" name="enrolled" value="0" required></td>
                            </tr>
                        </table>
                        <!-- ************************** ENROLLMENT Status table ************************** -->

                        <!-- ************************** ON_CAMPUS Status table ************************** -->
                        <table class="tableOnCampus">
                            <tr>
                                <th colspan="2">Are you on campus?</th>
                            </tr>
                            <tr>
                                <th scope="col" class="radio_Yes">Yes</th>
                                <th scope="col" class="radio_No">No</th>
                            </tr>
                            <tr>
                                <td><input type="radio" id="onCampus1" name="onCampus" value="1" required></td>
                                <td><input type="radio" id="onCampus2" name="onCampus" value="0" required></td>
                            </tr>
                        </table>
                        <!-- ************************** ON_CAMPUS Status table ************************** -->

                        <button type="submit" name="sendTicket" id="ticketBtn" class="ticketBtn">Submit Ticket</button>
                    </div>
                </div>
            </fieldset>
        </div>
    </form>
    <!-- ************************** END OF FORM FOR TICKET REQ. ************************** -->

    <!-- ************************** TICKET REQUEST MESSAGE ADMIN/USER ************************** -->
    <!-- NOTE: TR stands for 'Ticket Request' -->
    <fieldset class=containerForTRMessage>
        <legend class=ticketRequestMessageLegend>Ticket Request Status</legend>
        <div class="ticketRequestContainer">

            <?php sqlStatementsForTicketRequestTable(); ?>


        </div>

    </fieldset>

    <footer>
        <a href="">Group 1 CSC 450 Capstone Neng Yang | Josiah Skorseth | Mitchell Williamson | Nicholas Saal</a>
    </footer>

</body>

</html>