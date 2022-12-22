<?php
// Session::CheckLogin();
include '../includes/config.php';
include_once '../lib/database.php';

?>

<?php
spl_autoload_register(function($classes){

  include '../classes/'.$classes.".php";

});

$user = new Users();
$items = new Employee_evaluation_form();

$logout = Session::get('logout');
if (isset($logout)) {
  echo $logout;
}
 ?>

 <?php include dirname(__FILE__).'\settings\includes\header.php';?>


<div class="card ">
  <div class="card-header">
          <h3 class='text-center'>Employee Evaluation</h3>
        </div>
        <div class="card-body">
          <div class='row'>
              <div class='col-1 pr-0'>
                  <label class='mt-1'>Month:</label>
              </div>
              <div class='col-2 pl-0 pr-0'>        
                  <select name="month" class='form-control' size='1'>
                      <?php
                      for ($i = 0; $i < 12; $i++) {
                          $time = strtotime(sprintf('%d months', $i));   
                          $label = date('F', $time);   
                          $value = date('n', $time);
                          echo "<option value='$value'>$label</option>";
                      }
                      ?>
                  </select>
              </div>
              <div class='col-1 pr-0'>
                  <label class='mt-1'>Year:</label>
              </div>
              <div class='col-2 pl-0'>        
                  <input type="number" name="date" class='form-control' min='2022' max="<?=date('Y')?>" value="<?=date('Y')?>">
              </div>
              <div class='col-4 pl-0'>        
                  <a href='#' class="btn btn-primary btn-filter">Filter</a>
                  <!-- Button trigger modal -->
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                    Generate PDF
                  </button>
              </div>

              <div class='col-2'>          
                  <a type="button" class="btn btn-sm btn-primary mb-4" href='add_emp_evaluation.php' style='float:right'><i class='fa fa-plus'></i> Add Evaluation</a>
              </div>
          </div>
          <!-- Modal -->
              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Generate PDF</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  <form method="post" action="../report/empev_pdf.php">
                    <div class="modal-body">
                                <div class="row">
                                  <div class='col-12'>       
                                      <label class='mt-1'>Month:</label>      
                                      <select name="month" class='form-control' size='1'>
                                          <?php
                                          for ($i = 0; $i < 12; $i++) {
                                              $time = strtotime(sprintf('%d months', $i));   
                                              $label = date('F', $time);   
                                              $value = date('n', $time);
                                              echo "<option value='$value'>$label</option>";
                                          }
                                          ?>  
                                      </select>
                                  </div>
                                  <div class='col-12'>
                                      <label class='mt-1'>Year:</label>      
                                      <input type="number" name="date" class='form-control' min='2022' max="<?=date('Y')?>" value="<?=date('Y')?>">
                                  </div>
                                  <div class='col-12'>
                                      <label class='mt-1'>Employee:</label>      
                                      <select name="employee_id" class="form-control">
                                                <option></option>
                                                <?php 
                                                  $userz = $user->selectEmployeeUsers();
                                                  foreach($userz as $u){
                                                ?>
                                                  <option value='<?=$u->id?>'><?=$u->fname.' '.$u->lname?></option>
                                                <?php
                                                  }
                                                ?>
                                              </select>
                                  </div>
                                </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <input type='submit' class="btn btn-danger btn-filter" name="btn_generate" value="Generate PDF">
                    </div>
                  </form>
                  </div>
                </div>
              </div>
              <table id="table">
                <thead>
                  <tr>
                    <td>Employee</td>
                    <td>Overall Rating</td>
                    <td>Date Created</td>
                    <td>Action</td>
                  </tr>
                </thead>
                <tbody>
                  <?php

                      $itemz = $items->view();

                      if ($itemz) {
                        $i = 0;
                        foreach ($itemz as  $value) {
                          $i++;
                          $user = new Users();
                          $u = $user->view($value->employee_id);
                     ?>
                  <tr>
                    <td><?=$u->fname.' '.$u->lname?></td>
                    <td><?=$items->getTotalbyEvaluationId($value->id)[0]->total?></td>
                    <td><?=$value->created_at?></td>
                    <td>
                      <a href="view_emp_evaluation.php?id=<?=$value->id?>" class="btn btn-info btn-sm view">View</a>                 
                      <!-- <a href="#" class="btn btn-warning btn-sm view" data-id="<?=$value->id?>">Update</a>                  -->
                      <!-- <a href="#" class="btn btn-danger btn-sm delete"  data-id=<?=$value->id?>>Generate PDF</a>                  -->
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
  <?php
  include 'footer.php';

  ?>
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

  table.column(2)
        .search(moment(month+'/01/'+year).format('YYYY-MM')).draw();
}

$('.btn-filter').click(function(){
  filterDtb();
});

  $('.save').on('click', function(){

 var form = $('#formSetting').serialize();
      $.ajax({
            url: 'add_item.php',
            data: form,
            type: "POST",
            dataType: "text",
            success: function(data) {
              Swal.fire(
                'Success!',
                'You have successfully added an item',
                'success'
              )
              setTimeout(
                function() 
                  {
                    location.reload();
                  }, 4000);
            }
          });
  });

  $('.view').on('click', function(){

 var form = $('#formUpdateSetting').serialize();
      $.ajax({
            url: 'view_item.php',
            data: {'id':$(this).data('id')},
            type: "POST",
            dataType: "text",
            success: function(data) {
              $('#exampleModal2').modal();
              $('.modal-body-update').html(data);
          }
        });
  });

   $('.update').on('click', function(){

 var form = $('#formUpdateSetting').serialize();
      $.ajax({
            url: 'update_item.php',
            data: form,
            type: "POST",
            dataType: "text",
            success: function(data) {
              Swal.fire(
                'Success!',
                'You have successfully updated an item',
                'success'
              )
              setTimeout(
                function() 
                  {
                    location.reload();
                  }, 4000);
            }
          });
  });

    $('.delete').on('click', function(){

    var id = $(this).data('id');

 Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then(function(result) {
  if (result.isConfirmed) {
    $.ajax({
          url: 'delete_item.php', 
          type: "POST",
          data: {'id':id},
          dataType: "text",
          success: function(data) {
            Swal.fire(
              'Success!',
              'You have successfully deleted an item',
              'success'
            )
            setTimeout(
              function() 
                {
                  location.reload();
                }, 1500);
          }
        });
  }
})

  });
  </script>