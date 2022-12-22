<?php
// include '../includes/sidebar.php';
include_once '../includes/config.php';
include_once '../lib/session.php';
// Session::CheckLogin();
?>

<?php
spl_autoload_register(function($classes){

  include '../classes/'.$classes.".php";

});

$items = new Employee_evaluation_items();

$logout = Session::get('logout');
if (isset($logout)) {
  echo $logout;
}
 ?>
 <?php include dirname(__FILE__).'\settings\includes\header.php';?>

<div class="card ">
  <div class="card-header">
          <h3 class='text-center'>Employee Evaluation List</h3>
        </div>
        <div class="card-body">
          <button type="button" class="btn btn-sm btn-primary mb-4" data-toggle="modal" data-target="#exampleModal" style='float:right'><i class='fa fa-plus'></i>Add List</button>
              <table id="table">
                <thead>
                  <tr>
                    <td>Item Name</td>
                    <td>Category</td>
                    <td>Date Added</td>
                    <td>Action</td>
                  </tr>
                </thead>
                <tbody>
                  <?php

                      $items = $items->view();

                      if ($items) {
                        $i = 0;
                        foreach ($items as  $value) {
                          $i++;

                     ?>
                  <tr>
                    <td><?=$value->item_name?></td>
                    <td><?=$value->category?></td>
                    <td><?=$value->created_at?></td>
                    <td>
                      <a href="#" class="btn btn-success btn-sm view" data-id="<?=$value->id?>">Update</a>                 
                      <a href="#" class="btn btn-danger btn-sm delete"  data-id=<?=$value->id?>>Delete</a>                 
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Setting</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <form id="formSetting">
        <div class="modal-body">
            <div class="form-group">
                <label for="item">Item Name</label>
                <input type="text" class="form-control" id="item" name='item' placeholder="Item Name">
              </div>
              <div class="form-group">
                <label for="category">Category</label>
                <input type="text" class="form-control" id="category" name='category' placeholder="Category">
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary save">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
          </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Setting</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <form id="formUpdateSetting">
        <div class="modal-body modal-body-update">
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary update">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
          </form>
      </div>
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
  <script type="text/javascript">
      $('#table').dataTable();

  $('.save').on('click', function(){

 var form = $('#formSetting').serialize();
      $.ajax({
            url: 'add_item_v2.php',
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
                  }, 1500);
            }
          });
  });

  $('.view').on('click', function(){

 var form = $('#formUpdateSetting').serialize();
      $.ajax({
            url: 'view_item_v2.php',
            data: {'id':$(this).data('id')},
            type: "POST",
            dataType: "text",
            success: function(data) {
              $('#exampleModal2').modal('show');
              $('.modal-body-update').html(data);
          }
        });
  });

   $('.update').on('click', function(){

 var form = $('#formUpdateSetting').serialize();
      $.ajax({
            url: 'update_item_v2.php',
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
          url: 'delete_item_v2.php', 
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