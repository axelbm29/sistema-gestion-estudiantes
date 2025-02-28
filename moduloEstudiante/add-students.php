<?php
session_start();
error_reporting(0);
include ('../compartido/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $stuname = $_POST['stuname'];
        $stuemail = $_POST['stuemail'];
        $stuclass = $_POST['stuclass'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $stuid = $_POST['stuid'];
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $connum = $_POST['connum'];
        $altconnum = $_POST['altconnum'];
        $address = $_POST['address'];
        $uname = $_POST['uname'];
        $password = $_POST['password'];

        $ret = "select UserName from tblstudent where UserName=:uname || StuID=:stuid";
        $query = $dbh->prepare($ret);
        $query->bindParam(':uname', $uname, PDO::PARAM_STR);
        $query->bindParam(':stuid', $stuid, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() == 0) {
            $sql = "insert into tblstudent(StudentName,StudentEmail,StudentClass,Gender,DOB,StuID,FatherName,MotherName,ContactNumber,AlternateNumber,Address,UserName,Password, DateofAdmission)values(:stuname,:stuemail,:stuclass,:gender,:dob,:stuid,:fname,:mname,:connum,:altconnum,:address,:uname,:password, CURDATE())";
            $query = $dbh->prepare($sql);
            $query->bindParam(':stuname', $stuname, PDO::PARAM_STR);
            $query->bindParam(':stuemail', $stuemail, PDO::PARAM_STR);
            $query->bindParam(':stuclass', $stuclass, PDO::PARAM_STR);
            $query->bindParam(':gender', $gender, PDO::PARAM_STR);
            $query->bindParam(':dob', $dob, PDO::PARAM_STR);
            $query->bindParam(':stuid', $stuid, PDO::PARAM_STR);
            $query->bindParam(':fname', $fname, PDO::PARAM_STR);
            $query->bindParam(':mname', $mname, PDO::PARAM_STR);
            $query->bindParam(':connum', $connum, PDO::PARAM_STR);
            $query->bindParam(':altconnum', $altconnum, PDO::PARAM_STR);
            $query->bindParam(':address', $address, PDO::PARAM_STR);
            $query->bindParam(':uname', $uname, PDO::PARAM_STR);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->execute();
            $LastInsertId = $dbh->lastInsertId();
            if ($LastInsertId > 0) {
                echo '<script>alert("Estudiante ha sido agregado correctamente")</script>';
                echo "<script>window.location.href ='add-students.php'</script>";
            } else {
                echo '<script>alert("Algo salió mal, favor reintentar")</script>';
            }
        } else {
            echo "<script>alert('Usuario o ID existente, favor reintentar');</script>";
        }
    }
    ?>

    <?php include_once ('../compartido/header.php'); ?>
    <div class="container-fluid page-body-wrapper">
        <?php include_once ('../compartido/sidebar.php'); ?>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title"> Agregar Estudiante </h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Agregar Estudiante</li>
                        </ol>
                    </nav>
                </div>
                <div class="row">

                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form class="forms-sample row" method="post">
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Nombres de Estudiante</label>
                                        <input type="text" name="stuname" value="" class="form-control" required='true'>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Correo del Estudiante</label>
                                        <input type="text" name="stuemail" value="" class="form-control" required='true'>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail3">Periodo Academico del Estudiante</label>
                                        <select name="stuclass" class="form-control" required='true'>
                                            <option value="">Selecciona Periodo Academico</option>
                                            <?php
                                            $sql2 = "SELECT * from    tblclass ";
                                            $query2 = $dbh->prepare($sql2);
                                            $query2->execute();
                                            $result2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                            foreach ($result2 as $row1) {
                                                ?>
                                                <option value="<?php echo htmlentities($row1->ID); ?>">
                                                    <?php echo htmlentities($row1->ClassName); ?>
                                                    <?php echo htmlentities($row1->Section); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Genero</label>
                                        <select name="gender" value="" class="form-control" required='true'>
                                            <option value="">Selecciona Genero</option>
                                            <option value="Male">Masculino</option>
                                            <option value="Female">Femenino</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Fecha de Nacimiento</label>
                                        <input type="date" name="dob" value="" class="form-control" required='true'>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">ID de Estudiante</label>
                                        <input type="text" name="stuid" value="" class="form-control" required='true'>
                                    </div>
                                    <h3 class="col-md-12" style="margin-top:20px;">Padres / Acudientes</h3>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Nombres del Padre</label>
                                        <input type="text" name="fname" value="" class="form-control" required='true'>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Nombres de la Madre</label>
                                        <input type="text" name="mname" value="" class="form-control" required='true'>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Numero de Contacto</label>
                                        <input type="text" name="connum" value="" class="form-control" required='true'
                                            maxlength="10" pattern="[0-9]+">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Numero de Telefono Alternativo</label>
                                        <input type="text" name="altconnum" value="" class="form-control" required='true'
                                            maxlength="10" pattern="[0-9]+">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="exampleInputName1">Direccion</label>
                                        <textarea name="address" class="form-control"></textarea>
                                    </div>
                                    <h3 class="col-md-12" style="margin-top:20px;">Detalles de Acceso</h3>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Nombre de Usuario</label>
                                        <input type="text" name="uname" value="" class="form-control" required='true'>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Contrasena</label>
                                        <input type="Password" name="password" value="" class="form-control"
                                            required='true'>
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-2" name="submit">Agregar</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include_once ('../compartido/footer.php'); ?>
        </div>
    </div>
    </div>
<?php } ?>