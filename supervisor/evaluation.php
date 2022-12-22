<?php
// include '../includes/sidebar.php';
include '../includes/config.php';
// include_once '../lib/session.php';

// Session::CheckLogin();
?>

<?php
spl_autoload_register(function($classes){

  include '../classes/'.$classes.".php";

});

$items = new Monitoring_checklist_form();

// $logout = Session::get('logout');
if (isset($logout)) {
  echo $logout;
}
 ?>

 <?php include dirname(__FILE__).'\settings\includes\header.php';?>
<div class="card ">
  <div class="card-header">
          <h3 class='text-center'>Shift Monitoring Checklist</h3>
        </div>
        <div class="card-body">
          <div class='row'>
              <div class='col-1 pr-0'>
                  <label class='mt-1 pt-1'>Month:</label>
              </div>
              <div class='col-2 pl-0 pr-0'>        
                  <select name="month" class='form-control' size='1'>
                      <?php
                      for ($i = 0; $i < 12; $i++) {
                          $time = strtotime(sprintf('%d months', $i));   
                          $label = date('F', $time);   
                          $value = date('n', $time);
                          echo "<option value='".sprintf('%02d', $value)."'>$label</option>";
                      }
                      ?>
                  </select>
              </div>
              <div class='col-1 pr-0'>
                  <label class='mt-1 pt-1'>Year:</label>
              </div>
              <div class='col-2 pl-0'>        
                  <input type="number" name="date" class='form-control' min='2022' max="<?=date('Y')?>" value="<?=date('Y')?>">
              </div>
              <div class='col-2 pl-0'>        
                  <a href='#' class="btn btn-primary btn-filter">Filter</a>
              </div>
              <div class='col-4'>        
                  <a type="button" class="btn btn-sm btn-primary mb-4" href='add_evaluation.php' style='float:right'><i class='fa fa-plus'></i> Add Checklist</a>
              </div>
          </div>
              <table id="table">
                <thead>
                  <tr>
                    <td>Manager on Duty</td>
                    <td>Date and Time Created</td>
                    <td>Action</td>
                  </tr>
                </thead>
                <tbody>
                  <?php

                      $items = $items->view_user();

                      if ($items) {
                        $i = 0;
                        foreach ($items as  $value) {
                          $i++;

                     ?>
                  <tr>
                    <?php 
                      $user = new Users();
                      $user1 = $user->view($value->shift_manager);
                     ?>
                    <td><?=$user1->fname.' '.$user1->lname?></td>
                    <td><?=$value->created_at?></td>
                    <td>
                      <a href="view_evaluation.php?id=<?=$value->id?>" class="btn btn-info btn-sm view">View</a>                 
                      <!-- <a href="#" class="btn btn-warning btn-sm view" data-id="<?=$value->id?>">Update</a>                  -->
                      <a href="../report/monship_pdf.php?id=<?=$value->id?>" class="btn btn-danger btn-sm">Generate PDF</a>                 
                    </td>
                  </tr>
                <?php 
                    } 
                ?>
                </tbody>
                 <?php 
                    } 
                ?>
              </table>
              
        </div>
      </div>
  </main>
             <?php include_once('../includes/footer.php'); ?>
            </div>
        </div>
 <?php   include 'footer.php'; ?>

  <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script type="text/javascript">
    var table;
    $(document).ready(function(){
      table = $('#table').DataTable();
      filterDtb();
        
    });

function filterDtb(){
  var month = $('select[name=month]').find(":selected").val();
  var year = $('input[name=date]').val();

  table.column( 1 )
        .search(moment(month+'/01/'+year).format('YYYY-MM')).draw();
}

  </script>