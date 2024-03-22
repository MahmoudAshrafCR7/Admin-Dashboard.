<?php
session_start();
include("inti.php");
if (isset($_SESSION['mans'])) {

  
    $statment = $connect->prepare("SELECT * FROM sections");
    $statment->execute();
    $seccount = $statment->rowCount();
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
                              Sections <span class="badge badge-primary ml-1 p-1"> <?php echo $seccount ?></span>
                          </div>
                          <a href="?page=create" class="btn btn-success">Create New section</a>
                      </div>
                      <div class="card-body">
                          <table class="table bg-gradient-dark text-light">
                              <thead>
                                  <tr>
                                      <th scope="col">ID</th>
                                      <th scope="col">Name</th>
                                      <th scope="col">Descripton</th>
                                      <th scope="col">Status</th>
                                      <th scope="col">Created at</th>
                                      <th scope="col">Operation</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  if ($seccount>0) {
                                      foreach ($result as $item) {
                                  ?>
                                          <tr>
                                              <td scope="row"><?php echo $item['section_id'] ?></td>
                                              <td><?php echo $item['section_name'] ?></td>
                                              <td><?php echo $item['descripton'] ?></td>
                                              <td><?php echo $item['status'] ?></td>
                                              <td><?php echo $item['created_at'] ?></td>
                                              <td>
                                                  <a href="?page=show&section_id=<?php echo $item['section_id'] ?>" class="btn btn-success">
                                                      <i class="fa-solid fa-eye"></i>
                                                  </a>

                                                  <a href="?page=edit&section_id=<?php echo $item['section_id'] ?>" class="btn btn-primary">
                                                      <i class="fa-solid fa-pencil"></i>
                                                  </a>

                                                  <a href="?page=delete&section_id=<?php echo $item['section_id'] ?>" class="btn btn-danger">
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
        $section_id  = "";
        if (isset($_GET['section_id'])) {
            $section_id  = $_GET['section_id'];
        } else {
            $section_id  = "";
        }

        $statment = $connect->prepare("SELECT * from sections where section_id=? limit 1");
        $statment->execute(array($section_id ));
        $seccount = $statment->rowCount();
        $result = $statment->fetch();

    ?>

        <div class="container mt-5">
            <div class="row">
                <div  style="margin-left: 200px;" class="col-md-10 ">
                    <div class="card">
                        <div class="card-header bg-gradient-dark  text-light">
                            Sections <span class="badge badge-primary ml-1 p-1"> <?php echo $seccount ?></span>
                        </div>
                        <div class="card-body">
                            <table class="table bg-gradient-dark text-light">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Descripton</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Operation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($seccount > 0) {

                                    ?>
                                        <tr>
                                            <td scope="row"><?php echo $result['section_id'] ?></td>
                                            <td><?php echo $result['section_name'] ?></td>
                                            <td><?php echo $result['descripton'] ?></td>
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
        $section_id = "";
        if (isset($_GET['section_id'])) {
            $section_id = $_GET['section_id'];
        } else {
            $section_id = "";
        }
        $statment = $connect->prepare("DELETE FROM sections WHERE section_id=?");
        $statment->execute(array($section_id));
        header("Location:sections.php?page=All");


    } else if ($page == "edit") {
        $section_id = "";
        if (isset($_GET['section_id'])) {
            $section_id = $_GET['section_id'];
        } else {
            $section_id = "";
        }

        $statment = $connect->prepare("SELECT * FROM sections WHERE section_id=? limit 1");
        $statment->execute(array($section_id));
        $result = $statment->fetch();
    ?>

        <div class="container mt-5">
            <div class="row">
                <div style="margin-left: 300px;" class="col-md-10">
                    <form method="post" action="?page=save-update">
                        <input type="hidden" value="<?php echo $result['section_id'] ?>" name="old_id">
                        <div class="form-group"  style="width: 70%;">
                            <label>ID</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="id" value="<?php echo $result['section_id'] ?>">
                        </div>
                        <div class="form-group"  style="width: 70%;">
                            <label>Section Name</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="section_name" value="<?php echo $result['section_name'] ?>">
                        </div>
                        <div class="form-group"  style="width: 70%;">
                            <label>Descripton</label>
                            <input style="border: 1px solid #aaa;" type="text" class="form-control p-2" name="descripton" value="<?php echo $result['descripton'] ?>">
                        </div>
                        <div class="form-group"  style="width: 70%;">
                            <label>Status</label>
                            <input style="border: 1px solid #aaa;" type="enum" class="form-control p-2" name="status" value="<?php echo $result['status'] ?>">
                        </div>
                        <div class="form-group"  style="width: 70%;">
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
                $section= $_POST['section_name'];
                $Descripton= $_POST['descripton'];
                $status = $_POST['status'];
                $created_at = $_POST['created_at'];
                

                try {


                $statment = $connect->prepare("UPDATE sections set 
                section_id=?,
                section_name= ?,
                descripton=?,
                `status`=?,
                created_at=?
                where section_id=?
                ");
                    $statment->execute(array($new_id, $section, $Descripton ,$status, $created_at, $old_id));
                    echo "<h2 class='alert alert-success text-center'>Update Successfully</h2>";
                    header("Refresh:3;url=sections.php");
                } catch (PDOException $e) {
                    echo "<h2 class='alert alert-danger text-center'>Your ID Used Before</h2>";
                    header("Refresh:3;url=sections.php?page=edit&section_id=$old_id");
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
                            <input style="border: 1px solid #aaa;"  type="text" class="form-control p-2" name="id" value="<?php
                             if(isset($_SESSION['ahmed'])){
                              echo $_SESSION['ahmed'];
                              unset($_SESSION['ahmed']);}?>">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>Section name</label>
                            <input style="border: 1px solid #aaa;"  type="text" class="form-control p-2" name="section_name" value="<?php 
                            if(isset($_SESSION['section_name'])){
                                echo $_SESSION['section_name'];
                                unset($_SESSION['section_name']);
                            }
                            ?>">
                        </div>
                        <div class="form-group" style="width: 70%;">
                            <label>Descripton</label>
                            <input style="border: 1px solid #aaa;"  type="text" class="form-control p-2" name="descripton">
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
                            <label>created_at</label>
                            <input style="border: 1px solid #aaa;"  type="timestamp" class="form-control p-2" name="created_at">
                        </div>
                       
                  


                        <button type="submit" class="btn btn-primary btn-block mt-4" name="submit-create">Create New Section</button>
                    </form>
                </div>
            </div>
        </div>

    <?php

    } else if ($page == "save-create"){
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['submit-create'])) {
                $id = $_POST['id'];
                $section = $_POST['section_name'];
                $Descripton = $_POST['descripton'];
                $status = $_POST['status'];
                

                try{

                    $statment = $connect->prepare("INSERT INTO sections 
                    (section_id ,section_name,descripton,`status`,created_at)
                    values(?,?,?,?,now())
                    ");
                    $statment->execute(array($id, $section, $Descripton, $status));
                    echo "<h2 class='alert alert-success text-center'>Created successfully</h2>";
                    header("Refresh:1;url=sections.php");
                } catch (PDOException $e) {
                    echo "<h2 class='alert alert-danger text-center'>You Used This id Before</h2>";
                    $_SESSION['ahmed'] = "Insert Anthor Id";
                    $_SESSION['section_name'] =$section ;
                    $_SESSION['descripton'] = $Descripton;
                    $_SESSION['status'] = $status;
                   

                    header('Refresh:3;url=sections.php?page=create');
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
