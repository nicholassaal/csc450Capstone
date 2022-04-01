<?php 
session_start();
include("ticketRequest_inc.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ticketRequest.css">
    <link rel="stylesheet" type="text/css" href="../globalStyle/navBarStyling.css">
    <title>Ticket Request</title>
</head>
<body>

    <!-- ************************************************* SCROLL FUNCTIONALITY ************************************************* -->
<nav id="navbar">
    <script>
        var lastScrollTop; // This Varibale will store the top position

        navbar = document.getElementById('navbar'); // Get The NavBar

        window.addEventListener('scroll',function(){
        //on every scroll this funtion will be called
  
        var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        //This line will get the location on scroll
  
        if(scrollTop > lastScrollTop){ //if it will be greater than the previous
            navbar.style.top='-80px';//set the value to the negetive of height of navbar       
        }else{
            navbar.style.top='0';
        }
  
        lastScrollTop = scrollTop; //New Position Stored
        });
    </script>
    <!-- ************************************************* SCROLL FUNCTIONALITY ************************************************* -->

    <!-- ************************************************** URL's FOR NAV BAR *************************************************** -->
    <ul class="menu">
        <li class="logo" id="logo">Ticket Request</li>
        <li class="item"><a href="http://localhost/csc450Capstone/ticketRequest/ticketRequest.php">Ticket Request</a></li>
        <li class="item"><a href="http://localhost/csc450Capstone/LandingPage/LandingPage.php">Home</a></li>
        <li class="item"><a href="http://localhost/csc450Capstone/profileView/profiles.php">Profile</a></li>
        <li class="item"><a href="http://localhost/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a></li>
        <li class="item button"><a href="http://localhost/csc450Capstone/LoginPage/logOut.php">Sign Out</a></li>
        <!-- <li class="item button secondary"><a href="#">Sign Up</a></li> -->
        <li class="toggle"><span class="bars"></span></li>
    </ul>
</nav>
    <!-- ************************************************** URL's FOR NAV BAR *************************************************** -->
    
    <!-- ************************************************* FORM FOR TICKET REQ. ************************************************* -->
<form method = "POST">
    <div class = "outside-container">
        <fieldset class = overallTicketField>
            <legend class = ticketLegend name = ticketLegend>Ticket Request Form</legend>
            <div class = "div_container">
                <label class = "firstNameChange">First Name Change:</label>
                    <input type="text" id="firstNameChange" name="firstNameChange"><br><br>

                <label class = "lastNameChange">Last Name Change:</label>
                    <input type="text" id="lastNameChange" name="lastNameChange"><br><br>

                <label class = "majorChange">Major Change:</label>
                <?php populateMajorDropdown(); ?>   

                <div class = "inner_div_container"> <!-- Container for the tables and the button to float to the right of the fieldset -->
                    <!-- ************************** ENROLLMENT Status table ************************** -->
                    <table class = "tableEnrolled"> 
                        <tr>
                            <th colspan = "2">Are you enrolled?</th>
                        </tr>
                        <tr>
                            <th scope = "col" class = "radio_Yes">Yes</th>
                            <th scope = "col" class = "radio_No">No</th>
                        </tr>
                        <tr>
                            <td><input type="radio" id="enrolled1" name="enrolled" value = "1"></td>
                            <td><input type="radio" id="enrolled2" name="enrolled" value = "0"></td>
                        </tr>
                    </table>
                    <!-- ************************** ENROLLMENT Status table ************************** -->

                    <!-- ************************** ON_CAMPUS Status table ************************** -->
                    <table class = "tableOnCampus"> 
                        <tr>
                            <th colspan = "2">Are you on campus?</th>
                        </tr>
                        <tr>
                            <th scope = "col" class = "radio_Yes">Yes</th>
                            <th scope = "col" class = "radio_No">No</th>
                        </tr>
                        <tr>
                            <td><input type="radio" id="onCampus1" name="onCampus" value = "1"></td>
                            <td><input type="radio" id="onCampus2" name="onCampus" value = "0"></td>
                        </tr>
                    </table>
                    <!-- ************************** ON_CAMPUS Status table ************************** -->
                    
                    <button type = "submit" name = "sendTicket" id = "ticketBtn" class = "ticketBtn">Submit Ticket</button>
                </div>
            </div>
        </fieldset>

    </div>    
</form>
    <!-- ************************************************* FORM FOR TICKET REQ. ************************************************* -->
</body>
</html>