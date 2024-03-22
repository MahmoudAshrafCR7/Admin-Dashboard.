<?php
session_start();
include("inti.php");
if (isset($_SESSION['mans'])) {

  
    $statment = $connect->prepare("SELECT * FROM shippers");
    $statment->execute();
    $shippcount = $statment->rowCount();
    $result = $statment->fetchAll();
    $page = "All";

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = "All";
    }

    if ($page == "All"){
      ?>
      <div class="container mt-5">
          <div class="row">
              <div style="margin-left: 200px;" class="col-md-10 ">
                  <div class="card">
                      <div class="card-header bg-gradient-dark text-light d-flex justify-content-between align-items-center">
                          <div>
                              Shippers <span class="badge badge-primary ml-1 p-1"> <?php echo $shippcount ?></span>
                          </div>
                          <a href="?page=create" class="btn btn-success">Create New Shipper</a>
                      </div>
                      <div class="card-body">
                          <table class="table bg-gradient-dark text-light">
                              <thead>
                                  <tr>
                                      <th scope="col">ID</th>
                                      <th scope="col">Name</th>
                                      <th scope="col">Country</th>
                                      <th scope="col">Phone</th>
                                      <th scope="col">Status</th>
                                      <th scope="col">Created at</th>
                                      <th scope="col">Operation</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  if ($shippcount>0) {
                                      foreach ($result as $item) {
                                  ?>
                                          <tr>
                                              <td scope="row"><?php echo $item['shipper_id'] ?></td>
                                              <td><?php echo $item['shipper_name'] ?></td>
                                              <td><?php echo $item['country'] ?></td>
                                              <td><?php echo $item['phone'] ?></td>
                                              <td><?php echo $item['status'] ?></td>
                                              <td><?php echo $item['created_at'] ?></td>
                                              <td>
                                                  <a href="?page=show&shipper_id=<?php echo $item['shipper_id'] ?>" class="btn btn-success">
                                                      <i class="fa-solid fa-eye"></i>
                                                  </a>

                                                  <a href="?page=edit&shipper_id=<?php echo $item['shipper_id'] ?>" class="btn btn-primary">
                                                      <i class="fa-solid fa-pencil"></i>
                                                  </a>

                                                  <a href="?page=delete&shipper_id=<?php echo $item['shipper_id'] ?>" class="btn btn-danger">
                                                      <i class="fa-solid fa-trash"></i>
                                                  </a>
                                              </td>


                                          </tr>
                                  <?php
                                      }
                                  }
                                  ?>

                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  <?php

    }else if ($page == "show"){
        $shipper_id = "";
        if (isset($_GET['shipper_id'])) {
            $shipper_id = $_GET['shipper_id'];
        } else {
            $shipper_id = "";
        }

        $statment = $connect->prepare("SELECT * from shippers where shipper_id=? limit 1");
        $statment->execute(array($shipper_id));
        $shippcount = $statment->rowCount();
        $result = $statment->fetch();

    ?>

        <div class="container mt-5">
            <div class="row">
                <div style="margin-left: 200px;" class="col-md-10">
                    <div class="card">
                        <div class="card-header bg-gradient-dark text-light">
                            Shippers <span class="badge badge-primary ml-1 p-1"> <?php echo $shippcount ?></span>
                        </div>
                        <div class="card-body">
                            <table class="table bg-gradient-dark text-light">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Country</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Operation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($shippcount > 0) {

                                    ?>
                                        <tr>
                                            <td scope="row"><?php echo $result['shipper_id'] ?></td>
                                            <td><?php echo $result['shipper_name'] ?></td>
                                            <td><?php echo $result['country'] ?></td>
                                            <td><?php echo $result['phone'] ?></td>
                                            <td><?php echo $result['status'] ?></td>
                                            <td><?php echo $result['created_at'] ?></td>
                                            <td>


                                                <a href="?page=All" class="btn btn-success">
                                                    <i class="fa-solid fa-home"></i>
                                                </a>
                                            </td>


                                        </tr>
                                    <?php
                                    }

                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else if ($page == "delete") {
        $shipper_id = "";
        if (isset($_GET['shipper_id'])) {
            $shipper_id = $_GET['shipper_id'];
        } else {
            $shipper_id = "";
        }
        $statment = $connect->prepare("DELETE FROM shippers WHERE shipper_id=?");
        $statment->execute(array($shipper_id));
        header("Location:shippers.php?page=All");


    } else if ($page == "edit") {
        $shipper_id = "";
        if (isset($_GET['shipper_id'])) {
            $shipper_id = $_GET['shipper_id'];
        } else {
            $shipper_id = "";
        }

        $statment = $connect->prepare("SELECT * FROM shippers WHERE shipper_id=? limit 1");
        $statment->execute(array($shipper_id));
        $result = $statment->fetch();
    ?>

        <div class="container mt-5">
            <div class="row">
                <div style="margin-left: 300px;" class="col-md-10">
                    <form method="post" action="?page=save-update">
                        <input type="hidden" value="<?php echo $result['shipper_id'] ?>" name="old_id">
                        <div class="form-group" style="width: 70%;">
                            <label>ID</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="id" value="<?php echo $result['shipper_id'] ?>">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>Name</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="shipper_name" value="<?php echo $result['shipper_name'] ?>">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>Country</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="country" value="<?php echo $result['country'] ?>">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>Phone</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="phone" value="<?php echo $result['phone'] ?>">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>Status</label>
                            <input style="border: 1px solid #aaa;" type="enum" class="form-control p-2" name="status" value="<?php echo $result['status'] ?>">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>Created At</label>
                            <input style="border: 1px solid #aaa;" type="timestamp" class="form-control p-2" name="created_at" value="<?php echo $result['created_at'] ?>">
                        </div>

                        

                        <button type="submit" class="btn btn-primary btn-block mt-4" name="submit-update">Edit</button>
                    </form>

                </div>
            </div>
        </div>

    <?php
    } else if ($page == "save-update") {


        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['submit-update'])) {

                $old_id = $_POST['old_id'];
                $new_id = $_POST['id'];
                $shipper= $_POST['shipper_name'];
                $country= $_POST['country'];
                $phone = $_POST['phone'];
                $status = $_POST['status'];
                $created_at = $_POST['created_at'];
                

                try {


                $statment = $connect->prepare("UPDATE shippers set 
                shipper_id=?,
                shipper_name= ?,
                country=?,
                phone=?,
                `status`=?,
                created_at=?
                where shipper_id=?
                ");
                    $statment->execute(array($new_id, $shipper, $country , $phone, $status, $created_at, $old_id));
                    echo "<h2 class='alert alert-success text-center'>Update Successfully</h2>";
                    header("Refresh:3;url=shippers.php");
                } catch (PDOException $e) {
                    echo "<h2 class='alert alert-danger text-center'>Your ID Used Before</h2>";
                    header("Refresh:3;url=shippers.php?page=edit&shipper_id=$old_id");
                }
            }
        }
    } else if ($page == "create") {

    ?>

        <div class="container mt-5">
            <div class="row">
                <div style="margin-left: 300px;" class="col-md-10">

                    <form method="post" action="?page=save-create">
                        <div class="form-group" style="width: 70%;">
                            <label>ID</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="id" value="<?php
                             if(isset($_SESSION['ahmed'])){
                              echo $_SESSION['ahmed'];
                              unset($_SESSION['ahmed']);}?>">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>shipper name</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="shipper_name" value="<?php 
                            if(isset($_SESSION['shipper_name'])){
                                echo $_SESSION['shipper_name'];
                                unset($_SESSION['shipper_name']);
                            }
                            ?>">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>Country</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="country">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>Phone</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="phone">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>Status</label>
                            <input style="border: 1px solid #aaa;" type="enum" class="form-control p-2" name="status">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>created_at</label>
                            <input style="border: 1px solid #aaa;" type="timestamp" class="form-control p-2" name="created_at">
                        </div>

                       
                  


                        <button type="submit" class="btn btn-primary btn-block mt-4" name="submit-create">Create New Shipper</button>
                    </form>
                </div>
            </div>
        </div>

    <?php

    } else if ($page == "save-create"){
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['submit-create'])) {
                $id = $_POST['id'];
                $shipper = $_POST['shipper_name'];
                $country = $_POST['country'];
                $phone = $_POST['phone'];
                $status = $_POST['status'];
                

                try{

                    $statment = $connect->prepare("INSERT INTO shippers 
                    (shipper_id ,shipper_name,country,phone,`status`,created_at)
                    values(?,?,?,?,?,now())
                    ");
                    $statment->execute(array($id, $shipper, $country, $phone, $status));
                    echo "<h2 class='alert alert-success text-center'>Created successfully</h2>";
                    header("Refresh:1;url=shippers.php");
                } catch (PDOException $e) {
                    echo "<h2 class='alert alert-danger text-center'>You Used This id Before</h2>";
                    $_SESSION['ahmed'] = "Insert Anthor Id";
                    $_SESSION['shipper_name'] =$shipper ;
                    $_SESSION['country'] = $country;
                    $_SESSION['phone'] = $phone;
                    $_SESSION['status'] = $status;

                    header('Refresh:3;url=shippers.php?page=create');
                }
            }
        }
    }
    ?>



<?php
    include('includes/temp/footer.php');
} else {
    header("Location:login.php");
}
?>
