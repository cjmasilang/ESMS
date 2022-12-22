<?php
require('../fpdf/fpdf.php');
include '../includes/config.php';
spl_autoload_register(function($classes){

  include '../classes/'.$classes.".php";

});

class PDF extends FPDF
{

// Simple table
function BasicTable()
{
    // Header

    $items = new Monitoring_checklist_items();
    $form = new Monitoring_checklist_form();

    $checklist = $form->viewOne($_GET['id']);
        $user = new Users();
        $user1 = $user->view($checklist->shift_manager);
        $this->Cell(100,7,'Manager on Duty: '.$user1->fname.' '.$user1->lname,0);
        $this->Cell(60,7,'Date:'.$checklist->created_at,0);
        $this->Ln();
        $this->Ln();

            $groups = $items->get_category_groups();
            foreach($groups as $group){

        $this->Cell(85,7,$group->category,1);
        $this->Cell(20,7,'AM',1);
        $this->Cell(20,7,'PM',1);
        $this->Cell(60,7,'REMARKS',1);
        $this->Ln();

            $lists = $items->view_by_categ($group->category);
              foreach($lists as $item){   
                $deets = $form->viewDetailsWithItem($checklist->id,$item->id);

                $this->Cell(85,7,$item->item_name,1);
                $this->Cell(20,7,isset($deets->am) ? 'O' : '',1);
                $this->Cell(20,7,isset($deets->pm) ? 'O' : '',1);
                $this->Cell(60,7,isset($deets->remarks) ? $deets->remarks : '',1);
                $this->Ln();
              }
                $this->Ln();

            }

}
}

$pdf = new PDF();
// Column headings
$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
// Data loading
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->BasicTable();
// $pdf->AddPage();
// $pdf->ImprovedTable($header,$data);
// $pdf->AddPage();
// $pdf->FancyTable($header,$data);
$pdf->Output();
?>
