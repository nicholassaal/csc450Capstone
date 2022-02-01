<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="LandingPage.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css'rel='stylesheet'>
    <title>Landing Page</title>
    <script
    src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
    crossorigin="anonymous"></script>
    <script>
    $(function() {
    $(".toggle").on("click", function() {
        if ($(".item").hasClass("active")) {
            $(".item").removeClass("active");
        } else {
            $(".item").addClass("active");
        }
    });
});
    </script>
</head>
<body>
<nav>
        <ul class="menu">



            
            <li class="logo"><a href="http://localhost/csc450Capstone/LandingPage/LandingPage.php">Home</a></li>
            <li class="item"><a href="http://localhost/csc450Capstone/LandingPage/LandingPage.php">Landing Page</a></li>
            <li class="item"><a href="http://localhost/csc450Capstone/profileView/profiles.php">Profile</a></li>
            <li class="item"><a href="http://localhost/csc450Capstone/MajorPage/CSCMajorPage.php">Majors</a></li>
       
           
            <li class="item">    
             <div>
      <button onclick="darkMode()">Darkmode</button>
            </div>
    <script>
      function darkMode() {
        var element = document.body;
        element.classList.toggle("dark-mode");
      }
    </script>
            </li>
          
            </li>
            <li class="item button"><a href="http://localhost/csc450Capstone/LoginPage/LoginPage.php">Log In</a></li>
            <li class="item button secondary"><a href="#">Sign Up</a></li>
            <li class="toggle"><span class="bars"></span></li>
        </ul>
    </nav>
  <div class="welcomeText">
   <h1 id="firstboxh">Welcome To The CSP Review</h1>
  <p id="firstboxp"> CSP Review is your one stop shop for the connections and Information guaranteed to put you ahead of those who have come before you  </p>
  </div>

  <div class="welcomeText2">
   <h1 id="box2h">What is CSP Review</h1>
  <p id="box2p">
  <ul>
          <li>This application allows students to review corses they have finish and actually see responces from fellow class mates</li></br>
          <li>The review tool allows you to have better knowlege on what you will learn in a corse along with allowing you to create connections and network with those who have taken the corse before you</li></br>
          <li></li></br>
      </ul>
  </p>
  </div>

  <div class="welcomeText">
   <h1 id="firstboxh">Who Can Review?</h1>
  <p id="firstboxp"> Anyone is allowed to view reviews, but only those who have completed a corse are allow to review </p>
  </div>

  <div class="welcomeText2">
   <h1 id="box2h">What Data Is Being Found</h1>
  <p id="box2p">
      <ul>
          <li>All sensitive data such as grades,GPA of each user will not be shown</li></br>
          <li>Data collected will include</li></br>
          <li>Final grade of completed corse</li></br>
          <li>Rating for professors</li></br>
          <li>Ratings for how prepared you felt going into the class</li></br>
          <li>Reviews on what you learned in the class</li></br>
          <li>What you could like to change in the corse</li></br>
          <li>Much more</li></br>
      </ul></p>
  </div>

  <div class="welcomeText">
   <h1 id="firstboxh">How it helps the University</h1>
  <p id="firstboxp"> 
       <ul>
          <li>Data help the university know whats working and what is not</li></br>
          <li>Information will help universitys adapt to the future</li></br>
          <li>Helps the university staff and students better connect with eachother</li></br>
      </ul></p>
  </div>

  <div class="welcomeText2">
   <h1 id="box2h">This Is The Future</h1>
  <p id="box2p">
      <ul>
          <li>Data can be collected from the users attending universitys all around the country </li></br>
          <li>That data can be used to provide whats great or outdated about a major at that university </li></br>
          <li>Industry leaders can give input on new corses that need to be implemented for the ever changing future</li></br>
          <li>This allows university students to be more prepared for there desided career after graduation</li></br>
      </ul>
  </p>
  </div>
  <div id= foot>
  <footer>
  <a href="">Contact</a></p>
</footer>
  </div>
   
</body>
</html>