<?php
// Initialize the session
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE admin SET password = ? WHERE adm_id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: Dashboard.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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

  <title>Admin Reset Password</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

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
          <li class="breadcrumb-item active">Reset Password</li>
		  
        </ol>        

	
		<!-- AdminTable Example -->

        <div class="card mb-3">
		<div class="card-header">Reset Password</div>
          <div class="card-body">
            <div class="form-responsive">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
							
				<div class="form-group">
				<div class="form-row">
				<div class="col-md-6">
					<div class="form-label-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
					  <input type="password" name="new_password" id="inputPassword" class="form-control" placeholder="Password" value="<?php echo $new_password; ?>" required="required">
					  <label for="inputPassword">New Password</label>
					  <span class="help-block"><?php echo $new_password_err; ?></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-label-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
					  <input type="password" name="confirm_password" id="inputPassword" class="form-control" placeholder="Password" value="<?php echo $confirm_password; ?>" required="required">
					  <label for="inputPassword">Confirm Password</label>
					  <span class="help-block"><?php echo $confirm_password_err; ?></span>
					</div>
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
		
		    
					
		
      <!-- /.container-fluid -->


    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->
