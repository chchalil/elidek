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
   $executives = $conn->query("SELECT * FROM executive_to_project
INNER JOIN executives ON executive_to_project.executive_id = executives.id
GROUP BY executive_id")->fetchAll();


//print_r($data);
//exit();

if (isset($_GET['q'])){
    if(isset($_GET['start_date'])){
        $start_date = "";
    }else{
        $start_date = $_GET['start_date'];
    }
    if(isset($_GET['expiry_date'])){
        $expiry_date = "";
    }else{
        $expiry_date = $_GET['expiry_date'];
    }

    if(isset($_GET['duration'])){
        $duration = "";
    }else{
        $duration = $_GET['duration'];
    }
    if(isset($_GET['executive_id'])){
        $executive_id = "";
    }else{
        $executive_id = $_GET['executive_id'];
    }
}
    $data = $conn->query("SELECT projects.id, projects.title, projects.summery, projects.amount_of_fund, projects.duration, projects.start_date, projects.expiry_date, executives.name,executives.surname FROM projects
LEFT JOIN researcher_on_project as ronpr ON ronpr.project_id=projects.id
LEFT JOIN researchers as res ON ronpr.researcher_id = res.id
LEFT JOIN executive_to_project ON executive_to_project.project_id=projects.id
LEFT JOIN executives ON executive_to_project.executive_id = executives.id
         WHERE projects.start_date >= '' AND projects.expiry_date <= '' OR projects.duration = 1 OR  executives.id='' order by  projects.id asc")->fetchAll();

 $q=1;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ΕΛ.ΙΔ.Ε.Κ. | Projects</title>

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
                        <h1>Projects</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Projects</li>
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

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
<form action="<?=$_SERVER['PHP_SELF']?>" method="POST" >
    <label>Date</label>
    <br/>
    <div class="row">

        <div class="col">

            <label> From</label>
            <input type="text" class="form-control" placeholder="YYYY-MM-DD" name="start_date" id="start_date">
        </div>
        <div class="col">
            <label> Until</label>
            <input type="text" class="form-control" placeholder="YYYY-MM-DD" name="expiry_date" id="expiry_date">
        </div>
    </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Duration</label>
                            <select class="custom-select rounded-0" id="duration" name="duration">
                                <option selected value=""> </option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Executive</label>
                            <select class="custom-select rounded-0" id="executive_id" name="executive_id">
                                <option selected value=""> </option>
                                <?php
                                foreach ($executives as $ex){
                                 echo '
                                
                                <option value="'.$ex['executive_id'].'">'.$ex['surname'].' '.$ex['name'].' ( '.$ex['tax_identification_number'].' )</option>';

}
                                ?>
                            </select>
                        </div>

                </div>

                <button type="submit"  class="btn btn-primary">Search</button>
                </form>
                <!-- /.card-body -->
                <div class="card-footer">

                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card --><?php if($q == 1){
           echo '<div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>

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
                            <th>Title</th>
                            <th>Amount<br/> of Fund</th>
                            <th>Duration</th>
                            <th>Start<br/>Date</th>
                            <th>Expiry<br/>Date</th>
                            <th>Executive<br/>Name</th>
                            <th>Executive<br/>Surname</th>
                           
                        </tr>
                        </thead>
                        <tbody>';
foreach ($data as $d){
    echo "                        <tr>
<td>".$d['id']."</td><td>".$d['title']."</td><td>".$d['amount_of_fund']."</td><td>".$d['duration']."</td>
<td>".$d['start_date']."</td><td>".$d['expiry_date']."</td>
<td>".$d['name']."</td><td>".$d['surname']."</td></tr>";
}
                        echo '</tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>';

            }
            ?>
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

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
        print($_POST['duration']);
    echo "<br />";
    print($_POST['start_date']);
    echo "<br />";
    print($_POST['expiry_date']);
    echo "<br />";
    print($_POST['executive_id']);

    $s_query = $conn->prepare("SELECT * FROM projects
LEFT JOIN researcher_on_project as ronpr ON ronpr.project_id=projects.id
LEFT JOIN researchers as res ON ronpr.researcher_id = res.id
LEFT JOIN executive_to_project ON executive_to_project.project_id=projects.id
LEFT JOIN executives ON executive_to_project.executive_id = executives.id
         WHERE projects.start_date >= '0000-01-01' AND projects.expiry_date <= '2030-12-31' OR projects.duration = 1 OR  executives.id=1 order by  projects.id asc
")->fetchAll();

    print_r($s_query);


}


?>
