<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=elidek", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$getDataProjects = $conn->query("SELECT asdf.description as description,p.id as project_id, p.title as project_title, researchers.id as res_id, researchers.name, researchers.surname FROM
(SELECT project_scientific_fields.scientific_field_id,scientific_fields.description, COUNT(project_scientific_fields.scientific_field_id) as count_sf
FROM project_scientific_fields
INNER JOIN projects ON projects.id = project_scientific_fields.project_id  AND start_date >='2022-06-05'
INNER JOIN scientific_fields ON scientific_fields.id = project_scientific_fields.scientific_field_id
GROUP BY  project_scientific_fields.scientific_field_id
ORDER BY count_sf DESC LIMIT 1) as asdf
INNER JOIN project_scientific_fields ON asdf.scientific_field_id=project_scientific_fields.scientific_field_id
INNER JOIN projects p on project_scientific_fields.project_id = p.id
INNER JOIN researcher_on_project rop on p.id = rop.project_id
INNER JOIN researchers on rop.researcher_id = researchers.id
GROUP BY p.id
ORDER BY p.id asc;")->fetchAll();

$getDataResearchers = $conn->query("SELECT asdf.description as description,p.id as project_id, p.title as project_title, researchers.id as res_id, researchers.name, researchers.surname FROM
(SELECT project_scientific_fields.scientific_field_id,scientific_fields.description, COUNT(project_scientific_fields.scientific_field_id) as count_sf
FROM project_scientific_fields
INNER JOIN projects ON projects.id = project_scientific_fields.project_id  AND start_date >='2022-06-05'
INNER JOIN scientific_fields ON scientific_fields.id = project_scientific_fields.scientific_field_id
GROUP BY  project_scientific_fields.scientific_field_id
ORDER BY count_sf DESC LIMIT 1) as asdf
INNER JOIN project_scientific_fields ON asdf.scientific_field_id=project_scientific_fields.scientific_field_id
INNER JOIN projects p on project_scientific_fields.project_id = p.id
INNER JOIN researcher_on_project rop on p.id = rop.project_id
INNER JOIN researchers on rop.researcher_id = researchers.id
GROUP BY researchers.id
ORDER BY p.id asc;")->fetchAll();

//print_r($getDataProjects);
//exit();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ΕΛ.ΙΔ.Ε.Κ. | The Scientific Field of most interest</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="template/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="template/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="../index.php" class="nav-link">Home</a>
            </li>

        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">


            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>

        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include 'template/sidebar.php';?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>The Scientific Field of most interest</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">The Scientific Field of most interest</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    Projects
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Project Title</th>
                            <th>Scientific Field</th>


                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($getDataProjects as $q){
                            echo "<tr>
                            <td>".$q['project_id']."</td>
                             <td>".$q['project_title']."</td>
                             <td>".$q['description']."</td>
                            
                            

                        </tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    Researchers
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Scientific Field</th>


                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($getDataResearchers as $q){
                            echo "<tr>
                            <td>".$q['res_id']."</td>
                             <td>".$q['name']."</td>
                             <td>".$q['surname']."</td>

                             <td>".$q['description']."</td>
                            
                            

                        </tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.2.0
        </div>
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="template/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="template/dist/js/adminlte.min.js"></script>

</body>
</html>
