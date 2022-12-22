<?php
// include '../includes/sidebar.php';
include '../includes/config.php';
// Session::CheckLogin();
?>


<?php
spl_autoload_register(function($classes){

  include '../classes/'.$classes.".php";

});

$user = new Users();
$items = new Employee_evaluation_form();

// $logout = Session::get('logout');
if (isset($logout)) {
  echo $logout;
}
 ?>
 <?php include dirname(__FILE__).'\settings\includes\header.php';?>
<div class="card ">
        <div class="card-body">

  <h1 class="mt-4">Dashboard</h1>
                            <?php
                            $query=mysqli_query($con,"select id from users");
                            $totalusers=mysqli_num_rows($query);

                            $query=mysqli_query($con,"select id from employee_evaluation_form WHERE evaluator_id = {$_SESSION['id']}");
                            $totaleval=mysqli_num_rows($query);

                            $query=mysqli_query($con,"select id from shift_monitoring_checklist WHERE shift_manager = {$_SESSION['id']}");
                            $totalmon=mysqli_num_rows($query);

                            //get high rank
                            $query=mysqli_query($con, "SELECT max(rating) ,evaluation_form_id from (SELECT AVG(rating) as rating , evaluation_form_id FROM employee_evaluation_details where date(created_at) = date(NOW()) GROUP BY evaluation_form_id) as egg");
                            $item=mysqli_fetch_row($query);

                            if($item[0]){
                            $query=mysqli_query($con,"select employee_id from employee_evaluation_form WHERE id = {$item[1]}");
                            $item=mysqli_fetch_row($query);
                            $query=mysqli_query($con,"select lname,fname from users WHERE id = {$item[0]} limit 1");
                            $emp=mysqli_fetch_row($query);
                            }

                            ?>

                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Employee of the day: 
                                        <span style="font-size:22px;"> <?php echo $item[0] ? $emp[1].' '.$emp[0] : 'None';?></span></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Total Registered Users 
                                        <span style="font-size:22px;"> <?php echo $totalusers;?></span></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="manage-users.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Monitoring Reports 
                                        <span style="font-size:22px;"> <?php echo $totalmon;?></span></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="evaluation.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Employee Reports 
                                        <span style="font-size:22px;"> <?php echo $totaleval;?></span></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="employee-evaluation.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
               </main>
             <?php include_once('../includes/footer.php'); ?>
            </div>
            </div>
        </div>
 <?php   include 'footer.php'; ?>
  <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script type="text/javascript">

  </script>