<?php
 
session_start();
 

if(isset($_SESSION["emploggedin"]) && $_SESSION["emploggedin"] === true){
  header("location: empdashboard.php");
  exit;
}



require_once "config.php";
 

$username = $password = "";
$username_err = $password_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
 

    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    

    if(empty($username_err) && empty($password_err)){

        $sql = "SELECT emp_id, username, password FROM employee WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){

            mysqli_stmt_bind_param($stmt, "s", $param_username);
            

            $param_username = $username;
            

            if(mysqli_stmt_execute($stmt)){
                
                mysqli_stmt_store_result($stmt);
                
                
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                
                    mysqli_stmt_bind_result($stmt, $emp_id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                
        
                  

            if(mysqli_stmt_execute($stmt)){
                
                mysqli_stmt_store_result($stmt);
                            session_start();
                                            
                            $_SESSION["emploggedin"] = true;
                            $_SESSION["emp_id"] = $emp_id;
                            $_SESSION["username"] = $username;                            
                      
                        header("location: empdashboard.php");
                
                        }  } else{
                
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }      
        mysqli_stmt_close($stmt);
    }
    

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

  <title>Employee Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">
<body id="page-top">
	<?php include('indexnav.php'); ?>
	
	<div id="wrapper">
	
		<?php include('indexsidebar.php'); ?>


  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Employee Login Or <a href="login.php">Admin Login</a></div>
      <div class="card-body">
	  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
             <div class="form-group">
		
			<div class="form-label-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
		        <input type="text" name="username" id="username" class="form-control" placeholder="project_name" value="<?php echo $username; ?>" required="required" autofocus="autofocus">
				<label for="username">Username</label>
				<span class="help-block"><?php echo $username_err; ?></span>
			</div>
		
	  </div>
				
		<div class="form-group">
		
			<div class="form-label-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
		        <input type="password" name="password" id="password" class="form-control" placeholder="Password" value="<?php echo $password; ?>" required="required">
				<label for="password">Password</label>
				<span class="help-block"><?php echo $password_err; ?></span>
			</div>
		
		</div>	
     
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" value="remember-me">
                Remember Password
              </label>
            </div>
          </div>
		   <div class="form-group">
                <input class="btn btn-primary btn-block" type="Submit" class="btn btn-primary" value="Login">
            </div>
        </form>
        <div class="text-center">
          <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>
  


  

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
