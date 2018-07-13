<?php 
session_start();
require('connection.php');

$name = $_SESSION["name"];
$userID = $_SESSION["user_id"];

$processID = $_GET["id"];
$processDate = $_GET["date"];


$storeName = $_SESSION["store-name"];
$storeID = $_SESSION["store-id"];
$storeIP = $_SESSION["store-ip"];

if(!$name){
    header('Location: http://www.om3.tech/login.php');
    exit;
}

if(isset($_POST['logout'])){
    session_destroy();
    header('Location: http://www.om3.tech/');
    exit;
}


?>

<!doctype html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Process</title>
<link rel="icon" href="https://i.imgur.com/YZi4LRE.png">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/stylesheets/wickedcss.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=PT+Serif|Playfair+Display" rel="stylesheet">
<style>
body {
  font-size: .875rem;
}
h1{
 color: #a68250 !important;   
}
h2{
 color: #1f4164;
}
a:hover{
    text-decoration: none;
}
.feather {
  width: 16px;
  height: 16px;
  vertical-align: text-bottom;
}
#logout{
    background: none;
    border: none;
    color: #fff;
    font-size: 16px;
}
#logout:hover{
    color: red;
    cursor: pointer;
}
/*
 * Sidebar
 */

.sidebar {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  z-index: 100; /* Behind the navbar */
  padding: 0;
  box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
}

.sidebar-sticky {
  position: -webkit-sticky;
  position: sticky;
  top: 48px; /* Height of navbar */
  height: calc(100vh - 48px);
  padding-top: .5rem;
  overflow-x: hidden;
  overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
  background-color: #f8f5f0;
}

.sidebar .nav-link {
  font-weight: 500;
  color: #66808d;
}

.sidebar .nav-link .feather {
  margin-right: 4px;
  color: #999;
}

.sidebar .nav-link.active {
  color: #1f4164;
}

.sidebar .nav-link:hover .feather,
.sidebar .nav-link.active .feather {
  color: inherit;
}

.sidebar-heading {
  font-size: .75rem;
  text-transform: uppercase;
}
.username{
    text-transform: capitalize;
    font-weight: bold;
}
/*
 * Navbar
 */
.bg-dark {
    background-color: #1f4164!important;
}
.navbar-brand {
  padding-top: .75rem;
  padding-bottom: .75rem;
  font-size: 1rem;
  background-color: rgba(0, 0, 0, .25);
  box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
}
.navbar-dark .navbar-nav .nav-link {
    color: #fff;
}
.navbar-dark .navbar-nav .nav-link:hover{
    color: red;
}

.progress{
    background-color: #fff;
    margin: 20px;
    height: 70%;
    text-align: center;
}

.loader {
  display: block;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #1f4164;
  border-right: 16px solid #f8f5f0;
  border-bottom: 16px solid #a68250;
  border-left: 16px solid #007bff;
  width: 150px;
  height: 150px;
  margin: 5px auto;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

#processProgress{
    display: none;
    text-align: center;
}


#dashboardContentAfter{
    display:none;
}
#progressBar{
    width: 1%;
}
#processProgress a{
  text-decoration: none;
}
.form-group{
    font-size: 18px;
}

/*
 * Utilities
 */
 .sold{ text-decoration: line-through; }
.border-top { border-top: 1px solid #e5e5e5; }
.border-bottom { border-bottom: 1px solid #e5e5e5; }
</style>
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </head>

  <body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Welcome <span class="username"><?php echo $name; ?></span></a>
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
          <input type="submit" value="Logout" name="logout" id="logout"> 
        </form>  
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="http://www.om3.tech/dashboard.php">
                  <span data-feather="home"></span>
                  Dashboard <span class="sr-only">(current)</span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="http://www.om3.tech/edit-user.php">
                  <span data-feather="user"></span>
                  Edit User Information
                </a>
              </li>
              
             <li class="nav-item">
                <a class="nav-link" href="http://www.om3.tech/new-store.php">
                  <span data-feather="shopping-cart"></span>
                  Add New Store
                </a>
              </li>
            </ul>

          </div>
        </nav>
        
 
        
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4" id="dashboardContent">
            
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Process <?php echo $processDate; ?></h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="http://www.om3.tech/store.php?id=<?php echo $storeID; ?>&name=<?php echo $storeName; ?>&ip=<?php echo $storeIP; ?>"><button class="btn btn-lg btn-outline-success" id="back">Back To Store</button></a>
            </div>
          </div>
          
          
                <div class="table-responsive" id="process" style="margin-bottom: 50px;">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Available Stock</th>
                </tr>
              </thead>
              <tbody>    
            
            <?php         
            $query2 = "SELECT * FROM processes_products WHERE process_id='".$processID."'";
            $result2 = mysqli_query($conn, $query2);
            if($result2){
                $count2  = mysqli_num_rows($result2);
                if($count2 > 0){
                while($row2 = mysqli_fetch_array($result2)){
                    
            $query3 = "SELECT * FROM products WHERE product_id='".$row2["product_id"]."'";
            $result3 = mysqli_query($conn, $query3);
            if($result3){
                $count3  = mysqli_num_rows($result3);
                if($count3 > 0){
                while($row3 = mysqli_fetch_array($result3)){
                ?>
                         <tr>
                          <td><?php echo $row3["product_name"]; ?></td>
                          <td><?php echo $row2["product_count"]; ?></td>
                        </tr>    
                <?php 
                    
            }//Row Fetch loop
                
            }}else{
                echo 'Error '. mysqli_error($conn);
            }
            
            }
                            
            }}else{
                echo 'Error '. mysqli_error($conn);
            }
            ?>

          
        </main>
      </div>
    </div>
    
    
    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>

    
    <script>
      // Select all links with hashes
   $('a[href*="#"]')
  // Remove links that don't actually link to anything
  .not('[href="#"]')
  .not('[href="#0"]')
  .click(function(event) {
    // On-page links
    if (
      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
      && 
      location.hostname == this.hostname
    ) {
      // Figure out element to scroll to
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      // Does a scroll target exist?
      if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000, function() {
          // Callback after animation
          // Must change focus!
          var $target = $(target);
          $target.focus();
          if ($target.is(":focus")) { // Checking if the target was focused
            return false;
          } else {
            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
            $target.focus(); // Set focus again
          };
        });
      }
    }
  });
  

    </script>
    
	
  </body>
</html>