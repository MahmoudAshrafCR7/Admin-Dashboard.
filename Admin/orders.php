<?php
session_start();
include("inti.php");
if (isset($_SESSION['mans'])) {

  
    $statment = $connect->prepare("SELECT * FROM orders");
    $statment->execute();
    $ordcount = $statment->rowCount();
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
              <div style="margin-left: 200px;" class="col-md-10">
                  <div class="card">
                      <div class="card-header bg-gradient-dark text-light d-flex justify-content-between align-items-center">
                          <div>
                              Orders <span class="badge badge-primary ml-1 p-1"> <?php echo $ordcount ?></span>
                          </div>
                          <a href="?page=create" class="btn btn-success">Create New Order</a>
                      </div>
                      <div class="card-body">
                          <table class="table bg-gradient-dark text-light">
                              <thead>
                                  <tr>
                                      <th scope="col">ID</th>
                                      <th scope="col">Title</th>
                                      <th scope="col">Details</th>
                                      <th scope="col">city</th>
                                      <th scope="col">customer_id</th>
                                      <th scope="col">shipper_id</th>
                                      <th scope="col">Operation</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  if ($ordcount>0) {
                                      foreach ($result as $item) {
                                  ?>
                                          <tr>
                                              <td scope="row"><?php echo $item['order_id'] ?></td>
                                              <td><?php echo $item['title'] ?></td>
                                              <td><?php echo $item['detailes'] ?></td>
                                              <td><?php echo $item['city'] ?></td>
                                              <td><?php echo $item['customer_id'] ?></td>
                                              <td><?php echo $item['shipper_id'] ?></td>
                                              <td>
                                                  <a href="?page=show&order_id=<?php echo $item['order_id'] ?>" class="btn btn-success">
                                                      <i class="fa-solid fa-eye"></i>
                                                  </a>

                                                  <a href="?page=edit&order_id=<?php echo $item['order_id'] ?>" class="btn btn-primary">
                                                      <i class="fa-solid fa-pencil"></i>
                                                  </a>

                                                  <a href="?page=delete&order_id=<?php echo $item['order_id'] ?>" class="btn btn-danger">
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
        $order_id = "";
        if (isset($_GET['order_id'])) {
            $order_id = $_GET['order_id'];
        } else {
            $order_id = "";
        }

        $statment = $connect->prepare("SELECT * from orders where order_id=? limit 1");
        $statment->execute(array($order_id));
        $ordcount = $statment->rowCount();
        $result = $statment->fetch();

    ?>

        <div class="container mt-5">
            <div class="row">
                <div style="margin-left: 200px;" class="col-md-10">
                    <div class="card">
                        <div class="card-header bg-gradient-dark text-light">
                            Orders <span class="badge badge-primary ml-1 p-1"> <?php echo $ordcount ?></span>
                        </div>
                        <div class="card-body">
                            <table class="table bg-gradient-dark text-light">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Detailes</th>
                                        <th scope="col">city</th>
                                        <th scope="col">customer_id</th>
                                        <th scope="col">shipper_id</th>
                                        <th scope="col">Operation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($ordcount > 0) {

                                    ?>
                                        <tr>
                                            <td scope="row"><?php echo $result['order_id'] ?></td>
                                            <td><?php echo $result['title'] ?></td>
                                            <td><?php echo $result['detailes'] ?></td>
                                            <td><?php echo $result['city'] ?></td>
                                            <td><?php echo $result['customer_id'] ?></td>
                                            <td><?php echo $result['shipper_id'] ?></td>
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
        $order_id = "";
        if (isset($_GET['order_id'])) {
            $order_id = $_GET['order_id'];
        } else {
            $order_id = "";
        }
        $statment = $connect->prepare("DELETE FROM orders WHERE order_id=?");
        $statment->execute(array($order_id));
        header("Location:orders.php?page=All");
    } else if ($page == "edit") {
        $order_id = "";
        if (isset($_GET['order_id'])) {
            $order_id = $_GET['order_id'];
        } else {
            $order_id = "";
        }

        $statment = $connect->prepare("SELECT * FROM orders WHERE order_id=? limit 1");
        $statment->execute(array($order_id));
        $result = $statment->fetch();
    ?>

        <div class="container mt-5">
            <div class="row">
                <div style="margin-left: 300px;" class="col-md-10">
                    <form method="post" action="?page=save-update">
                        <input type="hidden" value="<?php echo $result['order_id'] ?>" name="old_id">
                        <div class="form-group" style="width: 70%;">
                            <label>ID</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="id" value="<?php echo $result['order_id'] ?>">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>Title</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="title" value="<?php echo $result['title'] ?>">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>Details</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="detailes" value="<?php echo $result['detailes'] ?>">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>City</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="city" value="<?php echo $result['city'] ?>">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>customer_id</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="customer_id" value="<?php echo $result['customer_id'] ?>">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>shipper_id</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="shipper_id" value="<?php echo $result['shipper_id'] ?>">
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
                $order= $_POST['title'];
                $Details= $_POST['detailes'];
                $city = $_POST['city'];
                $customer_id = $_POST['customer_id'];
                $shipper_id = $_POST['shipper_id'];

                try {


                $statment = $connect->prepare("UPDATE orders set 
                order_id=?,
                title= ?,
                detailes=?,
                city=?,
                customer_id=?,
                shipper_id=?
                where order_id=?
                ");
                    $statment->execute(array($new_id, $order, $Details , $city, $customer_id, $shipper_id, $old_id));
                    echo "<h2 class='alert alert-success text-center'>Update Successfully</h2>";
                    header("Refresh:3;url=orders.php");
                } catch (PDOException $e) {
                    echo "<h2 class='alert alert-danger text-center'>Your ID Used Before</h2>";
                    header("Refresh:3;url=orders.php?page=edit&order_id=$old_id");
                }
            }
        }
    } else if ($page == "create") {

    ?>

        <div class="container mt-5">
            <div class="row">
                <div class="col-md-10" style="margin-left: 300px;">

                    <form method="post" action="?page=save-create">
                        <div class="form-group" style="width: 70%;">
                            <label>ID</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="id" value="<?php
                             if(isset($_SESSION['ahmed'])){
                              echo $_SESSION['ahmed'];
                              unset($_SESSION['ahmed']);}?>">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>Title</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="title" value="<?php 
                            if(isset($_SESSION['title'])){
                                echo $_SESSION['title'];
                                unset($_SESSION['title']);
                            }
                            ?>">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>Details</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="detailes">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>city</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="city">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>customer_id</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="customer_id">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>shipper_id</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="shipper_id">
                        </div>

                       
                  


                        <button type="submit" class="btn btn-primary btn-block mt-4" name="submit-create">Create New Order</button>
                    </form>
                </div>
            </div>
        </div>

    <?php

    } else if ($page == "save-create"){
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['submit-create'])) {
                $id = $_POST['id'];
                $order = $_POST['title'];
                $Details = $_POST['detailes'];
                $city = $_POST['city'];
                $customer_id = $_POST['customer_id'];
                $shipper_id = $_POST['shipper_id'];

                try{

                    $statment = $connect->prepare("INSERT INTO orders 
                    (order_id ,title,detailes,city,customer_id,shipper_id)
                    values(?,?,?,?,?,?)
                    ");
                    $statment->execute(array($id, $order, $Details, $city, $customer_id, $shipper_id));
                    echo "<h2 class='alert alert-success text-center'>Created successfully</h2>";
                    header("Refresh:1;url=orders.php");
                } catch (PDOException $e) {
                    echo "<h2 class='alert alert-danger text-center'>You Used This id Before</h2>";
                    $_SESSION['ahmed'] = "Insert Anthor Id";
                    $_SESSION['title'] =$order ;
                    $_SESSION['detailes'] = $Details;
                    $_SESSION['city'] = $city;
                    $_SESSION['customer_id'] = $customer_id;
                    $_SESSION['shipper_id'] = $shipper_id;
                    header('Refresh:3;url=orders.php?page=create');
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
