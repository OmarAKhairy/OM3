<?php 
session_start();
require('connection.php');

$name = $_SESSION["name"];
$userID = $_SESSION["user_id"];

$storeID = $_GET["id"];
$storeName = $_GET["name"];
$storeIP = $_GET["ip"];

$_SESSION["store-name"] = $_GET["name"];
$_SESSION["store-id"] = $_GET["id"];
$_SESSION["store-ip"] = $_GET["ip"];



// if(!$name){
//     header('Location: http://www.om3.tech/login.php');
//     exit;
// }

if(isset($_POST['logout'])){
    session_destroy();
    header('Location: http://www.om3.tech/');
    exit;
}

                 
                 
if(isset($_POST['submit'])){
$ID = $_POST['product_id'];
//Delete the store
$query = "DELETE FROM products WHERE product_id='".$ID."'";
$result = mysqli_query($conn, $query);
if ($result === TRUE) {
    header('Location: http://www.om3.tech/store.php?id='.$storeID.'&name='.$storeName.'&ip='.$storeIP.'');
} else {
    echo "Error deleting record: " . $conn->error;
}
}

    
////////////////////////////////////////////////////////////////
            // Receieve the tags IDs from the RFID reader  
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['tags'])){
            $tags =  $_POST['tags'];
            $storeID = $_POST['id'];
            //$productCount = array();
            $tagsArray = str_split($tags, 12);
            
            $content = "Your tags is ".$tags."\n";
            $status = file_put_contents('test.txt', $content, FILE_APPEND);
            
            //Get the products of this store
            $query = "SELECT * FROM stores_products WHERE store_id='".$storeID."'";
            $result = mysqli_query($conn, $query);
                if($result){
                    $count  = mysqli_num_rows($result);
                    if($count > 0){
                    while($row = mysqli_fetch_array($result)){
                                    $query2 = "SELECT * FROM products_tags WHERE product_id='".$row["product_id"]."'";
                                    $result2 = mysqli_query($conn, $query2);
                                        if($result2){
                                        $count2  = mysqli_num_rows($result2);
                                        if($count2 > 0){
                                        while($row2 = mysqli_fetch_array($result2)){
                                                    $tagID = $row2["tag_id"];
                                                    //$content2 = "\n tagIDCount: ".count($tagID)." \n"; 
                                                    //$status = file_put_contents('content.txt', $content2, FILE_APPEND);
                                                    // for($i=0; $i<count($tagsArray); $i++){
                                                    //     for($k=0; $k<count($tagID); $k++){
                                                    //         if($tagsArray[$i] == $tagID[$k]){
                                                    //             $productCount[$row["product_id"]]++;
                                                    //         }
                                                    //     }
                                                    // }
                                                    for($i=0; $i<count($tagsArray); $i++){
                                                            if($tagsArray[$i] == $tagID){
                                                                $productCount[$row["product_id"]]++;
                                                        }
                                                    }

                                                }//Row Fetch loop
                                            }else{
                                                 echo "Can't access Tags IDs";
                                                 $content2 = "Can't access Tags IDs"; 
                                                 $status = file_put_contents('content.txt', $content2, FILE_APPEND);
                                            }
                                                        
                                            }else{
                                                 echo 'Error '. mysqli_error($conn);
                                                $content2 = 'Error '. mysqli_error($conn); 
                                                $status = file_put_contents('content.txt', $content2, FILE_APPEND);
                                            }
                    
                    }//Row Fetch loop
                    }
                                
                }else{
                    echo 'Error '. mysqli_error($conn);
                }
            
            
            $status = 1;
            $query4 = "INSERT INTO processes(process_date, state, store_id) VALUES(now(), '".$status."', '".$storeID."')";
            $result4 = mysqli_query($conn, $query4); 
            if($result4){
            //$processID = LAST_INSERT_ID();
            $processID = mysqli_insert_id($conn);
            $content2 = "\n Last Process ID: ".$processID."\n"; 
            $status = file_put_contents('content.txt', $content2, FILE_APPEND);
            }else{
                    echo 'Error '. mysqli_error($conn);
            }
            
            $query5 = "SELECT * FROM stores_products WHERE store_id='".$storeID."'";
            $result5 = mysqli_query($conn, $query5);
                if($result5){
                    $count5  = mysqli_num_rows($result5);
                    if($count5 > 0){
                    while($row5 = mysqli_fetch_array($result5)){
            if($productCount[$row5["product_id"]]){
                $productC = $productCount[$row5["product_id"]];    
            }else{
                $productC = 0;
            }            
            $query6 = "INSERT INTO processes_products(process_id, product_id, product_count) VALUES('".$processID."', '".$row5["product_id"]."', '".$productC."')";
            $result6 = mysqli_query($conn, $query6);
            }
            }else{
            echo "Error ". mysqli_error($conn);
            }
            }//Row Fetch loop
            header('Location: http://www.om3.tech/show-result.php?process='.$processID);
            }
            }
            
/////////////////////////////////////////////////////////

?>

<!doctype html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Store</title>
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

#processAck{
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
#dashboardContentAfter2{
    display:none;
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
        
        <!--=============================================================================================-->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4" id="processProgress">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Process In Progress</h1>
            <!--<div class="btn-toolbar mb-2 mb-md-0">-->
            <!--    <button class="btn btn-lg btn-outline-warning" id="0">Stop Process</button>-->
            <!--</div>-->
           </div>
            <div class="progress">
              <div class="loader"></div>
            </div>
            <h4 class="h4">The Robot Is performing the process</h4>
            <h5 class="h5">The results will be shown as soon as the process is completed</h5>
        </main>
        
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4" id="dashboardContentAfter">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h2>Process Details</h2>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="http://www.om3.tech/dashboard.php"><button class="btn btn-lg btn-outline-success" id="back">Back To Dashboard</button></a>
            </div>
            </div>
          <div id="process-table">
          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>Product Name</th>
                  <th>Available Stock</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Product 1</td>
                  <td>9</td>
                </tr>
                <tr>
                  <td>Product 2</td>
                  <td>6</td>
                </tr>
                <tr>
                  <td>Product 3</td>
                  <td>7</td>
                </tr>
              </tbody>
            </table>
          </div>
            </div>
        </main>
        <!--=========================================================================================-->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4" id="processAck">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Checking the Connection</h1>
            <!--<div class="btn-toolbar mb-2 mb-md-0">-->
            <!--    <button class="btn btn-lg btn-outline-warning" id="0">Stop Process</button>-->
            <!--</div>-->
           </div>
            <div class="progress">
              <div class="loader"></div>
            </div>
        </main>
        
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4" id="dashboardContentAfter2">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2" id="Ack">Connection Established</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button class="btn btn-lg btn-outline-danger" id="1">Start Process</button>
            </div>

            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="http://www.om3.tech/dashboard.php"><button class="btn btn-lg btn-outline-warning" id="back">Back To Dashboard</button></a>
            </div>
           </div>
        </main>
        <!--=========================================================================================-->

        
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4" id="dashboardContent">
            
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Store</h1>
          </div>
          
        <form style="margin-bottom: 50px;">
          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Store Name</label>
            <div class="col-sm-10">
              <input type="text" readonly class="form-control-plaintext" id="name" value="<?php echo $storeName; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label for="ip" class="col-sm-2 col-form-label">Store IP</label>
            <div class="col-sm-10">
              <input type="text" readonly class="form-control-plaintext" id="ip" value="<?php echo $storeIP; ?>">
            </div>
          </div>
          <a href="http://www.om3.tech/edit-store.php" class="btn btn-lg btn-outline-warning" id="edit_button">Edit Store</a>
        </form>

          <h2>Products</h2>
          <div class="table-responsive" id="store">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>Product Name</th>
                  <th>Tag ID</th>
                  <th>Available Stock</th>
                  <th>Remove Product</th>
                </tr>
              </thead>
              <tbody>
                  
              <?php
            $query = "SELECT * FROM stores_products WHERE store_id='".$storeID."'";
            $result = mysqli_query($conn, $query);
                if($result){
                    $count  = mysqli_num_rows($result);
                    if($count > 0){
                    while($row = mysqli_fetch_array($result)){
                     $products[] = $row;   
                    }
                    }
                }
              
            foreach ($products as $product){
             $query2 = "SELECT * FROM products WHERE product_id='".$product["product_id"]."'";
             $result2 = mysqli_query($conn, $query2);
             if($result2){
                $count2  = mysqli_num_rows($result);
                 if($count2 > 0){
                    while($row2 = mysqli_fetch_array($result2)){
                  ?>        
                  
                <tr>
                  <td><a href="http://www.om3.tech/product.php?id=<?php echo $row2["product_id"]; ?>&name=<?php echo $row2["product_name"]; ?>&count=<?php echo $row2["product_count"]; ?>&tag=<?php echo $row2["tag_id"]; ?>"><?php echo $row2["product_name"]; ?></a></td>
                  <td><?php echo $row2["tag_id"]; ?></td>
                  <td><?php echo $row2["product_count"]; ?></td>
                  <td class="delete-col"><button type="button" id="delete_submit" data-toggle="modal" data-target="#deleteModal<?php echo $row2["product_id"]; ?>">
                      <span data-feather="delete" id="delete_store"></span></button>
                      <!-- Modal -->
                        <div class="modal fade" id="deleteModal<?php echo $row2["product_id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="#deleteModalLabel<?php echo $row2["product_id"]; ?>" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel<?php echo $row2["product_id"]; ?>">Delete Warning</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                    <h5>This will delete all the data related to (<?php echo $row2["product_name"]; ?>) from your account.</h5>
                                    <h6>Are you sure you want to complete?</h6>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No close</button>
                                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                                      <input type="hidden" name="product_id" value="<?php echo $row2["product_id"]; ?>">
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
                         echo 'Wrong Product ID';
                    }
                    }else{
                     echo 'Error '. mysqli_error($conn);
                    }
                }//Stores into single store loop 
             
              ?>        
               
              </tbody>
            </table>
            <a href="http://www.om3.tech/new-product.php" class="btn btn-lg btn-outline-success" id="add">Add New Product</a>
          </div>
          
          <h2 style="margin-top: 30px;">Processes</h2>
          <div class="table-responsive" id="process" style="margin-bottom: 50px;">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>Process Date</th>
                  <th>Process Datails</th>
                  <th>Process State</th>
                </tr>
              </thead>
              <tbody>
            <?php            
             $query = "SELECT * FROM processes WHERE store_id='".$storeID."'";
             $result = mysqli_query($conn, $query);
             if($result){
                $count  = mysqli_num_rows($result);
                $stores = array();
                 if($count > 0){
                    while($row = mysqli_fetch_array($result)){
                  ?>        
                <tr>
                  <td><?php echo $row["process_date"]; ?></td>
                  <td><a href="http://www.om3.tech/process.php?id=<?php echo $row["process_id"]; ?>&date=<?php echo $row["process_date"]; ?>">View</a></td>
                  <td><?php if($row["state"] == 1){echo "Success";} else{echo "Fail";} ?></td>
                </tr>
            <?php
                    }
                       
                    }else{
                         echo 'No Processes for the store';
                    }
                    }else{
                     echo 'Error '. mysqli_error($conn);
                    }

              ?>       
              </tbody>
            </table>
            <button  id="2" class="btn btn-lg btn-outline-danger">Start New Process</button>
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
  

// Send the instruction to start the robot connection   
  $("#2").click(function(){
        var p = 2;
        $('#dashboardContent').css("display", "none");
        $('#processAck').css("display", "block");        

        setTimeout(function(){ 
        $('#dashboardContentAfter2').css("display", "block");
        $('#processAck').css("display", "none");   
          },5000);
    });
  
// Send the instruction to start the robot movement 
   $("#1").click(function () {
        var p = 1;
		// send HTTP GET request to the IP address with the parameter "pin" and value "p", then execute the function

        $('#processProgress').css("display", "block");
        $('#dashboardContentAfter2').css("display", "none");
        $.get("http://<?php echo $storeIP; ?>:8080/", {pin:p, id:"<?php echo $storeID; ?>"});
        
        setTimeout(function(){ 
        //location.reload();
        window.location.replace("http://www.om3.tech/show-result.php?process=64");
          },25000);
        
});
  
    
    </script>

	
  </body>
</html>