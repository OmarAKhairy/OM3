<?php 
session_start();
require('connection.php');

$name = $_SESSION["name"];
$userID = $_SESSION["user_id"];

$storeName = $_SESSION["store-name"];
$storeID = $_SESSION["store-id"];
$storeIP = $_SESSION["store-ip"];

$productID = $_GET["id"];
$tagID = $_GET["tag"];
$productName = $_GET["name"];
$productCount = $_GET["count"];



if(!$name){
    header('Location: http://www.om3.tech/login.php');
}

//If Subitted
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $ID = $_POST['id'];
    $count = $_POST['count'];
   
    $query = "UPDATE products SET product_name= '".$name."', product_count='".$count."', tag_id='".$ID."' WHERE product_id = ".$productID."";

    if(mysqli_query($conn, $query)){
        header("Location: http://www.om3.tech/store.php?id=".$storeID."&name=".$storeName."&ip=".$storeIP."");
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

</head>
<body>
  
  
<div class="homepage-hero-module">
    <div class="container">

      
<!-- Login Section -->
<div id="login">
    <div class="row no-gutters">
      <div class="col-md-6 offset-md-3 col-sm-8 offset-small-2">
        <div class="container">
          <div class="jumbotron">
            <a href="/"><img src="https://i.imgur.com/riVVLjS.png" class="img-responsive mx-auto d-block" alt="OM3"></a>
            <form class="mx-auto" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <h1>Edit Product</h1>
              <div class="form-group">
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter the product name" value="<?php echo $productName; ?>">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" id="id" name="id" placeholder="Enter the product tag ID" value="<?php echo $tagID; ?>">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" id="count" name="count" placeholder="Enter the available stock" value="<?php echo $productCount; ?>">
              </div>
              <input type="submit" name="submit" class="btn btn-outline-primary btn-block" value="Edit">
            </form>
            </div>
          </div>
      </div>
    </div>
</div>
<!-- End Of Login Section -->
</div>
</div>
<!-- End of new login Section -->  
  
  


<footer class="footer">
      <div class="container">
        <a style="float: right; color: grey;" href="http://www.om3.tech/new-id.php?id=<?php echo $productID; ?>&name=<?php echo $productName; ?>">Add ID</a>
        <span>All Rights Reserved to <strong>OM3</strong></span>
      </div>
</footer>

        
  </body>
</html>