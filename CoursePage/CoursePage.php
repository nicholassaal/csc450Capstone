<!DOCTYPE html>
<html>

<head>
    <title>CourseNameHere</title>
    <link rel="stylesheet" type="text/css" href="CoursePage.css">
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

    <div class="upper-flex-container">
        <h1>Course Name</h1>
        <h2>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Iure facere ea eaque, vel odit minus id,
            perferendis eos tenetur earum est doloremque possimus dignissimos nam at voluptatibus optio unde esse. Lorem
            ipsum dolor sit amet consectetur adipisicing elit. Harum, ea ad vitae accusamus aliquid minus perferendis,
            provident dolore explicabo quod nemo eos! Totam ducimus quasi enim repellat, harum libero debitis!</h2>
        <form action="#" class="review-area">
            <div class="message-area">
                <label for="msg">Leave a review</label>
                <textarea id="msg"></textarea>
                <button>Submit</button>
            </div>
        </form>
    </div>
    <h3>Featured Reviews</h3>
    <div class="lower-flex-container">

        <div>
            <h2>Username</h2>
            <h2>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Natus sapiente obcaecati repudiandae rem
                omnis, optio, a architecto, debitis saepe magni voluptate esse. Voluptas perferendis id voluptatibus aut
                reprehenderit dicta eaque.</h2>
        </div>
        <div>
            <h2>Username</h2>
            <h2>Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore aut minima tenetur totam libero, dolor
                laudantium esse quae at, explicabo corporis magni dicta suscipit blanditiis laborum doloremque tempora
                aliquid facilis!</h2>
        </div>
        <div>
            <h2>Username</h2>
            <h2>Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident unde alias cumque aliquam, suscipit,
                molestias quidem ullam omnis officia dolor esse impedit inventore, aut numquam excepturi assumenda
                tempore. Sapiente, repudiandae!</h2>
        </div>
    </div>
    <h3>All Reviews</h3>
    <div class="review-flex-container">
        <div>
            <h2>Username</h2>
            <h2>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae a, impedit dicta suscipit
                excepturi, neque culpa ducimus porro nostrum laboriosam doloribus debitis libero molestiae enim, tenetur
                laudantium incidunt. Laborum, ipsum.</h2>
        </div>
        <div>
            <h2>Username</h2>
            <h2>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum optio consequatur ipsa nam quibusdam
                dolorem enim illo facilis, iure perspiciatis magnam dolores nisi rerum soluta laborum, amet earum, quo
                corporis?</h2>
        </div>
        <div>
            <h2>Username</h2>
            <h2>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quae maxime molestiae nam mollitia voluptatem?
                Quo, corporis. Perferendis nam, odit cum vero quisquam neque rem sit modi fugit, mollitia consectetur!
                Aspernatur.</h2>
        </div>
        <div>
            <h2>Username</h2>
            <h2>Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat veritatis ullam atque, sunt rem eum,
                quasi nulla recusandae nam distinctio vitae doloribus nostrum ut debitis, adipisci aperiam
                exercitationem. Voluptates, sed.</h2>
        </div>
        <div>
            <h2>Username</h2>
            <h2>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam fuga dicta eos assumenda veniam id
                deserunt odit nemo voluptate, aliquid quaerat sunt. Illum omnis fugiat excepturi pariatur nobis
                similique facere!</h2>
        </div>
        <div>
            <h2>Username</h2>
            <h2>Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita rerum quibusdam ab ullam similique
                aspernatur? Suscipit tempora dolores explicabo vel, ratione corrupti obcaecati quidem doloremque,
                laudantium ipsum velit quisquam reiciendis?</h2>
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