<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$emp_id1 = $emp_id2 = $emp_id3 = $emp_id4 = $emp_id5 = $project_name = $module_name = "";
$emp_id1_err = $emp_id2_err = $emp_id3_err = $emp_id4_err = $emp_id5_err =$project_name_err = $module_name_err =  "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $input_emp_id1 = trim($_POST["emp_id1"]);
    if(empty($input_emp_id1)){
        $emp_id1_err = "Please enter a emp_id1.";     
    }
    else{
        $emp_id1 = $input_emp_id1;
    }
    
    $input_emp_id2 = trim($_POST["emp_id2"]);
    if(empty($input_emp_id2)){
        $emp_id_2err = "Please enter a emp_id2.";     
    }
    else{
        $emp_id2 = $input_emp_id2;
    }

    $input_emp_id3 = trim($_POST["emp_id3"]);
    if(empty($input_emp_id3)){
        $emp_id3_err = "Please enter a emp_id3.";     
    }
    else{
        $emp_id3 = $input_emp_id3;
    }

    $input_emp_id4 = trim($_POST["emp_id4"]);
    if(empty($input_emp_id4)){
        $emp_id4_err = "Please enter a emp_id4.";     
    }
    else{
        $emp_id4 = $input_emp_id4;
    }

    $input_emp_id5 = trim($_POST["emp_id5"]);
    if(empty($input_emp_id5)){
        $emp_id5_err = "Please enter a emp_id5.";     
    }
    else{
        $emp_id5 = $input_emp_id5;
    }

    
    $input_project_name = trim($_POST["project_name"]);
    if(empty($input_project_name)){
        $project_name_err = "Please enter a project name.";     
    }
    else{
        $project_name = $input_project_name;
    }

    $input_module_name = trim($_POST["module_name"]);
    if(empty($input_project_name)){
        $module_name_err = "Please enter a module name.";     
    }
    else{
        $module_name = $input_module_name;
    }

    // Check input errors before inserting in database
    if(empty($emp_id1_err) && empty($emp_id2_err) && empty($emp_id3_err) && empty($emp_id4_err) && empty($emp_id5_err) && empty($project_name_err) && empty($module_name_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO assign_group (emp_id1, emp_id2, emp_id3, emp_id4, emp_id5, project_name, module_name) VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            
            mysqli_stmt_bind_param($stmt,"sssssss",$param_emp_id1, $param_emp_id2 , $param_emp_id3, $param_emp_id4, $param_emp_id5, $param_project_name, $param_module_name);
            
            // Set parameters
            $param_emp_id1 = $emp_id1;
            $param_emp_id2 = $emp_id2;
            $param_emp_id3 = $emp_id3;
            $param_emp_id4 = $emp_id4;
            $param_emp_id5 = $emp_id5;
            $param_project_name = $project_name;
            $param_module_name = $module_name;            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: groupcreate.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ProjectGroupCreate</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  
</head>

<body id="page-top">
	<?php include('dashboardnav.php'); ?>
	
	<div id="wrapper">
	
		<?php include('sidebar.php'); ?>
  
    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Create New Project Group</li>
		  
        </ol>        

	
		<!-- AdminTable Example -->

		
        <div class="card mb-3">
		<div class="card-header">Create New Project Group</div>
          <div class="card-body">
            <div class="form-responsive">
			
			
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					
				<div class="form-group">
				<div class="form-row">
				<div class="col-md-6">
					<div class="form-label-group <?php echo (!empty($project_name_err)) ? 'has-error' : ''; ?>">
					  <input type="text" name="project_name" id="project_name" class="form-control" placeholder="project_name" value="<?php echo $project_name; ?>" required="required" autofocus="autofocus">
					  <label for="project_name">Project Name</label>
					  <span class="help-block"><?php echo $project_name_err; ?></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-label-group <?php echo (!empty($module_name_err)) ? 'has-error' : ''; ?>">
					  <input type="text" name="module_name" id="module_name" class="form-control" placeholder="module_name" value="<?php echo $module_name; ?>" required="required">
					  <label for="module_name">Module Name</label>
					  <span class="help-block"><?php echo $module_name_err; ?></span>
					</div>
				</div>
				</div>
				</div>

					<div class="form-group">
					<div class="form-row">
				
						  <div class="col-md-3">
							<div class="form-label-group" >
							  <input type="text" name="emp_id1" id="emp_id1" class="form-control <?php echo (!empty($emp_id1_err)) ? 'has-error' : ''; ?>" placeholder="Employee ID 1" value="<?php echo $emp_id1; ?>" required="required">
							  <label for="emp_id1">Employee ID 1/ Leader ID</label>
							  <span class="help-block"><?php echo $emp_id1_err;?></span>
							</div>
						  </div>
						  <div class="col-md-2">
							<div class="form-label-group">
							  <input type="text" name="emp_id2" id="emp_id2" class="form-control <?php echo (!empty($emp_id2_err)) ? 'has-error' : ''; ?>" placeholder="Employee ID 2" value="<?php echo $emp_id2; ?>" required="required">
							  <label for="emp_id2">Employee ID 2</label>
							  <span class="help-block"><?php echo $emp_id2_err;?></span>
							</div>
						  </div>
						  
						  <div class="col-md-2">
							<div class="form-label-group">
							  <input type="text" name="emp_id3" id="emp_id3" class="form-control <?php echo (!empty($emp_id3_err)) ? 'has-error' : ''; ?>" placeholder="Employee ID 3" value="<?php echo $emp_id3; ?>" required="required">
							  <label for="emp_id3">Employee ID 3</label>
							  <span class="help-block"><?php echo $emp_id3_err;?></span>
							</div>
						  </div>
						  
						  <div class="col-md-2">
							<div class="form-label-group">
							  <input type="text" name="emp_id4" id="emp_id4" class="form-control <?php echo (!empty($emp_id4_err)) ? 'has-error' : ''; ?>" placeholder="Employee ID 4" value="<?php echo $emp_id4; ?>" required="required">
							  <label for="emp_id4">Employee ID 4</label>
							  <span class="help-block"><?php echo $emp_id4_err;?></span>
							</div>
						  </div>
						  
						  <div class="col-md-2">
							<div class="form-label-group">
							  <input type="text" name="emp_id5" id="emp_id5" class="form-control <?php echo (!empty($emp_id5_err)) ? 'has-error' : ''; ?>" placeholder="Employee ID 5" value="<?php echo $emp_id5; ?>" required="required">
							  <label for="emp_id5">Employee ID 5</label>
							  <span class="help-block"><?php echo $emp_id5_err;?></span>
							</div>
						  </div>
            </div>
          </div>					
				
                    
                <div class="form-group">
					    <input type="submit" class="btn btn-primary" value="Submit">
                        <input type="reset" class="btn btn-default" value="Reset">
                        <a href="dashboard.php" class="btn btn-default">Cancel</a>
				</div>
                       
            
        </div>
    </div>
            </div>
		</div>
		
		<?php include('emptableview.php'); ?>
		    <!-- AdminTable Example -->
			<?php include('projecttableview.php'); ?>

					
		
		<div class="card mb-3">
			<div class="card-header">
			Login date and time :
				<?php
					$date=date_create();
					echo date_format($date,"Y-m-d H:i:s");
				?>
			</div>		
      </div>
      <!-- /.container-fluid -->


    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

          <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Your Website 2019</span>
          </div>
        </div>
      </footer>

  
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>


      

  

</body>

