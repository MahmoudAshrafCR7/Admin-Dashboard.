<?php
session_start();
include('includes/temp/header.php');
include('includes/db/db.php');
include('includes/temp/navbar.php');

if (isset($_SESSION['mans'])) {

  
    $statment = $connect->prepare("SELECT * FROM users");
    $statment->execute();
    $usercount = $statment->rowCount();
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
          <div class="row " >
              <div style="margin-left: 200px;" class="col-md-10 ">
                  <div class="card ">
                      <div class="card-header bg-gradient-dark text-light d-flex justify-content-between align-items-center">
                          <div>
                              Users <span class="badge badge-primary ml-1 p-1"> <?php echo $usercount ?></span>
                          </div>
                          <a href="?page=create" class="btn btn-success">Create New User</a>
                      </div>
                      <div class="card-body">
                          <table class="table bg-gradient-dark text-light">
                              <thead>
                                  <tr>
                                      <th scope="col">ID</th>
                                      <th scope="col">Name</th>
                                      <th scope="col">E-mail</th>
                                      <th scope="col">Status</th>
                                      <th scope="col">Role</th>
                                      <th scope="col">Opreation</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  if ($usercount>0) {
                                      foreach ($result as $item) {
                                  ?>
                                          <tr>
                                              <td style="padding-left:25px;" scope="row"><?php echo $item['user_id'] ?></td>
                                              <td style="padding-left:25px;"><?php echo $item['user_name'] ?></td>
                                              <td style="padding-left:25px;"><?php echo $item['email'] ?></td>
                                              <td style="padding-left:25px;"><?php echo $item['status'] ?></td>
                                              <td style="padding-left:25px;"><?php echo $item['role'] ?></td>
                                              <td>
                                                  <a href="?page=show&user_id=<?php echo $item['user_id'] ?>" class="btn btn-success">
                                                      <i class="fa-solid fa-eye"></i>
                                                  </a>

                                                  <a href="?page=edit&user_id=<?php echo $item['user_id'] ?>" class="btn btn-primary">
                                                      <i class="fa-solid fa-pencil"></i>
                                                  </a>

                                                  <a href="?page=delete&user_id=<?php echo $item['user_id'] ?>" class="btn btn-danger">
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
        $user_id = "";
        if (isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];
        } else {
            $user_id = "";
        }

        $statment = $connect->prepare("SELECT * from users where user_id=? limit 1");
        $statment->execute(array($user_id));
        $usercount = $statment->rowCount();
        $result = $statment->fetch();

    ?>

        <div class="container mt-5 ">
            <div class="row">
                <div style="margin-left: 200px;" class="col-md-10">
                    <div class="card">
                        <div class="card-header bg-gradient-dark  text-light">
                            Users <span class="badge badge-primary ml-1 p-1"> <?php echo $usercount ?></span>
                        </div>
                        <div class="card-body">
                            <table class="table bg-gradient-dark text-light">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">E-mail</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Opreation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($usercount > 0) {

                                    ?>
                                        <tr>
                                            <td scope="row"><?php echo $result['user_id'] ?></td>
                                            <td><?php echo $result['user_name'] ?></td>
                                            <td><?php echo $result['email'] ?></td>
                                            <td><?php echo $result['status'] ?></td>
                                            <td><?php echo $result['role'] ?></td>
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
        $user_id = "";
        if (isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];
        } else {
            $user_id = "";
        }
        $statment = $connect->prepare("DELETE FROM users WHERE user_id=?");
        $statment->execute(array($user_id));
        header("Location:users.php?page=All");
    } else if ($page == "edit") {
        $user_id = "";
        if (isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];
        } else {
            $user_id = "";
        }

        $statment = $connect->prepare("SELECT * FROM users WHERE user_id=? limit 1");
        $statment->execute(array($user_id));
        $result = $statment->fetch();
    ?>

        <div class="container mt-5">
            <div class="row" >
                <div  style="margin-left: 300px;" class="col-md-10 ">
                    <form  method="post" action="?page=save-update">
                        <input type="hidden" value="<?php echo $result['user_id'] ?>" name="old_id">
                        <div  class="form-group" style="width: 70%;">
                            <label>ID</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="id" value="<?php echo $result['user_id'] ?>">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label> Name</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="user_name" value="<?php echo $result['user_name'] ?>">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>email</label>
                            <input style="border: 1px solid #aaa;" type="email" class="form-control  p-2" name="email" value="<?php echo $result['email'] ?>">
                        </div>

                        <div class="form-group" style="width: 70%;">
                            <label>Status</label>
                            <select name="status" class="form-control  p-2" style="border: 1px solid #aaa;">
                                <?php
                                if ($result['status'] == 1) {

                                ?>
                                    <option value="0">Block</option>
                                    <option value="1" selected>Active</option>

                                <?php
                                } else {
                                ?>
                                    <option value="0" selected>Block</option>
                                    <option value="1">Active</option>
                                <?php
                                }
                                ?>

                            </select>
                        </div>

                        <div class="form-group" style="width: 70%;">
                            <label>Role</label>
                            <select name="role" class="form-control  p-2" style="border: 1px solid #aaa;">
                                <?php
                                if ($result['role'] == "admin") {

                                ?>
                                    <option value="user">USER</option>
                                    <option value="admin" selected>ADMIN</option>

                                <?php
                                } else {
                                ?>
                                    <option value="user" selected>USER</option>
                                    <option value="admin">ADMIN</option>
                                <?php
                                }
                                ?>

                            </select>
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
                $user= $_POST['user_name'];
                $email = $_POST['email'];
                $status = $_POST['status'];
                $role = $_POST['role'];

                try {


                $statment = $connect->prepare("UPDATE users set 
                user_id=?,
                user_name = ?,
                email=?,
                `status`=?,
                `role`=?
                where user_id=?
                ");
                    $statment->execute(array($new_id, $user, $email, $status, $role, $old_id));
                    echo "<h2 class='alert alert-success text-center'>Update Successfully</h2>";
                    header("Refresh:3;url=users.php");
                    
                } catch (PDOException $e) {
                    echo "<h2 class='alert alert-danger text-center'>Your ID Used Before</h2>";
                    header("Refresh:3;url=users.php?page=edit&user_id=$old_id");
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
                            <label>User Name</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="user_name" value="<?php 
                            if(isset($_SESSION['user_name'])){
                                echo $_SESSION['user_name'];
                                unset($_SESSION['user_name']);
                            }
                            ?>">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>Password</label>
                            <input type="password" class="form-control p-2" name="pass" style="border: 1px solid #aaa;"
>
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>email</label>
                            <input type="email" class="form-control p-2" name="email" style="border: 1px solid #aaa;"
>
                        </div>

                        <div class="form-group" style="width: 70%;">
                            <label>Status</label>
                            <select name="status" class="form-control p-2" style="border: 1px solid #aaa;"
>
                                <option value="0">Block</option>
                                <option value="1">Active</option>

                            </select>
                        </div>

                        <div class="form-group" style="width: 70%;">
                            <label>Role</label>
                            <select name="role" class="form-control p-2" style="border: 1px solid #aaa;"
>

                                <option value="user">USER</option>
                                <option value="admin">ADMIN</option>
                            </select>
                        </div>


                        <button type="submit" class="btn btn-primary btn-block mt-4" name="submit-create">Create New Customer</button>
                    </form>
                </div>
            </div>
        </div>

    <?php

    } else if ($page == "save-create"){
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['submit-create'])) {
                $id = $_POST['id'];
                $user = $_POST['user_name'];
                $email = $_POST['email'];
                $pass = $_POST['pass'];
                $hashPassword = sha1($pass);
                $role = $_POST['role'];
                $status = $_POST['status'];

                try{

                    $statment = $connect->prepare("INSERT INTO users 
                    (user_id, user_name, email, `password`,`role`,`status`)
                    values(?,?,?,?,?,?)
                    ");
                    $statment->execute(array($id, $user, $email, $hashPassword, $role, $status));
                    echo "<h2 class='alert alert-success text-center'>Created successfully</h2>";
                    header("Refresh:1;url=users.php");
                } catch (PDOException $e) {
                    echo "<h2 class='alert alert-danger text-center'>You Used This id Before</h2>";
                    $_SESSION['ahmed'] = "Insert Anthor Id";
                    $_SESSION['customer_name'] =$user ;
                    $_SESSION['email'] = $email;
                    $_SESSION['status'] = $status;
                    $_SESSION['role'] = $role;
                    header('Refresh:3;url=users.php?page=create');
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
