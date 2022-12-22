<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
include_once dirname ( __DIR__ ) ."\includes\config.php";
include_once '../lib/database.php';

class Employee_evaluation_form{


  private $db;


  public function __construct(){
    $this->db = new Database();
  }

  public function view(){
    $sql = "SELECT * FROM employee_evaluation_form ORDER BY id DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }


  public function viewDetailsUserAll($id){
    $sql = "SELECT * FROM employee_evaluation_details  WHERE evaluation_form_id = '{$id}' ORDER BY id DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function viewByUser($id,$month,$year){
    $sql = "SELECT * FROM employee_evaluation_form WHERE employee_id = $id AND MONTH(created_at) = $month and YEAR(created_at) = $year  ORDER BY id DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function getTotalbyEvaluationId($id){
    $sql = "SELECT AVG(rating) as total FROM employee_evaluation_details where evaluation_form_id = :id GROUP BY evaluation_form_id ";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }
             
   public function add($data){

          $employee_id = 1;
          $evaluator_id = 1;
          $date_evaluated = date('Y-m-d');
      		
      		
          $sql = "INSERT INTO employee_evaluation_form(employee_id, opening_manager,
closing_manager, evaluator_id) VALUES( :employee_id, :opening_manager, :closing_manager, :evaluator_id)";
            $stmt = $this->db->pdo->prepare($sql);
            $stmt->bindValue(':employee_id', isset($data['employee_id']) ? $data['employee_id'] : null);
            $stmt->bindValue(':opening_manager', isset($data['opening_manager']) ? $data['opening_manager'] : null);
            $stmt->bindValue(':closing_manager', isset($data['closing_manager']) ? $data['closing_manager'] : null);
            $stmt->bindValue(':evaluator_id', $_SESSION['id']);
            $result = $stmt->execute();
            $latest_data = $this->viewLatestOne();

                    if ($result) {
                      foreach($data['id'] as $key => $value){
                        $sql = "INSERT INTO employee_evaluation_details(evaluation_form_id, evaluation_item_id, rating) VALUES(:eval_form, :item, :rating)";
                         $stmt = $this->db->pdo->prepare($sql);
                        $stmt->bindValue(':eval_form', $latest_data->id);
                        $stmt->bindValue(':item', $value);
                        $stmt->bindValue(':rating', isset($data['check'][$key]) ? $data['check'][$key] : null);
                        $result = $stmt->execute();
                      }

                    return true;

            }else{
              $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Error !</strong> Something went Wrong !</div>';
                    return $msg;
            }
   }

   public function viewLatestOne(){
      $sql = "SELECT * FROM employee_evaluation_form ORDER BY id DESC LIMIT 1";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_OBJ);
      if ($result) {
        return $result;
      }else{
        return false;
      }
    }

   public function viewOne($id){
      $sql = "SELECT * FROM employee_evaluation_form WHERE id = :id LIMIT 1";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $id);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_OBJ);
      if ($result) {
        return $result;
      }else{
        return false;
      }
    }
    

    public function viewDetails($id){
      $sql = "SELECT * FROM employee_evaluation_details where checklist_id = :id";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $id);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function viewDetailsWithItem($id,$id2){
      $sql = "SELECT * FROM employee_evaluation_details where evaluation_form_id = :id AND evaluation_item_id = :id2 LIMIT 1";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $id);
      $stmt->bindValue(':id2', $id2);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_OBJ);
      if ($result) {
        return $result;
      }else{
        return false;
      }
    }

   public function update($data){

          $item_name = $data['item'];
          $category = $data['category'];
          $id = $data['id'];
      		
      		$sql = "UPDATE monitoring_checklist_items SET
          item_name = :item_name,
          category = :category
          WHERE id = {$id}";

          $stmt= $this->db->pdo->prepare($sql);
          $stmt->bindValue(':item_name', $item_name);
          $stmt->bindValue(':category', $category);
        $result =   $stmt->execute();

            if ($result) {
              $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Success !</strong> Wow, you have Registered Successfully !</div>';
                    return $msg;
            }else{
              $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Error !</strong> Something went Wrong !</div>';
                    return $msg;
            }
   }

   public function delete($id){
    
      		$sql = "DELETE FROM monitoring_checklist_items WHERE id = :id ";
      		$stmt = $this->db->pdo->prepare($sql);
      		$stmt->bindValue(':id', $id);
          $result = $stmt->execute();

            if ($result) {
              $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Success !</strong> Wow, you have Registered Successfully !</div>';
                    return $msg;
            }else{
              $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Error !</strong> Something went Wrong !</div>';
                    return $msg;
            }
   }

}
