<!-- 
============================================================================

Josiah Skorseth
skorsetj@csp.edu
CSC 450 Capstone
1/24/2022
Capstone (early stages UI profiles)

url: http://localhost/csc450Capstone/profileView/profiles.php

============================================================================
-->
<?php 

    echo "<br><br><br><br><br>";

    function reviewCreator() {
        $i = 0;
        echo "<fieldset class = reviewField>";
        echo "<legend class = reviewLegend>Sample Header: </legend>";
        while ($i < 21) {
            echo "<div class = reviewBox>";
                echo "<p>Sample Review</p>";
            echo "</div>";
            $i += 1;
        }
        echo "</fieldset>";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" type = "text/css" href = "profiles.css">
    <style>
        <?php include("profiles.css"); ?>
    </style>
    <title>User Profile</title>
</head>
<body>
    <div class = "stickyHead">
        <h1 class = "pageName">CSP Student Profile</h1>
        <div class = "wrapButton">
            <ul>
                <li id = "loginBtn"><a href = "http://localhost/csc450Capstone/LoginPage/LoginPage.php">Login Page</a></li>
                <li id = "landingBtn"><a href = "http://localhost/csc450Capstone/LandingPage/LandingPage.php">Landing Page</a></li>
                <li id = "profileBtn"><a href = "http://localhost/csc450Capstone/ProfileView/profiles.php">Profile Page</a></li>
                <li id = "perMajorBtn"><a href = "http://localhost/csc450Capstone/MajorPage/CSCMajorPage.php">Major Page</a></li>
            </ul>
        </div>
    </div>

    <div class = "studentInfo">
        <div class = "studentDescript1">
            <a href = "graphic/cool_guy.png"><img src = "graphic/cool_guy.png" id = "examplePicture"></a>
        </div>
        <div class = "studentDescript2">
            <fieldset class = "studentField">
                <legend class = "infoLegend">Student Information:</legend>
                <p>Name: Josiah Skorseth</p>
                <p>University Location: Concordia Saint Paul</p> 
                <p>IDK SOMETHING GOES HERE??????</p>
                <p>IDK SOMETHING GOES HERE??????</p>
                <p>IDK SOMETHING GOES HERE??????</p>
            </fieldset>
        </div>
    </div>

    <div>
        <?php reviewCreator(); ?>
    </div>

    <div>
        <fieldset class = "otherInfoField">
            <legend class = "otherInfoLegend">Other Info: </legend>
            <p>IDK SOMETHING GOES HERE??????</p>
            <p>IDK SOMETHING GOES HERE??????</p>
            <p>IDK SOMETHING GOES HERE??????</p>
            <p>IDK SOMETHING GOES HERE??????</p>
            <p>IDK SOMETHING GOES HERE??????</p>
            <p>IDK SOMETHING GOES HERE??????</p>
        </fieldset>
    </div>

    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <p>Hi There Gurt</p>
</body>
</html>
