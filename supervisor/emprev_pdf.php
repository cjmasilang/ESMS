<?php
require('../fpdf/fpdf.php');
include '../includes/config.php';
spl_autoload_register(function($classes){

    include '../classes/'.$classes.".php";
  
  });
  
  class PDF extends FPDF
  {
  
  function LoadData()
  {
      $items = new Employee_evaluation_items();
      $form = new Employee_evaluation_form();
      $user = new Users();
  
      $data = [];
      $data['user1'] = $user->view($_POST['employee_id']);
      $checklist = $form->viewByUser($_POST['employee_id'],$_POST['month'],$_POST['date']);
      $groups = $items->view();
  
      foreach($checklist as $checkl){
          foreach($groups as $group){
                      $deets = $form->viewDetailsWithItem($checkl->id,$group->id);
                      if(!isset($data['user2'])){
                          $data['user2'] = $user->view($checkl->evaluator_id);
                      }
                      $data['table'][$checkl->id]['details'] = ['id'=> $group->id, 'rating' => $deets->rating, 'date'=> $checkl->created_at] ;
          }
      }
      return $data;
  }
  
  // Simple table
  function BasicTable($header, $data)
  {
      $user = new Users();
  
  
      $items = new Employee_evaluation_items();
      $groupies = $items->get_category_groups();
      $this->Cell(40,7,'5 - Excellent',0,0,'L');
      $this->Cell(40,7,'4 - Very Good',0,0,'L');
      $this->Cell(30,7,'3 - Good',0,0,'L');
      $this->Cell(60,7,'2 - Need Improvement',0,0,'L');
      $this->Cell(70,7,'1 - Poor',0,0,'L');
      $this->Ln();
      $this->Ln();
  
      $this->Cell(100,7,'Name of Employer: '.$data['user1']->name,0,0,'L');
      $this->Ln();
      $this->Cell(100,7,'Name of Evaluator: '.$data['user2']->name,0,0,'L');
      $this->Ln();
      $this->Ln();
  
  
      $user = new Users();
  
      $groups = $items->view();
  
      foreach($groupies as $g){
                          $this->Cell(115,7,$g->category,1,0,'L');
          $this->Ln();
  
      $this->Cell(40,7,'Date:',1);
          foreach($data['table']  as $checkl){
                  $this->Cell(25,7,date('m-d-y',strtotime($checkl['details']['date'])),1,0,'C');
          }
      $this->Ln();
          foreach($groups as $group){
              if($group->category == $g->category){
                  $this->Cell(40,7,$group->item_name,1,0,'L');
  
                  foreach($data['table'] as $checkl){
                      if($group->id == $checkl['details']['id']){
                              $this->Cell(25,7,$checkl['details']['rating'],1,0,'C');
                      }else{
                              $this->Cell(25,7,'_',1,0,'C');
                      }
                  }
              $this->Ln();
              }
          }
  
      }
  
      // Data
      // foreach($data as $row)
      // {
      //     foreach($row as $col)
      //         $this->Cell(40,6,$col,1);
      //     $this->Ln();
      // }
  
  }
  
  // Better table
  function ImprovedTable($header, $data)
  {
      // Column widths
      $w = array(40, 35, 40, 45);
      // Header
      for($i=0;$i<count($header);$i++)
          $this->Cell($w[$i],7,$header[$i],1,0,'C');
      $this->Ln();
      // Data
      foreach($data as $row)
      {
          $this->Cell($w[0],6,'test','LR');
          $this->Cell($w[1],6,'test','LR');
          $this->Cell($w[2],6,'test','LR',0,'R');
          $this->Cell($w[3],6,'test','LR',0,'R');
          $this->Ln();
      }
      // Closing line
      $this->Cell(array_sum($w),0,'','T');
  }
  
  // Colored table
  function FancyTable($header, $data)
  {
      // Colors, line width and bold font
      $this->SetFillColor(255,0,0);
      $this->SetTextColor(255);
      $this->SetDrawColor(128,0,0);
      $this->SetLineWidth(.3);
      $this->SetFont('','B');
      // Header
      $w = array(40, 35, 40, 45);
      for($i=0;$i<count($header);$i++)
          $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
      $this->Ln();
      // Color and font restoration
      $this->SetFillColor(224,235,255);   
      $this->SetTextColor(0);
      $this->SetFont('');
      // Data
      $fill = false;
      foreach($data as $row)
      {
          $this->Cell($w[0],6,'test','LR',0,'L',$fill);
          $this->Cell($w[1],6,'test','LR',0,'L',$fill);
          $this->Cell($w[2],6,'test','LR',0,'R',$fill);
          $this->Cell($w[3],6,'test','LR',0,'R',$fill);
          $this->Ln();
          $fill = !$fill;
      }
      // Closing line
      $this->Cell(array_sum($w),0,'','T');
  }
  }
  
  $pdf = new PDF();
  // Column headings
  $header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
  // Data loading
  $data = $pdf->LoadData();
  $pdf->SetFont('Arial','',14);
  $pdf->AddPage();
  $pdf->BasicTable($header,$data);
  // $pdf->AddPage();
  // $pdf->ImprovedTable($header,$data);
  // $pdf->AddPage();
  // $pdf->FancyTable($header,$data);
  $pdf->Output();
  ?>
  