<?php
// include '../includes/config.php';
spl_autoload_register(function($classes){

  include '../classes/'.$classes.".php";

});

$items = new Monitoring_checklist_items();

$item = $items->viewOne($_POST['id'])?>


<div class="form-group">
                <label for="item">Item Name</label>
                <input type="text" class="form-control" id="item" name='item'  value="<?=$item->item_name?>" placeholder="Item Name">
                <input type="hidden" class="form-control" name="id"  value="<?=$item->id?>">
              </div>
              <div class="form-group">
                <label for="category">Category</label>
                <input type="text" class="form-control" id="category" name='category'  value="<?=$item->category?>" placeholder="Category">
              </div>

