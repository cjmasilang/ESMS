<?php
spl_autoload_register(function($classes){

  include '../classes/'.$classes.".php";

});

$items = new Monitoring_checklist_items();

echo $items->delete($_POST['id']);

