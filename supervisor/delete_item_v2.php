<?php
spl_autoload_register(function($classes){

  include '../classes/'.$classes.".php";

});

$items = new Employee_evaluation_items();

echo $items->delete($_POST['id']);

