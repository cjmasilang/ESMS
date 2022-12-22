<?php
// include '../includes/config.php';
// Session::CheckLogin();
?>

<?php
spl_autoload_register(function($classes){

  include '../classes/'.$classes.".php";

});

$items = new Monitoring_checklist_items();
$form = new Monitoring_checklist_form();

$checklist = $form->viewOne($_GET['id']);

// $logout = Session::get('logout');
if (isset($logout)) {
  echo $logout;
}
 ?>
 <?php include dirname(__FILE__).'\settings\includes\header.php';?>

<div class="card ">
  <div class="card-header">
          <h3 class='text-center'>View Shift Monitoring</h3>
  </div>
  <div class="card-body" style="overflow-y: scroll;">
    <a href="evaluation.php"><i class='fa fa-arrow-left'></i>Back</a>
    <div class='form-inline mb-2'>
      <div class='row'>
        <div class='col-6'>
          <div class="row">
            <div class='col-6'>
              <label class='pt-2'>Date:</label>
            </div>
            <div class='col-6'>
              <input name="date_evaluated" class='form-control' disabled value='<?= $checklist->created_at?>'>
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
            $deets = $form->viewDetailsWithItem($checklist->id,$item->id);
        ?>
        <tr>
            <input type="hidden" name="id[<?=$item->id?>]" value="<?=$item->id?>">

          <td><?=$item->item_name?></td>
          <td>
            <input type="checkbox" name="am[<?=$item->id?>]" disabled='disabled' <?= isset($deets->am) ? 'checked' : '' ?>>
          </td>
          <td>
            <input type="checkbox" name="pm[<?=$item->id?>]" disabled='disabled' <?= isset($deets->pm) ? 'checked' : '' ?>>
          </td>
          <td>
            <textarea name="remarks[<?=$item->id?>]" class='form-control' readonly> <?= isset($deets->remarks) ? $deets->remarks : '' ?> </textarea>
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
</div>
  </main>
             <?php include_once('../includes/footer.php'); ?>
<?php include('footer.php');?>

  <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script type="text/javascript">
  </script>