<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


//Including configuration
require_once ("Config.php");

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
if (json_last_error() !== JSON_ERROR_NONE) 
  errorHandling("Internal server error", 500);

//checking if the data is set
if (!isset($decode)) 
  errorHandling("Internal server error", 500);

//Checking the type of request the user made
if ($decode->Type == "GetWines") 
  echo getWines($decode);
else if ($decode->Type == "GetWinery") 
  echo getWinery($decode);
else if ($decode->Type == "GetBrand") 
  echo getBrands($decode);
else if ($decode->Type == "GetUser") 
  echo getUser($decode);
else //the user did not give the correct type
  errorHandling("Incorrect request type", 400);

function getWines($decode)
{
  //Create SQL query 
  $validReturn = array("bottleSize" => "bot.Bottle_Size AS bottleSize", "price" => "bot.Price AS price", 
    "image_URL" => "bot.Image_URL AS image_URL", "availability" => "bot.Num_Bottles_Made - bot.Num_Bottles_Sold AS availability", 
    "name"=> "bar.Name AS name", "year"=> "bar.Year AS year", "age" => "YEAR(CURDATE()) - bar.Year AS age",
    "description"=> "bar.Description AS description", "cellaringPotential"=> "bar.Cellaring_Potential AS cellaringPotential", 
    "awardName"=> "aw.Award AS awardName", "awardYear"=> "aw.Year AS awardYear", "awardDetails"=> "aw.Details AS awardDetails", 
    "categoryName"=> "var.Category_Name AS categoryName", "varietalName"=> "var.Varietal_Name AS varietalName", 
    "residualSugar"=> "var.Residual_Sugar AS residualSugar", "ph"=> "var.pH AS ph", 
    "alcoholPercent"=> "var.Alcohol_Percentage AS alcoholPercent", "quality"=> "var.Quality AS quality", 
    "brandName"=> "bar.Brand_Name AS brandName","wineryName"=> "bar.Winery_Name AS wineryName", 
    "wineyardName"=> "bar.Wineyard_Name AS wineyardName","rating"=> "AVG(rate.Rating) AS rating",
    "productionMethod"=> "bar.Production_Method AS productionMethod", "productionDate"=> "bar.Production_Date AS productionDate");
  $awardFlag = false;
  $sql = "";
  
  if(!isset($decode->Return)) //Checking that required field is set
    errorHandling("The parameters are incorrect", 400);
  
  //SELECT and FROM statements
  if($decode->Return == "*") //Returing everything 
  {
    //Seperate call "awardName", "awardYear", "awardDetails". Setting flag for call later on
    $awardFlag = true;

    $sql .= "SELECT bot.Wine_Barrel_ID AS ID, bot.Bottle_Size AS bottleSize, bot.Price AS price, bot.Image_URL AS image_URL, bot.Num_Bottles_Made - bot.Num_Bottles_Sold AS availability, 
    bar.Name AS name, bar.Year AS year, YEAR(CURDATE()) - bar.Year AS age, bar.Description AS description, bar.Cellaring_Potential AS cellaringPotential, 
    var.Category_Name AS categoryName, var.Varietal_Name AS varietalName, var.Residual_Sugar AS residualSugar, var.pH AS ph, 
    var.Alcohol_Percentage AS alcoholPercent, var.Quality AS quality, bar.Brand_Name AS brandName, bar.Winery_Name AS wineryName, bar.Wineyard_Name AS wineyardName, 
    AVG(rate.Rating) AS rating, bar.Production_Method AS productionMethod, bar.Production_Date AS productionDate
    FROM Bottle AS bot
    JOIN WineBarrels AS bar
    ON bot.Wine_Barrel_ID = bar.ID
    LEFT JOIN Varietal AS var
    ON bar.Varietal = var.Varietal_Name AND bar.Brand_Name=var.Brand_Name
    LEFT JOIN WineRating AS rate 
    ON bar.ID = rate.WineBarrel_ID"; 
  }
  else //Returing selected stuff
  {
    $sql .= "SELECT bot.Wine_Barrel_ID AS ID, ";
    $temp =[];
    
    foreach($decode->Return as $item)
    {
      if(!array_key_exists($item, $validReturn))
        errorHandling("Incorrect parameters", 400);

      if($item == "awardName" || $item == "awardYear" || $item == "awardDetails")
        $awardFlag = true;
      else
      {
        array_push($temp,$validReturn[$item]);
      }
        
    }

    $sql .= implode(",", $temp) ." FROM Bottle AS bot
    JOIN WineBarrels AS bar
    ON bot.Wine_Barrel_ID = bar.ID
    LEFT JOIN Varietal AS var
    ON bar.Varietal = var.Varietal_Name AND bar.Brand_Name=var.Brand_Name
    LEFT JOIN WineRating AS rate 
    ON bar.ID = rate.WineBarrel_ID";
  }
  
  //Adding the Search
  if(isset($decode->Search))
  {
    $sql .= " WHERE ";
    $temp = [];

    foreach($decode->Search as $key=>$value)
    {
      if(!array_key_exists($key, $validReturn))
        errorHandling("Incorrect parameters", 400);

      $par = strstr($validReturn[$key], 'AS', true);

      if(!isset($decode->Fuzzy) || $decode->Fuzzy == "false") //Default and case: fuzzy = false
        array_push($temp, $par. "='" . $value . "'");
      else if(isset($decode->Fuzzy) && $decode->Fuzzy == "true")
        array_push($temp, $par. " LIKE '%" . $value . "%'");
    }

    $sql .= implode(" AND ", $temp);    
    $sql .= " GROUP BY rate.WineBarrel_ID";
  }
  else
  {
    $sql .= " GROUP BY rate.WineBarrel_ID";
  }

  //Adding the SORT 
  if(isset($decode->Sort))
  {
    $sql .= " ORDER BY ";
    if(!array_key_exists($decode->Sort, $validReturn))
      errorHandling("Incorrect parameters", 400);

    $sql .= $decode->Sort;
    //Adding the order
    if(isset($decode->Order))
    {
      if($decode->Order != "ASC" && $decode->Order != "DESC")
        errorHandling("Incorrect parameters", 400);
      $sql .= " ". $decode->Order;
    }
      
  }

  //Adding the Limit
  if(isset($decode->Limit))
    $sql.= " LIMIT " . $decode->Limit;  

    
  //Run the query via config.php
  $queryResults = Connect::instance()->runSelectQuery($sql);
  if($queryResults) //There is atleast 1 row returned 
  {
    if($awardFlag) //Need to fetch the awward for each row
    {
      if($decode->Return == "*")
      {
        foreach($queryResults as &$row)
        {
          $sql = "SELECT ";
          $temp = [];
          array_push($temp, $validReturn["awardName"]);
          array_push($temp, $validReturn["awardYear"]);
          array_push($temp, $validReturn["awardDetails"]);

          $sql .= implode( ",",$temp) . " FROM Award AS aw WHERE aw.Wine_Barrel_ID = " . $row["ID"];
          $awardResult = Connect::instance()->runSelectQuery($sql);
          if($awardResult == false) //There aren't any awards
            $row["award"] = "none"; 
          else
            $row["award"] = $awardResult; 
          
        }
      }
      else
      {
        foreach($queryResults as &$row)
        { 
          $sql = "SELECT ";
          $temp = [];
          if(in_array("awardName",$decode->Return))
            array_push($temp, $validReturn["awardName"]);
          if(in_array("awardYear", $decode->Return))
            array_push($temp, $validReturn["awardYear"]);
          if(in_array("awardDetails", $decode->Return))
            array_push($temp, $validReturn["awardDetails"]);

          $sql .= implode( ",",$temp) . " FROM Award AS aw WHERE aw.Wine_Barrel_ID = " . $row["ID"];
          
          $awardResult = Connect::instance()->runSelectQuery($sql);
          if($awardResult == false) //There aren't any awards
            $row["award"] = "none"; 
          else
            $row["award"] = $awardResult; 
        }
      }      
    }

    $response = [
      'status' => 'sucsess',
      'timestamp' => time(),
      'data' => $queryResults
    ];
    return json_encode($response);
  }
  else if($queryResults==false)
  {
    $response = [
      'status' => 'failed',
      'timestamp' => time(),
      'data' => "No mathing results found"
    ];
    return json_encode($response);
  }
  else if ($queryResults==null)
    errorHandling('Error executing the database query.', 500);

}

function getWinery($decode)
{

}


function getBrands($decode)
{
  $fuzzy = isset($decode->Fuzzy) ? $decode->Fuzzy : true;
  $search = isset($decode->Fearch) ? $decode->Search : [];
  $returnFields = isset($decode->Return) ? $decode->Return : [];
  $sortField = isset($decode->Fort) ? $decode->Fort : 'name';
  $sortOrder = isset($decode->Order) ? strtoupper($decode->Order) : 'ASC';
  $limit = isset($decode->Limit) ? intval($decode->Limit) : null;
  
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
  $result = Connect::instance()->runSelectQuery($sql);

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
  $fuzzy = isset($decode->Fuzzy) ? $decode->Fuzzy : true;
  $search = isset($decode->Search) ? $decode->Search : [];
  $returnFields = isset($decode->Return) ? $decode->Return : [];
  
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
  $result = Connect::instance()->runSelectQuery($sql);

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
