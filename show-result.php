<?php
session_start();
require('connection.php');

$name = $_SESSION["name"];
$userID = $_SESSION["user_id"];

$storeID = $_SESSION["store-id"];
$storeName = $_SESSION["store-name"];
$storeIP = $_SESSION["store-ip"];

$processID = $_GET["process"];
$processState = "success";

//Get the products of this store
$query = "SELECT * FROM processes WHERE process_id='".$processID."'";
$result = mysqli_query($conn, $query);
    if($result){
        $count  = mysqli_num_rows($result);
        if($count > 0){
        while($row = mysqli_fetch_array($result)){
            $processDate = $row["process_date"];
        }//Row Fetch loop
    }            
    }else{
        echo 'Error '. mysqli_error($conn);
}

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
    text-align: center;
    margin: 50px auto;
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
      
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4" id="dashboardContentAfter">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h2>Process Details</h2>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="http://www.om3.tech/dashboard.php"><button class="btn btn-lg btn-outline-success" id="back">Back To Dashboard</button></a>
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
</body>
</html>