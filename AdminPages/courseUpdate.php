<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="courseUpdate.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <title>Review page </title>
</head>
<body>
 
    
    <ul>
        
        <li><a class="active" href="adminPage.html">Home</a></li>
        <li ><a href="http://localhost/csc450Capstone/LandingPage/LandingPage.php">Landing Page</a></li>
        <li ><a href="http://localhost/csc450Capstone/profileView/profiles.php">Profile</a></li>
        <li ><a href="http://localhost/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a></li>
      </ul>
   
    <div class="wrapper">
        <form action="" class="form-area">
            <div class="msg-area">
                <label for="msg">Corse Description</label>
                <textarea id="msg" ></textarea>
            </div>
            <div class="details-area">
                <label for="courseName">Corse Name</label>
                <input type="text" name="" id="courseName">

                <label for="courseId">Corse Id</label>
                <input type="text" name="" id="courseId">

                <label for="teacher">taught by</label>
                <input type="text" name="" id="teacher">
               
                <label for="teachers">Select the professor:</label>

                <select name="teacher" id="teacher">
                <option value="teacherID">Susan</option>
                <option value="teacherID">Tucker</option>
                <option value="teacherID">Joel</option>
                <option value="teacherID">Neng</option>
                </select>

                <button type="submit">Submit</button>
            </div>
          
        </form>
    </div>
    
</body>
</html>