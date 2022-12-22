<?php
include '../includes/config.php';

// Session::CheckLogin();
?>

<?php
spl_autoload_register(function($classes){

  include '../classes/'.$classes.".php";

});

$items = new Employee_evaluation_items();
$form = new Employee_evaluation_form();
$user = new Users();
$checklist = $form->viewOne($_GET['id']);
$user1 = $user->view($checklist->employee_id);
$logout = Session::get('logout');
if (isset($logout)) {
  echo $logout;
}
 ?>
 
<style type="text/css">
  input[type="text"], textarea {

  background-color : #d1d1d1; 

}
</style>
 <?php include dirname(__FILE__).'\settings\includes\header.php';?>

<div class="card ">
  <form action="add_emp_evaluation.php" method="POST">
  <div class="card-header">
          <h3 class='text-center'>View Employee Evaluation</h3>
  </div>
      <a href="employee_evaluation.php"><i class="fa fa-arrow-left"></i>Back</a>
  <div class="card-body" style="overflow-y: scroll;">
    <div class='form-inline mb-2'>
      <br>
      <div class='row'>
        <div class='col-6'>
          <div class='row '>
            <div class='col-4'>
              <label class='pt-2'>Employee:</label>
            </div>
            <div class='col-6 mb-2'>
              <input value="<?= $user1->fname.' '.$user1->lname ?>" class="form-control" readonly>
            </div>
          </div>
        </div>
        <div class='col-6'>
          <div class="row">
            <div class='col-4'>
              <label class='pt-2' >Date:</label>
            </div>
            <div class='col-4'>
              <input value="<?php echo $checklist->created_at ?>" class="form-control" readonly>
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
        <td >TASK (<?=$group->category?>)</td>
        <td width="50%">Rating</td>
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
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="check[<?= $item->id ?>]" id="inlineRadio<?= $item->id ?>1" <?= $deets->rating == '1' ? 'checked="checked"' : '' ?> onclick="return false">
              <label class="form-check-label" for="inlineRadio<?= $item->id ?>1">1</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="check[<?= $item->id ?>]" id="inlineRadio<?= $item->id ?>2" <?= $deets->rating == '2' ? 'checked="checked"' : '' ?> onclick="return false">
              <label class="form-check-label" for="inlineRadio<?= $item->id ?>2">2</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="check[<?= $item->id ?>]" id="inlineRadio<?= $item->id ?>3" <?= $deets->rating == '3' ? 'checked="checked"' : '' ?> onclick="return false">
              <label class="form-check-label" for="inlineRadio<?= $item->id ?>3">3</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="check[<?= $item->id ?>]" id="inlineRadio<?= $item->id ?>4" <?= $deets->rating == '4' ? 'checked="checked"' : '' ?> onclick="return false">
              <label class="form-check-label" for="inlineRadio<?= $item->id ?>4">4</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="check[<?= $item->id ?>]" id="inlineRadio<?= $item->id ?>5" <?= $deets->rating == '5' ? 'checked="checked"' : '' ?> onclick="return false">
              <label class="form-check-label" for="inlineRadio<?= $item->id ?>4">5</label>
            </div>
          </td>
        </tr>
        <?php
          }
      ?>

      <?php
        }
      ?>
    </table>   
    <div class='row '>
            <div class='col-6'>
                  <div class='row '>
                          <div class='col-6'>
                            <label class='pt-2'>Opening Manager On Duty:</label>
                          </div>
                          <div class='col-6 mb-2'>
                            <input type="text" name="opening_manager" class='form-control' readonly value="<?php echo $checklist->opening_manager ?>">
                          </div>
                          <div class='col-6'>
                            <label class='pt-2'>Closing Manager On Duty:</label>
                          </div>
                          <div class='col-6'>
                            <input type="text" name="closing_manager" class='form-control' readonly value="<?php echo $checklist->closing_manager ?>">
                          </div>
                  </div>
            </div>
    </div>
  </div>
  <div class='card-footer'>
  </div>
  </form>
</div>

<?php include('../includes/footer.php');?>

<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script type="text/javascript">
    var now = new Date();

    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);

    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

    $('input[name=date_evaluated]').val(today);
  </script>