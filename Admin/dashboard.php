<?php
session_start();

include('inti.php');
if(isset($_SESSION['mans'])){

$sq1=$connect->prepare("SELECT * FROM users");
$sq1->execute();
$usercount= $sq1->rowCount();

$sq2=$connect->prepare("SELECT * FROM orders");
$sq2->execute();
$ordcount= $sq2->rowCount();

$sq3=$connect->prepare("SELECT * FROM shippers");
$sq3->execute();
$shippcount= $sq3->rowCount();

$sq4=$connect->prepare("SELECT * FROM sections");
$sq4->execute();
$seccount= $sq4->rowCount();

?>









<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row mb-4" >
        <div class="col-lg-8 col-md-10 mb-md-0 mb-4" style="width: 95%;">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7 pb-6 ">
                  <h6  style="font-size: 30px;">Dashboard</h6>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-10">
            <div class="container">
    <div class="row" >
        <div class="col-md-3 text-center">
            <div class="box">
           
            <i class="fa-solid fa-users fa-xl "></i>
            <a style="color: #053c5a; text-decoration: none;" href="users.php"> <h2 class="my-2" >Users</h2> </a>
            <span><?php echo $usercount ;?></span>
        </div>
        </div>

        <div class="col-md-3 text-center">
        <div class="box" >
        <i class="fa-solid fa-cart-shopping fa-xl "></i>
        <a style="color: #053c5a; text-decoration: none;"  href="orders.php"> <h2 class="my-2" >Orders</h2> </a>
            <span><?php echo $ordcount ;?></span>
        </div>
        </div>


        <div class="col-md-3 text-center">
        <div class="box">
        <i class="fa-solid fa-truck-fast fa-xl "></i>
        <a style="color: #053c5a; text-decoration: none;" href="shippers.php"> <h2 class="my-2" >Shippers</h2> </a>
            <span><?php echo $shippcount ;?></span>
        </div>
        </div>


        <div class="col-md-3 text-center">
        <div class="box" >
        <i class="fa-solid fa-folder-tree fa-xl "></i>
        <a style="color: #053c5a; text-decoration: none;" href="sections.php"> <h2 class="my-2" >Sections</h2> </a>
            <span><?php echo $seccount ;?></span>
        </div>
        </div>
    </div>
</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="material-icons py-2">settings</i>
    </a>
  </div>





<?php

include('includes/temp/footer.php');
}else{
    
   header("Location:login.php");
}

?>


