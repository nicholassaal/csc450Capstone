<!DOCTYPE html>
<html>

<head>
    <title>ADMIN Student/Staff Update</title>
    <link rel="stylesheet" type="text/css" href="addUpdateDelete.css">
</head>

<body>
    <nav id="navbar">
        <ul>
            <li>
                <h1>Update Student/Staff Info</h1>
            </li>
            <li style="float: right"><a href="http://localhost/csc450Capstone/LoginPage/LoginPage.php">Sign Out</a></li>
            <li style="float: right"><a href="http://localhost/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a>
            </li>
            <li style="float: right"><a href="http://localhost/csc450Capstone/profileView/profiles.php">My Profile</a>
            </li>
            <li style="float: right"><a href="http://localhost/csc450Capstone/LandingPage/LandingPage.php">Home</a></li>
        </ul>
        
    </nav>
    <form class = "add" action="#" method="get">
        <h1>Add New Student/Staff</h1>
        <label for="fname">Enter First Name:</label>
        <input type="text" id="fname" name="fname"><br><br>
        <label for="lname">Enter Last name:</label>
        <input type="text" id="lname" name="lname"><br><br>


        <label for="fname">Enter ID Number:</label>
        <input type="text" id="idNum" name="idNum"><br><br>
        <input type="submit" value="Submit"><br><br>

        <h1>Update Existing Student/Staff</h1>
        <label for="fname">Enter Current First Name:</label>
        <input type="text" id="fname" name="fname"><br><br>
        <label for="fname">Enter New First Name:</label>
        <input type="text" id="fname" name="fname"><br><br>
        <label for="lname">Enter Current Last name:</label>
        <input type="text" id="lname" name="lname"><br><br>
        <label for="lname">Enter New Last name:</label>
        <input type="text" id="lname" name="lname"><br><br>
        <input type="submit" value="Submit"><br><br>

        <h1>Delete Existing Student/Staff</h1>
        <label for="fname">Enter First Name:</label>
        <input type="text" id="fname" name="fname"><br><br>
        <label for="lname">Enter Last name:</label>
        <input type="text" id="lname" name="lname"><br><br>
        <input type="submit" value="Submit"><br><br>

    </form> 
    <script>
    var prevScrollpos = window.pageYOffset;
    window.onscroll = function() {
        var currentScrollPos = window.pageYOffset;
        if (prevScrollpos > currentScrollPos) {
            document.getElementById("navbar").style.top = "0";
        } else {
            document.getElementById("navbar").style.top = "-150px";
        }
        prevScrollpos = currentScrollPos;
    }
    </script>
</body>

</html>