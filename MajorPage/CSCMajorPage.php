<?php
    session_start();

    $SERVER_NAME    = "localhost";   //Server name 
    $DBF_USER       = "root";        //UserName for the localhost database
    $DBF_PASSWORD   = "mysql";       //Password for the localhost database/ When using XAMPPS, make this value emtpy. Use: $DBF_PASSWORD   = "";
    $DBF_NAME       = "CSPCourseReview";    //DB name for the localhost database
    //$connect = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD);
    $connectToDB = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD, $DBF_NAME);

    // Check connection
    //$conn->connect_error: The connect_error property in the $conn (Connection) object. This property contains any error message from the last operation.
    if ($connectToDB->connect_error) { //-> is used to point to items contained in an object.
        die("Connection failed: " . $conn->connect_error); //die( ) will kill the current program after displaying the message in the String parameter.
    }



    $i = 1;
    function displayCourses() {
        global $connectToDB;
        global $i;
        $sqlStudentCourse = "SELECT * FROM course"; //selecting a specific table from the already connected to database

        //Run and assign query 
        $data = mysqli_query($connectToDB, $sqlStudentCourse);

        //div class for css
        echo "<div class='flex-container'>";

         
        //$courseArray = array();

        //While loop to populate each div container on the major page 
        while($rows = mysqli_fetch_array($data)) {
            $courseCode = $rows['course_code'];//Retrieve course_code
            $courseName = $rows['course_name'];//Retrieve course_name
            $courseDes = $rows['course_description'];//Retrieve course_name

            //$courseArray = array($i, $courseId); 

            ////////////echo $i; //Testing to see the div's numeric ID value 

            //Populate the div containers using data from the course table in the database
            echo"<div id = $i >";
                //echo"<a href='http://localhost/csc450Capstone/CoursePage/CoursePage.php' class='fill-div'>";
                    echo"<img src='Images/courseImage2.jfif' alt='waaaaaaa' />";
                    echo"<h1>".$courseName."</h1>";
                    echo"<h2>".$courseDes."</h1>";
                //echo"</a>";
            echo"</div>";
            //echo $i;
            if ( $i < mysqli_num_rows($data)) {
               $i++; 
            } else {
                break;
            }
            
            
            
        }

        

        //$_SESSION['globalCourseArray'] = $courseArray; 

        echo"</div>";
    }//end of displayCourses()

    $randomNum = 1;

?>



<!DOCTYPE html>
<html>

<head>
    <title>Majors</title>
    <link rel="stylesheet" type="text/css" href="majorStyle.css">
</head>

<body>
    <nav id="navbar">
        <ul>
            <li>
                <h1>Computer Science Courses</h1>
            </li>
            <li style="float: right"><a href="http://localhost/csc450Capstone/LoginPage/LoginPage.php">Sign Out</a></li>
            <li style="float: right"><a href="http://localhost/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a>
            </li>
            <li style="float: right"><a href="http://localhost/csc450Capstone/profileView/profiles.php">My Profile</a>
            </li>
            <li style="float: right"><a href="http://localhost/csc450Capstone/LandingPage/LandingPage.php">Home</a></li>
        </ul>
    </nav>
        <!-- displayCourse() function  -->
        <?php displayCourses(); ?>
    <!-- <div class="flex-container">
        <div>
            <a href="http://localhost/csc450Capstone/CoursePage/CoursePage.php" class="fill-div">
                <img src="Images/courseImage1.jfif" alt="" />
                <h1>CSC 101 Intoduction to Computer Science</h1>
                <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor mattis mi ac porta. Ut
                    ullamcorper
                    risus augue, at condimentum risus ultrices rutrum. In ultrices eu est ut euismod. Nulla.</h2>
            </a>
        </div>
        <div>
            <a href="http://localhost/csc450Capstone/CoursePage/CoursePage.php" class="fill-div">
                <img src="Images/courseImage2.jfif" alt="waaaaaaa" />
                <h1>CSC 115 Intoduction to Python</h1>
                <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam feugiat bibendum mauris. Duis in
                    commodo
                    risus. Nullam lacinia nibh at finibus venenatis. Vivamus luctus vel enim et faucibus. Morbi
                    malesuada.
                </h2>
            </a>
        </div>
        <div>
            <a href="http://localhost/csc450Capstone/CoursePage/CoursePage.php" class="fill-div">
                <img src="Images/courseImage3.jfif" alt="" />
                <h1>CSC 175 Math for Computer Science</h1>
                <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam pharetra ligula viverra nisi
                    condimentum posuere. In quis turpis eu nisl pretium egestas. Integer laoreet ipsum et dolor
                    venenatis
                    facilisis. Phasellus.</h2>
            </a>
        </div>
        <div>
            <a href="http://localhost/csc450Capstone/CoursePage/CoursePage.php" class="fill-div">
                <img src="Images/courseImage4.jfif" alt="" />
                <h1>CSC 222 Intoduction to Programming with Java</h1>
                <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer sit amet commodo ligula. Fusce
                    consectetur lacus at nisi volutpat molestie. Proin in pretium neque. Mauris fringilla nec odio at
                    molestie.</h2>
            </a>
        </div>
        <div>
            <a href="http://localhost/csc450Capstone/CoursePage/CoursePage.php" class="fill-div">
                <img src="Images/courseImage5.jfif" alt="" />
                <h1>CSC 135 Client-Side Wed Development</h1>
                <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pellentesque eu sapien vel
                    sollicitudin.
                    Suspendisse ac scelerisque erat. Fusce sed blandit diam. Integer nec ornare lorem. Sed at mattis
                    lectus.
                </h2>
            </a>
        </div>
        <div>
            <a href="http://localhost/csc450Capstone/CoursePage/CoursePage.php" class="fill-div">
                <img src="Images/courseImage6.jfif" alt="" />
                <h1>MAT 220 Discrete Mathematics</h1>
                <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque mollis et erat a feugiat.
                    Curabitur sit amet sapien a sem elementum hendrerit quis id ante. Aenean tristique condimentum
                    massa,
                    ac.</h2>
            </a>
        </div>
        <div>
            <a href="http://localhost/csc450Capstone/CoursePage/CoursePage.php" class="fill-div">
                <img src="Images/courseImage7.jfif" alt="" />
                <h1>CSC 230 Database Design</h1>
                <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget enim ut dolor malesuada
                    condimentum ac
                    sed mi. Maecenas ornare diam sed magna accumsan volutpat. Nunc placerat dolor consectetur justo.
                </h2>
            </a>
        </div>
        <div>
            <a href="http://localhost/csc450Capstone/CoursePage/CoursePage.php" class="fill-div">
                <img src="Images/courseImage8.jfif" alt="" />
                <h1>CSC 322 Object Oriented Programming in Java</h1>
                <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ut leo at est aliquam lacinia nec
                    id
                    justo. Mauris nec est tincidunt odio efficitur tempus venenatis eleifend tellus. Donec bibendum.
                </h2>
            </a>
        </div>
        <div>
            <a href="http://localhost/csc450Capstone/CoursePage/CoursePage.php" class="fill-div">
                <img src="Images/courseImage1.jfif" alt="" />
                <h1>CSC 235 Server-Side Development</h1>
                <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor mattis mi ac porta. Ut
                    ullamcorper
                    risus augue, at condimentum risus ultrices rutrum. In ultrices eu est ut euismod. Nulla.</h2>
            </a>
        </div>
        <div>
            <a href="http://localhost/csc450Capstone/CoursePage/CoursePage.php" class="fill-div">
                <img src="Images/courseImage1.jfif" alt="" />
                <h1>CSC 310 Computer Architecture and Operating Systems</h1>
                <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor mattis mi ac porta. Ut
                    ullamcorper
                    risus augue, at condimentum risus ultrices rutrum. In ultrices eu est ut euismod. Nulla.</h2>
            </a>
        </div>
        <div>
            <a href="http://localhost/csc450Capstone/CoursePage/CoursePage.php" class="fill-div">
                <img src="Images/courseImage1.jfif" alt="" />
                <h1>CSC 330 Language Design and Implementation</h1>
                <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor mattis mi ac porta. Ut
                    ullamcorper
                    risus augue, at condimentum risus ultrices rutrum. In ultrices eu est ut euismod. Nulla.</h2>
            </a>
        </div>
        <div>
            <a href="http://localhost/csc450Capstone/CoursePage/CoursePage.php" class="fill-div">
                <img src="Images/courseImage1.jfif" alt="" />
                <h1>CSC 422 Software Engineering</h1>
                <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor mattis mi ac porta. Ut
                    ullamcorper
                    risus augue, at condimentum risus ultrices rutrum. In ultrices eu est ut euismod. Nulla.</h2>
            </a>
        </div>
        <div>
            <a href="http://localhost/csc450Capstone/CoursePage/CoursePage.php" class="fill-div">
                <img src="Images/courseImage1.jfif" alt="" />
                <h1>CSC 420 Data Structures and Algorithms</h1>
                <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor mattis mi ac porta. Ut
                    ullamcorper
                    risus augue, at condimentum risus ultrices rutrum. In ultrices eu est ut euismod. Nulla.</h2>
            </a>
        </div>
        <div>
            <a href="http://localhost/csc450Capstone/CoursePage/CoursePage.php" class="fill-div">
                <img src="Images/courseImage1.jfif" alt="" />
                <h1>CSC 450 Computer Science Capstone</h1>
                <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor mattis mi ac porta. Ut
                    ullamcorper
                    risus augue, at condimentum risus ultrices rutrum. In ultrices eu est ut euismod. Nulla.</h2>
            </a>
        </div>
    </div> -->
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

    //If student clicks on <div id = 1>, send over course_code 1
    document.getElementById(1).onclick = function() {
                window.location.href = "http://localhost/csc450Capstone/CoursePage/CoursePage.php?id=" + 1;
    };

    //If student clicks on <div id = 2>, send over course_code 2
    document.getElementById(2).onclick = function() {
                window.location.href = "http://localhost/csc450Capstone/CoursePage/CoursePage.php?id=" + 2;
    };


    /*--------------------------------------------------------------------------
    Testing for auto creating onclick function using a loop on some sort. 
    let arrayLinks = [];
    let courseCode = 0;
    var j = 0;
    console.log("PHP num is: " + <?php echo $i ?>);

    while (courseCode < <?php echo $i ?>) { //Why the fuck does it not work, we created two functions
        courseCode++;
        console.log("Course Code is: " + courseCode);

        arrayLinks.push(document.getElementById(courseCode).onclick = function() {
                window.location.href = "http://localhost/csc450Capstone/CoursePage/CoursePage.php?id=" + courseCode;
        });
        
        j++;
        
    }

    //

    function goPage() {
        document.getElementById(courseCode).onclick = function() {
            window.location.href = "http://localhost/csc450Capstone/CoursePage/CoursePage.php?id=" + courseCode;
        };
        //window.location.href = "http://localhost/csc450Capstone/CoursePage/CoursePage.php?id=1";
    }

    console.log(courseCode);
    */

    </script>
</body>

</html>