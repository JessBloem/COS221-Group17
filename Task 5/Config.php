<?php
session_start();
Class Connect
{
  public $conn;

  public static function instance()
  {
    static $instance = null;
    if($instance === null) $instance = new Connect();

    return $instance;
  }

  private function __construct()
  {
    $severname = "wheatley.cs.up.ac.za";
    $username = "u22557858";
    $password = "4DUVHCM4CCIBCCIRWY5JFTC73KGLY4XE";
    $databaseName = "u22557858_COS221";
    
    //Creating connection to database
    $this->conn = new mysqli($severname, $username , $password, $databaseName);
    //check connection 
    
    if(mysqli_connect_errno()){
      $statusCode = "500";
      http_response_code($statusCode);
      $ReturnJson = array("status" => "error","timestamp" => time(), "data" => "Internal server error");
      echo json_encode($ReturnJson);
      die();
    }
  }

  private function __destruct()
  {
    mysqli_close($this->conn);
    session_destroy();
  }

  public function runSelectQuery($sql)
  {
    $result = mysqli_query($this->conn, $sql);
    if(mysqli_num_rows($result)==0) return false; //Returns false if the database has empty resonse, i.e. nothing matched
    $output = $result -> fetch_all(MYSQLI_ASSOC);
    if($output==null) return null; //Returns null if the database returns nulle, i.e. an error occured with the query
    return $output;
  }
  
  public function runInsertOrDelteQuery($sql)
  {
    $result = mysqli_query($this->conn, $sql);
    return $result;
  }
}  

?>