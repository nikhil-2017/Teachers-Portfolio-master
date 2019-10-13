<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["emploggedin"]) || $_SESSION["emploggedin"] !== true){
    header("location: emplogin.php");
    exit;
}

elseif(isset($_SESSION["emploggedin"]) && $_SESSION["emploggedin"] === true){
	if(isset($_SESSION["admloggedin"]) && $_SESSION["admloggedin"] !== true){
		header("location: login.php");
		exit;
	}
}


?>

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="dashboard.php">Teachers Portfolio</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      
    </form>
	
	<!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="setting.php">Settings</a>
		  <div class="dropdown-divider"></div>
		  <a class="dropdown-item" href="emplogout.php"> <?php echo htmlspecialchars($_SESSION["username"]); ?> : Logout </a>
        </div>
      </li>
    </ul>

  </nav>