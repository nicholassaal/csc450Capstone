<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adminHome.css">
    <title>Admin Page</title>
</head>
<body>
  <nav id="navbar">
    <ul>
        <li><a class="adminHome" href="http://localhost/csc450Capstone/AdminPages/adminHome.php">Admin Home</a></li>
        <li><a href="http://localhost/csc450Capstone/LoginPage/logOut.php">Sign Out</a></li>
        <li><a href="http://localhost/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a></li>
        <li><a href="http://localhost/csc450Capstone/LandingPage/LandingPage.php">Users Home</a></li>
    </ul> 
  </nav>
      
      <div class="flex-container">
        <a href="addUpdateDelete.php">Add Student and Staff</a>
        <a href="courseUpdate.php">Update/ Add Course</a>
        <a href="ticketRequest.php">Ticket Requests</a>
      </div>
     
    
</body>
</html>

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