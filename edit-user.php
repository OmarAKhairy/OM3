<?php 
session_start();
require('connection.php');

$name = $_SESSION["name"];
$userID = $_SESSION["user_id"];
$userEmail = $_SESSION["user_email"];
$userPassword = $_SESSION["user_password"];


//If Subitted
if(isset($_POST['submit'])){
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
   
    $query = "UPDATE users SET user_name= '".$username."', user_email='".$email."', password='".$password."' WHERE user_id = ".$userID."";

    if(mysqli_query($conn, $query)){
        session_destroy();
        header('Location: http://www.om3.tech/login.php');
        exit;
    }else{
        echo "Error ". mysqli_error($conn);
    }
}


?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>OM3</title>
<link rel="icon" href="https://i.imgur.com/YZi4LRE.png">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/main.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  @media screen and (max-width: 950px){
   .video-container .poster img {
    display: none;
}
.video-container .filter {
    display: none;
}
.video-container video {
    display: none;
}
    .social-icons i{
    font-size: 25px;
    color: #66808d;
    position: relative;
    top:6px;
}
#login form{
    width: 90%;
    margin-top: 50px;
}
}
</style>
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
   $( document ).ready(function() {

     scaleVideoContainer();

     initBannerVideoSize('.video-container .poster img');
     initBannerVideoSize('.video-container .filter');
     initBannerVideoSize('.video-container video');

    $(window).on('resize', function() {
         scaleVideoContainer();
         scaleBannerVideoSize('.video-container .poster img');
         scaleBannerVideoSize('.video-container .filter');
         scaleBannerVideoSize('.video-container video');
     });

});

 function scaleVideoContainer() {

     var height = $(window).height() + 5;
     var unitHeight = parseInt(height) + 'px';
     $('.homepage-hero-module').css('height',unitHeight);

}

 function initBannerVideoSize(element){

     $(element).each(function(){
         $(this).data('height', $(this).height());
         $(this).data('width', $(this).width());
     });

     scaleBannerVideoSize(element);

 }

 function scaleBannerVideoSize(element){

     var windowWidth = $(window).width(),
     windowHeight = $(window).height() + 5,
     videoWidth,
     videoHeight;

      console.log(windowHeight);

     $(element).each(function(){
         var videoAspectRatio = $(this).data('height')/$(this).data('width');

         $(this).width(windowWidth);

         if(windowWidth < 1000){
             videoHeight = windowHeight;
             videoWidth = videoHeight / videoAspectRatio;
             $(this).css({'margin-top' : 0, 'margin-left' : -(videoWidth - windowWidth) / 2 + 'px'});

             $(this).width(videoWidth).height(videoHeight);
         }

         $('.homepage-hero-module .video-container video').addClass('fadeIn animated');

    });
}
</script>
</head>
<body>
  
  
<div class="homepage-hero-module">
    <div class="video-container">

      
<!-- Login Section -->
<div id="login">
    <div class="row no-gutters">
      <div class="col-md-6 offset-md-3 col-sm-8 offset-small-2">
        <div class="container">
          <div class="jumbotron">
            <a href="/"><img src="https://i.imgur.com/riVVLjS.png" class="img-responsive mx-auto d-block" alt="OM3"></a>
            <form class="mx-auto" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <h1>Edit User <?php echo $name; ?></h1>
              <div class="form-group">
                <input type="text" class="form-control" id="name" name="username" placeholder="Your Username" value="<?php echo $name; ?>">
              </div>
              <div class="form-group">
               
                <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" value="<?php echo $userEmail; ?>">
              </div>
              <div class="form-group">
    
                <input type="password" class="form-control" id="password" name="password" placeholder="Your Password" value="<?php echo $userPassword; ?>">
              </div>
              <input type="submit" name="submit" class="btn btn-outline-primary btn-block" value="Edit User">
            </form>
            </div>
          </div>
      </div>
    </div>
</div>
<!-- End Of Login Section -->

 <div class="filter"></div>
        <video autoplay loop class="fillWidth">
            <source src="media/Love-Coding.mp4" type="video/mp4" />Your browser does not support the video tag. I suggest you upgrade your browser.
            <source src="media/Love-Coding.webm" type="video/webm" />Your browser does not support the video tag. I suggest you upgrade your browser.
        </video>
        <div class="poster hidden">
            <img src="" alt="">
        </div>
    </div>
</div>
<!-- End of new login Section -->  
  
  


<footer class="footer">
      <div class="container">
        <span>All Rights Reserved to <strong>OM3</strong></span>
      </div>
</footer>

        
  </body>
</html>