<?php
session_start();
error_reporting(0);
include ('compartido/dbconnection.php');
error_reporting(0);
if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $adminid = $_SESSION['sturecmsaid'];
    $cpassword = md5($_POST['currentpassword']);
    $newpassword = md5($_POST['newpassword']);
    $sql = "SELECT ID FROM tbladmin WHERE ID=:adminid and Password=:cpassword";
    $query = $dbh->prepare($sql);
    $query->bindParam(':adminid', $adminid, PDO::PARAM_STR);
    $query->bindParam(':cpassword', $cpassword, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
      $con = "update tbladmin set Password=:newpassword where ID=:adminid";
      $chngpwd1 = $dbh->prepare($con);
      $chngpwd1->bindParam(':adminid', $adminid, PDO::PARAM_STR);
      $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
      $chngpwd1->execute();

      echo '<script>alert("Tu contrasena se cambio correctamente")</script>';
    } else {
      echo '<script>alert("Tu contrasena actual es erronea")</script>';
    }
  }
  ?>

  <?php include_once ('compartido/header.php'); ?>
  <div class="container-fluid page-body-wrapper">
    <?php include_once ('compartido/sidebar.php'); ?>
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title"> Cambiar Contrasena </h3>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Cambiar Contrasena</li>
            </ol>
          </nav>
        </div>
        <div class="row">

          <div class="col-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title" style="text-align: center;">Cambiar Contrasena</h4>

                <form class="forms-sample" name="changepassword" method="post" onsubmit="return checkpass();">

                  <div class="form-group">
                    <label for="exampleInputName1">Actual Contrasena</label>
                    <input type="password" name="currentpassword" id="currentpassword" class="form-control"
                      required="true">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail3">Nueva Contrasena</label>
                    <input type="password" name="newpassword" class="form-control" required="true">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword4">Confirmar Contrasena</label>
                    <input type="password" name="confirmpassword" id="confirmpassword" value="" class="form-control"
                      required="true">
                  </div>

                  <button type="submit" class="btn btn-primary mr-2" name="submit">Cambiar Contrasena</button>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php include_once ('compartido/footer.php'); ?>
    </div>
  </div>
  </div>
<?php } ?>