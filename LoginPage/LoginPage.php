<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href ="LogInPage.css"> <!--linking the CSS-->
    <title>Form</title>
</head>

    <body>
        <div class="rectangle"></div> <!--Creating a rectangle for the header-->
        <header>
            <h1>CSP Student Review Login Page</h1> <!--Nav Bar, used an Unorder lists-->
            <nav>
                <ul class="navigation">
                    <li><a href=" ">Login Page</a></li><!--List items-->
                    <li><a href=" ">Landing Page</a></li>
                    <li><a href=" ">Profile Page</a></li>
                    <li><a href=" ">Page Per Major</a></li>
                </ul>
            </nav>
        </header>

        <div class="loginContainer"> <!--Image and Login info-->
            <img src="image/CSPpicture.JPG" height="100%" width="60%" alt="Picture of CSP">

            <section id = "userInformation"> <!--Container for login user informatoin -->
                <h1 id="loginHeader">Login</h1>
                <lable for ="email">Email</lable> <!-- Creating a lable for input type of "text" then giving a name and
                                                             id to match the lable name-->
                <input type="text" name="email" id = "email">

                <lable for ="password">Password</lable> <!-- password input type and changed name and id to password-->
                <input type="password" name="password" id = "password">
                
                <!--Two buttons-->
                <button type = "button">Login</button>
                <button type = "button">Sign Up</button>

            </section>
        </div>

        
        <footer>
            <p>Capstone Project Group 1 - CSP major/program course review web application. Login Page</p>
        </footer>
    </body>
</html>