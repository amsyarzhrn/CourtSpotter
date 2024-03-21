<?php
// Include the database connection
require_once "dbconnect.php";
// Start the session
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Map</title>
    
    <link rel="icon" type="image/png" href="favicon.png">

    <style>
         /*----------------Start NAV Section CSS----------------------*/

    *{
    margin:0;
    padding:0;
    font-family: 'Poppins', sans-serif;
    }

    .sub-header{
        height: 110px;
        width: 100%;
        background-color:steelblue ;
        image-resolution: from-image;
        background-position:center;
        background-size: cover;
        position: relative;
    }
    nav{
        display: flex;
        padding: 2% 3% 3% 3%;
        justify-content: space-between;
        align-items: center;
    }
    nav img{
        width: 130px;
        margin-top: -20px;
    }

    nav img:hover {
    width: 140px; /* Increase width on hover */
    }


    .nav-links{
        padding-top: 2px;
        flex:1;
        text-align: right;
    }
    .nav-links ul li{
        list-style: none;
        display: inline-block;
        padding: 8px 20px;
        position:relative;
    }
    .nav-links ul li a {
    color: white;
    text-decoration: none;
    font-size: 16px;
    font-family: lato;
    transition: font-size 0.3s; /* Add transition for smooth effect */
    }

    .nav-links ul li.active a {
    color: black;
    font-weight: bold;
    font-size: 18px; /* Maintain the same font size as hover state */
}

    .nav-links ul li:hover a {
    color: black;
    font-weight: bold;
    font-size: 18px; /* Increase font size on hover */
    }
    .nav-links ul li:hover::after{
        width: 100%;    
    }

    


/*----------------End NAV Section CSS----------------------*/

        /* Main styles */
        main {
            width: 70%; /* Adjust the width as needed */
            margin: auto;
            background-color: steelblue;
            font-size: 17px;
            margin-top: 20px; /* Add margin to push it below the nav */
            text-align: center; /* Center the content */
        }



/*        ///////////////////////////////////////////////////////////////////////////*/
        /* Slideshow styles */
        .slideshow-container {
            position: relative;
            width: 100%;
            height: 80%;
            overflow: hidden; /* Hide overflow */
        }

        .court-slide {
            display: none; /* Hide all slides by default */
        }

        .court-slide img {
            width: auto;
            height: auto;
        }

        .text {
            color: darkred;
            font-size: 24px;
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%); /* Center horizontally */
            z-index: 1;
        }

        /* Navigation button styles */
        .prev, .next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 2;
            cursor: pointer;
            padding: 16px;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 20px;
            transition: background-color 0.3s;
        }

        .prev:hover, .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        .prev {
            left: 10px;
        }

        .next {
            right: 10px;
        }

        body {
    background-image: url('bodywallpaper.png'); /* Set the background image */
    background-size: cover; /* Cover the entire background */
    background-position: center; /* Center the background image */
    background-repeat: no-repeat; /* Do not repeat the background image */
}


</style>
        </head>



        <body>
            <!-- Webpage header HTML -->
            <section class="sub-header">

        <nav>

            <a href="home.php"><img src="CSLogoNoBackground.png" height="100" width="280" ></a>
            <div class="nav-links" id="navLinks">
                <ul>
                    <li><a href="home.php"><span class="material-symbols-outlined">
                    home
                    </span> Home</a></li>
                    <li><a href="bookcourt.php"><span class="material-symbols-outlined">
                    edit_calendar
                    </span> Book Court</a></li>
                    <li class="active"><a href="map.php"><span class="material-symbols-outlined">
                    space_dashboard
                    </span> Map</a></li>
                    <li><a href="about.php"><span class="material-symbols-outlined">
                    help
                    </span> About</a></li>
                    <li><a href="profile.php">
                    <span class="material-symbols-outlined">
                    manage_accounts
                    </span> Profile</a></li>
                    <li><a href="logout.php"><span class="material-symbols-outlined">
                    logout
                    </span> Logout</a></li>
                </ul>
 <!-- Display logged in username -->
        <?php
       // Check if the session variable is set
        if(isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            echo "<span style='font-size: 11px;font-weight: bold;'>Logged in as: $username";// Display a welcome message with the username
        } else {
            // If the session variable is not set, the user is not logged in
            // Redirect the user to the login page or display an error message
            header("Location: login.php"); // Redirect to the login page
            exit(); // Stop further execution of the script
        }
        ?>
            </div>
        </nav>
       
    </section>
<!-- End webpage header html-->

    <main>
    <h1>Map</h1><br>
    <p style="font-weight: bold;">Select a court to view:</p><br>

    <!-- Slideshow container -->
    <div class="slideshow-container">
        <!-- Full Complex Layout -->
        <div class="court-slide fade">
            <img src="WholeComplexLayout.png" alt="Full Complex Layout">
            <div class="text">Full Complex Layout</div>
        </div>

        <!-- Badminton Layout -->
        <div class="court-slide fade">
            <img src="BadmintonLayout.png" alt="Badminton Layout">
            <div class="text">Badminton Layout</div>
        </div>

        <!-- Futsal Layout -->
        <div class="court-slide fade">
            <img src="FutsalLayout.png" alt="Futsal Layout">
            <div class="text">Futsal Layout</div>
        </div>

        <!-- Navigation buttons -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>
</main>

<script>
    var slideIndex = 1;
    showSlides(slideIndex);

    // Next/previous controls
    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("court-slide");
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slides[slideIndex-1].style.display = "block";
    }
</script>
</body>
</html>
