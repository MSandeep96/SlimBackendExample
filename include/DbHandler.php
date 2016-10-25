<?php

/**
* Class to handle all db operations
* This class will have CRUD methods for database tables
*
* @author Ravi Tamada
* @link URL Tutorial link
*/
class DbHandler {

    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }


    /**
    * creates task
    * @param STring $task to INSERT
    * @return if success or not
    */
    public function createTask($task){
        $response = array();
        $stmt=$this->conn->prepare("INSERT INTO `random_stuff` (`task`) VALUES (?);");
        $stmt->bind_param("s",$task);
        $response["success"] = $stmt->execute();
        return $response;
    }

    /**
    * get tasks
    */
    public function getTasks(){
        $result=$this->conn->query("SELECT * FROM `random_stuff`;");
        $data=array();
        while($row=$result->fetch_assoc()){
            $row_data["s_no"]=(int)$row["s_no"];
            $row_data["task"]=$row["task"];
            $data[]= $row_data;
        }
        return $data;
    }

    /**
    * paginate the tasks
    */
    public function getTasksPag($page_no){
        $data=array();
        $offse=$page_no*5;
        if($offse>$this->getTaskCount()){
            $data["out_of_limit_error"]=true;
            return $data;
        }
        $tasks_in_limit=$this->conn->query("SELECT * FROM `random_stuff` LIMIT $offse , 5;");
        while($row=$tasks_in_limit->fetch_assoc()){
            $row_data["s_no"]=(int)$row["s_no"];
            $row_data["task"]=$row["task"];
            $data[]= $row_data;
        }
        return $data;
    }

    /**
    * get tasks count
    */
    public function getTaskCount(){
        $result=$this->conn->query("SELECT * FROM `random_stuff`;");
        return $result->num_rows;
    }

}

?>
