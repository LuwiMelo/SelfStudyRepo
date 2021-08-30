<?php

 class Department{
  

      public $conn;
      public $table_name = "tbldepartment";

      public $DepartmentID;
      public $DepartmentName;
      public $DepartmentDetails;
      public $createdAt;


      public function __construct($db){
        $this->conn = $db;
    }
     

     
    function CountExistingDepartments(){

        $query = "SELECT COUNT(DepartmentID) FROM tbldepartment WHERE deleted_at IS NULL";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        $num = $stmt->rowCount();
  
        return $num;

    }


    function ReadAllActiveDepartments(){

        $query = "SELECT * FROM tbldepartment WHERE deleted_at IS NULL";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;

    }


    function InsertNewDepartment(){

        $query = "INSERT INTO
        " . $this->table_name . "
        SET
        DepartmentName = :DepartmentName ";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->DepartmentName = htmlspecialchars(strip_tags($this->DepartmentName));
        //$this->price=htmlspecialchars(strip_tags($this->price));
        //$this->description=htmlspecialchars(strip_tags($this->description));
        //$this->category_id=htmlspecialchars(strip_tags($this->category_id));
        // to get time-stamp for 'created' field
        //$this->timestamp = date('Y-m-d H:i:s');

        // bind values 
        $stmt->bindParam(":DepartmentName", $this->DepartmentName);
       //$stmt->bindParam(":price", $this->price);
       //$stmt->bindParam(":description", $this->description);
       //$stmt->bindParam(":category_id", $this->category_id);
       //$stmt->bindParam(":created", $this->timestamp);

        if($stmt->execute()){
                return true;
        }
        else{
                return false;
        }
       
        
    }





 }

?>