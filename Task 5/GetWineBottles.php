<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


//Including configuration
require_once ("Config.php");

$db = Connect::instance();


//Setup api
header("Content-Type: application/json");

//Error handeling function 
function errorHandling($message, $statusCode)
{
  http_response_code($statusCode);
  $ReturnJson = array("status" => "error", "timestamp" => time(), "data" => "$message");
  echo json_encode($ReturnJson);
  die();
}

//Get user input
$data = file_get_contents("php://input");

//Get data from the input
$decode = json_decode($data);

// Check for JSON decoding errors
if (json_last_error() !== JSON_ERROR_NONE) {
  $statusCode = "500";
  errorHandling("Internal server error", $statusCode);
}
//checking if the data is set
if (!isset($decode)) {
  $statusCode = "500";
  errorHandling("Internal server error", $statusCode);
}

//Checking the type of request the user made
if ($decode->type == "GetWines") {
  getWines($decode);
} else if ($decode->type == "GetWinery") {
  getWinery($decode);
} else if ($decode->type == "GetBrand") {
  getBrands($decode);
} else if ($decode->type == "GetUser") {
  getUser($decode);
} else //the user did not give the correct type
{
  $statusCode = "400";
  errorHandling("Incorrect request type", $statusCode);
}

function getWines($decode)
{

}

function getWinery($decode)
{
  
}


function getBrands($decode)
{
  global $db;

  $fuzzy = isset($decode->fuzzy) ? $decode->fuzzy : true;
  $search = isset($decode->search) ? $decode->search : [];
  $returnFields = isset($decode->return) ? $decode->return : [];
  $sortField = isset($decode->sort) ? $decode->sort : 'name';
  $sortOrder = isset($decode->order) ? strtoupper($decode->order) : 'ASC';
  $limit = isset($decode->limit) ? intval($decode->limit) : null;
  
  // Prepare the SQL query
  $sql = "SELECT ";

  if (empty($returnFields) || $returnFields === '*') {
    $sql .= "*";
  } else {
    $sql .= implode(", ", $returnFields);
  }

  $sql .= " FROM Brand";

  // Add search conditions to the SQL query if search fields are provided
  if (!empty($search)) {
    $conditions = [];
    foreach ($search as $column => $value) {
      if ($fuzzy) {
        $conditions[] = "$column LIKE :$column";
      } else {
        $conditions[] = "$column = :$column";
      }
    }
    $sql .= " WHERE " . implode(" AND ", $conditions);
  }

  // Add sorting to the SQL query
  $sql .= " ORDER BY $sortField $sortOrder";

  // Add limit to the SQL query if specified
  if ($limit !== null) {
    $sql .= " LIMIT $limit";
  }

  // Execute the query using the runSelectQuery() function
  $result = $db->runSelectQuery($sql);

  if ($result === false) {
    errorHandling('No matching records found.', 500);

  } elseif ($result === null) {
    errorHandling('Error executing the database query.', 500);

  } else {
    $response = [
      'status' => 'success',
      'timestamp' => time(),
      'data' => $result
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
  }
  exit();
}

function getUser($decode)
{
  global $db;

  $fuzzy = isset($decode->fuzzy) ? $decode->fuzzy : true;
  $search = isset($decode->search) ? $decode->search : [];
  $returnFields = isset($decode->return) ? $decode->return : [];
  
  // Prepare the SQL query
  $sql = "SELECT ";

  if (empty($returnFields) || $returnFields === '*') {
    $sql .= "*";
  } else {
    $sql .= implode(", ", $returnFields);
  }

  $sql .= " FROM User";

  // Add search conditions to the SQL query if search fields are provided
  if (!empty($search)) {
    $conditions = [];
    foreach ($search as $column => $value) {
      if ($fuzzy) {
        $conditions[] = "$column LIKE '%$value%'";
      } else {
        $conditions[] = "$column = '$value'";
      }
    }
    $sql .= " WHERE " . implode(" AND ", $conditions);
  }

  // Execute the query using the runSelectQuery() function
  $result = $db->runSelectQuery($sql);

  if ($result === false) {
    errorHandling('No matching records found.', 500);

  } elseif ($result === null) {
    errorHandling('Error executing the database query.', 500);

  } else {
    $response = [
      'status' => 'success',
      'timestamp' => time(),
      'data' => $result
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
  }
  exit();
}
?>

