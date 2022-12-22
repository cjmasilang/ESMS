<?php
// include '../includes/sidebar.php';

// Session::CheckLogin();
?>


<?php
spl_autoload_register(function($classes){

  include '../classes/'.$classes.".php";

});

$items = new Monitoring_checklist_items();

if($_POST){
$form = new Monitoring_checklist_form();

  if($form->add($_POST)){
    $_SESSION['msg'] = 'Successfully added evaluation';
    header('Location: evaluation.php');
  }
}

// $logout = Session::get('logout');
if (isset($logout)) {
  echo $logout;
}
 ?>
 <?php include dirname(__FILE__).'\settings\includes\header.php';?>

<div class="card ">
  <form action="add_evaluation.php" method="POST">
  <div class="card-header">
          <h3 class='text-center'>Add Shift Monitoring</h3>
  </div>
  <div class="card-body" style="overflow-y: scroll;">
    <div class='form-inline mb-2'>
      <div class='row'>
        <div class='col-4 pt-2'>
      <a href="evaluation.php"><i class="fa fa-arrow-left"></i>Back</a>
        </div>
        <div class='col-6'>
          <div class="row">
            <div class='col-6'>
              <label class='pt-2'>Date:</label>
            </div>
            <div class='col-6'>
              <input type="date" name="date_evaluated" class='form-control'>
            </div>
          </div>
        </div>
      </div>
    </div>

    <table class="table table-bordered">
      <?php
        $groups = $items->get_category_groups();
        foreach($groups as $group){
        ?>
      <tr class="bg-dark text-white">
        <td>TASK (<?=$group->category?>)</td>
        <td width=10>AM</td> 
        <td width=10>PM</td>
        <td>REMARKS</td>
      </tr>
        <?php
        $lists = $items->view_by_categ($group->category);
          foreach($lists as $item){   
        ?>
        <tr>
            <input type="hidden" name="id[<?=$item->id?>]" value="<?=$item->id?>">

          <td><?=$item->item_name?></td>
          <td>
            <input type="checkbox" name="am[<?=$item->id?>]" value='1'>
          </td>
          <td>
            <input type="checkbox" name="pm[<?=$item->id?>]" value='1'>
          </td>
          <td>
            <textarea name="remarks[<?=$item->id?>]" class='form-control'></textarea>
          </td>
        </tr>
        <?php
          }
      ?>

      <?php
        }
      ?>
    </table>
          
  </div>
  <div class='card-footer'>
    <button class='btn btn-primary' type="submit" style="float:right">
      Save    
    </button>
  </div>
  </form>
</div>
  </main>
             <?php include_once('../includes/footer.php'); ?>
  <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script type="text/javascript">

  </script>