<?php
include_once dirname ( __DIR__ ) ."\includes\config.php";
include_once '../lib/database.php';

class Employee_evaluation_items{


  private $db;


  public function __construct(){
    $this->db = new Database();
  }

  public function view(){
    $sql = "SELECT * FROM employee_evaluation_items ORDER BY id DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function viewUserAll($id){
    $sql = "SELECT * FROM employee_evaluation_items  WHERE evaluation_form_id = '{$id}' ORDER BY id DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function get_category_groups(){
    $sql = "SELECT DISTINCT category FROM employee_evaluation_items ORDER BY id DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function view_by_categ($category){
    $sql = "SELECT * FROM employee_evaluation_items WHERE category = '{$category}' ORDER BY id DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }


   public function add($data){

          $item_name = $data['item'];
          $category = $data['category'];
      		
      		$sql = "INSERT INTO employee_evaluation_items(item_name, category) VALUES(:item_name, :category)";
            $stmt = $this->db->pdo->prepare($sql);
            $stmt->bindValue(':item_name', $item_name);
            $stmt->bindValue(':category', $category);
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

   public function viewOne($id){
      $sql = "SELECT * FROM employee_evaluation_items WHERE id = :id LIMIT 1";
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


   public function update($data){

          $item_name = $data['item'];
          $category = $data['category'];
          $id = $data['id'];
      		
      		$sql = "UPDATE employee_evaluation_items SET
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
    
      		$sql = "DELETE FROM employee_evaluation_items WHERE id = :id ";
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
