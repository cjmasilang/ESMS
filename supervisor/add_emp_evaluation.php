<?php

?>

<?php
spl_autoload_register(function($classes){

  include '../classes/'.$classes.".php";

});

$items = new Employee_evaluation_items();
$user = new Users();

if($_POST){
$form = new Employee_evaluation_form();

  if($form->add($_POST)){
    $_SESSION['msg'] = 'Successfully added evaluation';
    header('Location: employee_evaluation.php');
  }
}

$logout = Session::get('logout');
if (isset($logout)) {
  echo $logout;
}
 ?>
 <?php include dirname(__FILE__).'\settings\includes\header.php';?>

<div class="card ">
  <form action="add_emp_evaluation.php" method="POST">
  <div class="card-header">
          <h3 class='text-center'>Add Employee Evaluation</h3>
  </div>
  <div class="card-body" style="overflow-y: scroll;">
    <div class='form-inline mb-2'>
      <div class='row'>
        <div class='col-2 pt-2'>
      <a href="employee_evaluation.php"><i class="fa fa-arrow-left"></i>Back</a>
        </div>
        <div class='col-6'>
          <div class='row '>
            <div class='col-6'>
              <label class='pt-2'>Employee:</label>
            </div>
            <div class='col-6 mb-2'>
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
        <div class='col-4'>
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
        <td >TASK (<?=$group->category?>)</td>
        <td width="50%">Rating</td>
      </tr>
        <?php
        $lists = $items->view_by_categ($group->category);
          foreach($lists as $item){   
        ?>
        <tr>
            <input type="hidden" name="id[<?=$item->id?>]" value="<?=$item->id?>">
          <td><?=$item->item_name?></td>
          <td>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="check[<?= $item->id ?>]" id="inlineRadio<?= $item->id ?>1" value="1">
              <label class="form-check-label" for="inlineRadio<?= $item->id ?>1">1</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="check[<?= $item->id ?>]" id="inlineRadio<?= $item->id ?>2" value="2"> 
              <label class="form-check-label" for="inlineRadio<?= $item->id ?>2">2</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="check[<?= $item->id ?>]" id="inlineRadio<?= $item->id ?>3" value="3">
              <label class="form-check-label" for="inlineRadio<?= $item->id ?>3">3</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="check[<?= $item->id ?>]" id="inlineRadio<?= $item->id ?>4" value="4">
              <label class="form-check-label" for="inlineRadio<?= $item->id ?>4">4</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="check[<?= $item->id ?>]" id="inlineRadio<?= $item->id ?>5" value="5">
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
                            <input type="text" name="opening_manager" class='form-control'>
                          </div>
                          <div class='col-6'>
                            <label class='pt-2'>Closing Manager On Duty:</label>
                          </div>
                          <div class='col-6'>
                            <input type="text" name="closing_manager" class='form-control'>
                          </div>
                  </div>
            </div>
    </div>
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
            </div>
        </div>
  <?php
  include 'footer.php';

  ?>
  <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script type="text/javascript">
    var now = new Date();

    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);

    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

    $('input[name=date_evaluated]').val(today);
  </script>