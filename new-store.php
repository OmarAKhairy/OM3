<?php 
session_start();
require('connection.php');

$name = $_SESSION["name"];
$userID = $_SESSION["user_id"];

if(!$name){
    header('Location: http://www.om3.tech/dashboard.php');
}

//If Subitted
if(isset($_POST['submit'])){
   $name = $_POST['name'];
   $IP = $_POST['ip'];
   
    $query = "INSERT INTO stores(store_name, store_ip) VALUES('$name', '$IP')";
    
    if(mysqli_query($conn, $query)){
        
        $query2 = "SELECT * FROM stores WHERE store_name='".$name."'";
             $result = mysqli_query($conn, $query2);
             if($result){
                $count  = mysqli_num_rows($result);
                 if($count > 0){
                    while($row = mysqli_fetch_array($result)){
                        $storeID = $row["store_id"];
                       }//Row Fetch loop
                    }else{
                         echo 'Wrong User ID';
                    }
                    
                 }else{
                      echo 'Error '. mysqli_error($conn);
                 }
    
        $query3 = "INSERT INTO users_stores(user_id, store_id) VALUES('$userID', '$storeID')";
        if(mysqli_query($conn, $query3)){
        header('Location: http://www.om3.tech/dashboard.php');
        }else{
        echo "Error ". mysqli_error($conn);
        }
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
            <h1>New Store</h1>
              <div class="form-group">
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter the store name">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" id="ip" name="ip" placeholder="Enter the store IP address">
              </div>
              <p>( Enter (111.111.111.111) in the IP Address field if you still don't know your IP Address )</p>
              <input type="submit" name="submit" class="btn btn-outline-primary btn-block" value="Add">
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
        <span>All Rights Reserved to <strong>OM3</strong></span>
      </div>
</footer>

        
  </body>
</html>