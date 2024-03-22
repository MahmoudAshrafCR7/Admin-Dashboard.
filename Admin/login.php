<?php
session_start();

if(isset($_SESSION['mans'])){
    header("Location:dashboard.php");
}

    include('includes/db/db.php');
    include('includes/temp/header.php');
    


if($_SERVER['REQUEST_METHOD']=="POST"){
    if(isset($_POST['submit-login'])){

        $email = $_POST['email'];
        $password = $_POST['pass'];
        $hashpassword = sha1($password);
        $statment= $connect->prepare("SELECT * FROM users where email=? and `password`=? limit 1");
        $statment->execute(array($email,$hashpassword));
        $custcount = $statment->rowCount();

        if($custcount>0){
            $result=$statment->fetch();
            if($result['role']=='admin'){
                if($result['status']=='1'){

                    $_SESSION['mans']= $result['email'];

                    header("Location:dashboard.php");


                }else{
                echo "<h2 class='alert alert-primary text-center'> You Are Not Active </h2>";
                }


                }else{
                echo "<h2 class='alert alert-success text-center'> You Are Not Admin </h2>";
                }

                 }else{
                echo "<h2 class='alert alert-danger text-center'> You Are Not Found IN DB </h2>";
                }



    }
}




 ?>
 

 


<div class="container mt-5 ">
    <div class="row">
        <div class="col-md-10 m-auto">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" class="form-control " >
  <div class="form-group">
    <label >Email address</label>
    <input type="email" class="form-control p-2 bg-white" name="email" style="border: 2px solid gray;">
  </div>
  <div class="form-group">
    <label>Password</label>
    <input type="password" class="form-control p-2 bg-white" name="pass" style="border: 2px solid gray;">
  </div>
  <button type="submit" class="btn btn-outline btn btn-primary btn btn-block mt-3" style="width: 100%;" name="submit-login">Login</button>
</form>

        </div>
    </div>
</div>





<?php
include("includes/temp/footer.php");
?>