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
        $result=$this->conn->query("SELECT * FROM `random_stuff`");
        $data=array();
        while($row=$result->fetch_assoc()){
            $row_data["s_no"]=(int)$row["s_no"];
            $row_data["task"]=$row["task"];
            $data[]= $row_data;
        }
        return $data;
    }

}

?>
