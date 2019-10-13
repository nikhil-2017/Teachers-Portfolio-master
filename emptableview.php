<!-- EmpTable Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            EMPLOYEE Table / <a href="empcreate.php">ADD NEW EMPLOYEE</a></div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<?php include('employeetable.php'); ?>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>