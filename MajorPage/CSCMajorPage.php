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
    <div class="flex-container">
        <div>
            <img src="Images/courseImage1.jfif" alt="" />
            <h1>Course Name</h1>
            <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor mattis mi ac porta. Ut ullamcorper
                risus augue, at condimentum risus ultrices rutrum. In ultrices eu est ut euismod. Nulla.</h2>
        </div>
        <div>
            <img src="Images/courseImage2.jfif" alt="waaaaaaa" />
            <h1>Course Name 2</h1>
            <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam feugiat bibendum mauris. Duis in commodo
                risus. Nullam lacinia nibh at finibus venenatis. Vivamus luctus vel enim et faucibus. Morbi malesuada.
            </h2>
        </div>
        <div>
            <img src="Images/courseImage3.jfif" alt="" />
            <h1>Course Name 3</h1>
            <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam pharetra ligula viverra nisi
                condimentum posuere. In quis turpis eu nisl pretium egestas. Integer laoreet ipsum et dolor venenatis
                facilisis. Phasellus.</h2>
        </div>
        <div>
            <img src="Images/courseImage4.jfif" alt="" />
            <h1>Course Name 4</h1>
            <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer sit amet commodo ligula. Fusce
                consectetur lacus at nisi volutpat molestie. Proin in pretium neque. Mauris fringilla nec odio at
                molestie.</h2>
        </div>
        <div>
            <img src="Images/courseImage5.jfif" alt="" />
            <h1>Course Name 5</h1>
            <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pellentesque eu sapien vel sollicitudin.
                Suspendisse ac scelerisque erat. Fusce sed blandit diam. Integer nec ornare lorem. Sed at mattis lectus.
            </h2>
        </div>
        <div>
            <img src="Images/courseImage6.jfif" alt="" />
            <h1>Course Name 6</h1>
            <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque mollis et erat a feugiat.
                Curabitur sit amet sapien a sem elementum hendrerit quis id ante. Aenean tristique condimentum massa,
                ac.</h2>
        </div>
        <div>
            <img src="Images/courseImage7.jfif" alt="" />
            <h1>Course Name 7</h1>
            <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget enim ut dolor malesuada condimentum ac
                sed mi. Maecenas ornare diam sed magna accumsan volutpat. Nunc placerat dolor consectetur justo.</h2>
        </div>
        <div>
            <img src="Images/courseImage8.jfif" alt="" />
            <h1>Course Name 8</h1>
            <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ut leo at est aliquam lacinia nec id
                justo. Mauris nec est tincidunt odio efficitur tempus venenatis eleifend tellus. Donec bibendum.</h2>
        </div>
    </div>
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