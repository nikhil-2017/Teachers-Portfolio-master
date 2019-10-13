<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$fname = $lname = $department = $email = $username = $password = $confirm_password = "";
$fname_err = $lname_err =  $department_err = $email_err = $username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $input_fname = trim($_POST["fname"]);
    if(empty($input_fname)){
        $fname_err = "Please enter a name.";     
    }
    else{
        $fname = $input_fname;
    }
	
	$input_lname = trim($_POST["lname"]);
    if(empty($input_lname)){
        $lname_err = "Please enter a name.";     
    }
    else{
        $lname = $input_lname;
    }
    
    $input_department = trim($_POST["department"]);
    if(empty($input_department)){
        $department_err = "Please enter department name.";     
    } 
    else{
        $department = $input_department;
    }
    
   $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter an email.";
    } else{
        $email = $input_email;
    }

        // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT adm_id FROM admin WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($fname_err) && empty($lname_err) && empty($department_err) && empty($email_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO admin (fname, lname, department, email, username, password) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            
            mysqli_stmt_bind_param($stmt,"ssssss",$param_fname, $param_lname ,$param_department, $param_email, $param_username, $param_password);
            
            // Set parameters
            $param_fname = $fname;
			$param_lname = $lname;
            $param_department = $department;
            $param_email = $email;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: admincreate.php");
                exit();
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

  <title>AdminCreate</title>

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
          <li class="breadcrumb-item active">Create New Admin</li>
		  
        </ol>        

	
		<!-- AdminTable Example -->

        <div class="card mb-3">
		<div class="card-header">Create New Admin</div>
          <div class="card-body">
            <div class="form-responsive">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<div class="form-group">
					<div class="form-row">
						  <div class="col-md-6">
							<div class="form-label-group" >
							  <input type="text" name="fname" id="firstName" class="form-control <?php echo (!empty($fname_err)) ? 'has-error' : ''; ?>" placeholder="First name" value="<?php echo $fname; ?>" required="required" autofocus="autofocus">
							  <label for="firstName">First name</label>
							  <span class="help-block"><?php echo $fname_err;?></span>
							</div>
						  </div>
						  <div class="col-md-6">
							<div class="form-label-group">
							  <input type="text" name="lname" id="lastName" class="form-control <?php echo (!empty($lname_err)) ? 'has-error' : ''; ?>" placeholder="Last name" value="<?php echo $lname; ?>" required="required" autofocus="autofocus">
							  <label for="lastName">Last name</label>
							  <span class="help-block"><?php echo $lname_err;?></span>
							</div>
						  </div>
            </div>
          </div>
		  
				<div class="form-group">
				<div class="form-row">
				<div class="col-md-6">
					<div class="form-label-group <?php echo (!empty($department_err)) ? 'has-error' : ''; ?>">
					  <input type="text" name="department" id="department" class="form-control" placeholder="Department" value="<?php echo $department; ?>" required="required">
					  <label for="department">Department</label>
					  <span class="help-block"><?php echo $department_err; ?></span>
					</div>
				</div>
				</div>
				</div>
		  
				<div class="form-group">
				<div class="form-row">
				<div class="col-md-6">
					<div class="form-label-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
					  <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>" required="required">
					  <label for="Email">Email</label>
					  <span class="help-block"><?php echo $email_err; ?></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-label-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
					  <input type="username" name="username" id="username" class="form-control" placeholder="Username" value="<?php echo $username; ?>" required="required">
					  <label for="username">Username</label>
					  <span class="help-block"><?php echo $username_err; ?></span>
					</div>
				</div>
				</div>
				</div>
					
				<div class="form-group">
				<div class="form-row">
				<div class="col-md-6">
					<div class="form-label-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
					  <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" value="<?php echo $password; ?>" required="required">
					  <label for="inputPassword">Password</label>
					  <span class="help-block"><?php echo $password_err; ?></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-label-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
					  <input type="password" id="confirmPassword" name="confirm_password" class="form-control" placeholder="Confirm password" value="<?php echo $confirm_password; ?>" required="required">
					  <label for="confirmPassword">Confirm password</label>
					  <span class="help-block"><?php echo $confirm_password_err; ?></span>
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
		
		    <!-- AdminTable Example -->
			<?php include('admintableview.php'); ?>

					
		
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

