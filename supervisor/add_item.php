<?php
spl_autoload_register(function($classes){

  include '../classes/'.$classes.".php";

});

$items = new Monitoring_checklist_items();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['item'])) {
  echo $items->add($_POST);
}
