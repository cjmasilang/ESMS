<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
include_once dirname ( __DIR__ ) ."\includes\config.php";
include_once '../lib/database.php';

class Monitoring_checklist_form{


  private $db;


  public function __construct(){
    $this->db = new Database();
  }

  public function view(){
    $sql = "SELECT * FROM shift_monitoring_checklist ORDER BY id DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function view_user(){
    $sql = "SELECT * FROM shift_monitoring_checklist WHERE shift_manager = {$_SESSION['id']} ORDER BY id DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

   public function add($data){

          $employee_id = 1;
          $evaluator_id = 1;
          $date_evaluated = date('Y-m-d');
      		
      		
          $sql = "INSERT INTO shift_monitoring_checklist(shift_manager) VALUES(:shift_manager)";
            $stmt = $this->db->pdo->prepare($sql);
            $stmt->bindValue(':shift_manager', $_SESSION['id']);
            $result = $stmt->execute();
            $latest_data = $this->viewLatestOne();

                    if ($result) {
                      foreach($data['id'] as $key => $value){
                        if( isset($data['am'][$value]) || isset($data['pm'][$value]) ){
                        $sql = "INSERT INTO shift_monitoring_details(checklist_id, monitoring_item_id, remarks, am, pm) VALUES(:checklist_id, :monitoring_item_id,:remarks, :am, :pm)";
                        $stmt = $this->db->pdo->prepare($sql);
                        $stmt->bindValue(':checklist_id', $latest_data->id);
                        $stmt->bindValue(':monitoring_item_id', $value);
                        $stmt->bindValue(':remarks', isset($data['remarks'][$value]) ? $data['remarks'][$value] : null);
                        $stmt->bindValue(':am', isset($data['am'][$value]) ? $data['am'][$value] : null);
                        $stmt->bindValue(':pm', isset($data['pm'][$value]) ? $data['pm'][$value] : null);
                        $result = $stmt->execute();
                        }
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
      $sql = "SELECT * FROM shift_monitoring_checklist ORDER BY id DESC LIMIT 1";
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
      $sql = "SELECT * FROM shift_monitoring_checklist WHERE id = :id LIMIT 1";
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
      $sql = "SELECT * FROM shift_monitoring_details where checklist_id = :id";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $id);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function viewDetailsWithItem($id,$id2){
      $sql = "SELECT * FROM shift_monitoring_details where checklist_id = :id AND monitoring_item_id = :id2 LIMIT 1";
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
