<?php 
session_start();
require('connection.php');

$name = $_SESSION["name"];
$userID = $_SESSION["user_id"];

if(!$name){
    header('Location: http://www.om3.tech/login.php');
    exit;
}

if(isset($_POST['logout'])){
    session_destroy();
    header('Location: http://www.om3.tech/');
    exit;
}

$query = "SELECT * FROM users_stores WHERE user_id='".$userID."'";
$result = mysqli_query($conn, $query);
if($result){
$count  = mysqli_num_rows($result);
$stores = array();
if($count > 0){
while($row = mysqli_fetch_array($result)){
$stores[] = $row;
}//Row Fetch loop

}
}else{
echo 'Error '. mysqli_error($conn);
}

if(isset($_POST['submit'])){
$ID = $_POST['store_id'];
//Delete the store
$query = "DELETE FROM stores WHERE store_id='".$ID."'";
$result = mysqli_query($conn, $query);
if ($result === TRUE) {
    header('Location: http://www.om3.tech/dashboard.php');
} else {
    echo "Error deleting record: " . $conn->error;
}
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>OM3 Dashboard</title>
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
tr{
    height: 50px;
    line-height: 50px;
    padding-left: 10px;
    font-size: 20px;
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
  padding-top: 10%;
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
    margin: 30px;
    height: 50px;
}
#processProgress{
    display: none;
}
#process-table{
    display:none; 
}
#back{
  display:none;
}
#progressBar{
    width: 1%;
}
#processProgress a{
  text-decoration: none;
}
#delete_store{
    height: 28px;
    width: 28px;
    color: red;
    cursor: pointer;
}
#delete_submit{
    background: transparent;
    border: none;
}
#delete_submit:focus{
    background: transparent;
    border: none;
}
.delete-col{
    padding-left: 20px !important;
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
            <h1 class="h2">Dashboard</h1>
          </div>

          <h2>Stores</h2>
          <div class="table-responsive" id="store">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>Store Name</th>
                  <th>Store IP Address</th>
                  <th>Remove Store</th>
                </tr>
              </thead>
              <tbody>
                  
              <?php            
            foreach ($stores as $store){
             $query2 = "SELECT * FROM stores WHERE store_id='".$store["store_id"]."'";
             $result2 = mysqli_query($conn, $query2);
             if($result2){
                $count2  = mysqli_num_rows($result);
                 if($count2 > 0){
                    while($row2 = mysqli_fetch_array($result2)){
                  ?>        
                  
                <tr>
                  <td><a href="http://www.om3.tech/store.php?id=<?php echo $row2["store_id"];?>&name=<?php echo $row2["store_name"]; ?>&ip=<?php echo $row2["store_ip"]; ?>"><?php echo $row2["store_name"]; ?></a></td>
                  <td><?php echo $row2["store_ip"]; ?></td>
                  <td class="delete-col"><button type="button" id="delete_submit" data-toggle="modal" data-target="#deleteModal<?php echo $store["store_id"]; ?>">
                      <span data-feather="delete" id="delete_store"></span></button>
                      <!-- Modal -->
                        <div class="modal fade" id="deleteModal<?php echo $store["store_id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="#deleteModalLabel<?php echo $store["store_id"]; ?>" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel<?php echo $store["store_id"]; ?>">Delete Warning</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                    <h5>This will delete all the data related to (<?php echo $row2["store_name"]; ?>) from your account.</h5>
                                    <h6>Are you sure you want to complete?</h6>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No close</button>
                                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                                      <input type="hidden" name="store_id" value="<?php echo $store["store_id"]; ?>">
                                      <input type="submit" name="submit" class="btn btn-danger" value="Yes Delete">
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                </tr>
                
              <?php
                   
                    }
                       
                    }else{
                         echo 'Wrong store ID';
                    }
                    }else{
                     echo 'Error '. mysqli_error($conn);
                    }
                }//Stores into single store loop 
             
              ?>        
               
              </tbody>
            </table>
            <a href="http://www.om3.tech/new-store.php" class="btn btn-lg btn-outline-success" id="add">Add New Store</a>
          </div>
          
          
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
  
  // Send the instruction to start the robot movement 
   $("#1").click(function () {
       
    //   var i = $(this).attr('id'); // get id value (i.e. pin13, pin12, or pin11)
				// // send HTTP GET request to the IP address with the parameter "instruction" and value "i", then execute the function
				// $.get("http://192.168.4.1:80/", {
				//     instruction:p
				// }); // execute get request
       
        $('#dashboardContent').css("display", "none");
        $('#processProgress').css("display", "block");
        move();
        
    });
  
  // Send the instruction to stop the robot movement 
   $("#0").click(function () {
       
    //     var i = $(this).attr('id'); // get id value (i.e. pin13, pin12, or pin11)
				// // send HTTP GET request to the IP address with the parameter "instruction" and value "i", then execute the function
				// $.get("http://192.168.4.1:80/", {
				//     instruction:p
				// }); // execute get request
       
        $('#dashboardContent').css("display", "block");
        $('#processProgress').css("display", "none");
    });
    
  function move(){
  var elem = document.getElementById("progressBar");   
  var width = 1;
  var id = setInterval(frame, 100);
  function frame() {
    if (width >= 100) {
      $('#process-table').css("display", "block");
      $('#0').css("display", "none");
      $('#back').css("display", "block");
      clearInterval(id);
    } else {
      width++; 
      elem.style.width = width + '%'; 
    }
  }
}
    </script>
    
    <!-- ESP COMMUNICATION -->
    <script type="text/javascript">
		$(document).ready(function(){
		    
			$("#1").click(function(){
				var p = 1;
				// send HTTP GET request to the IP address with the parameter "pin" and value "p", then execute the function
				$.get("http://156.170.35.123:8080/", {pin:p}); // execute get request request
			});
			
			$("#0").click(function(){
				var p = 0;
				// send HTTP GET request to the IP address with the parameter "pin" and value "p", then execute the function
				$.get("http://197.52.151.129:8080/", {pin:p}); // execute get request request
			});
		});
	</script>
  </body>
</html>