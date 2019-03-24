<?php
  function checkExists($tableName,$field,$checkID,$conditions = array()) {
    include 'connectToServer.php'; //connects to the PHP for the server
    if (isset($conditions) && sizeof($conditions) == 0) {
      $sql = "SELECT $field FROM $tableName WHERE $field = ? LIMIT 1;"; //gets the record with this ID
      $stmt = $conn->prepare($sql); //prepares the connection for the SQL
      //sets up SQL for selecting the information from the table
      $stmt->bind_param("s", $checkID); //preparation for an SQL query
    } else { //if there is an extra condition needed
      $sql = "SELECT $field FROM $tableName WHERE $field = ? AND $conditions[0] = ? LIMIT 1;"; //gets the record with this ID
      $stmt = $conn->prepare($sql); //prepares the connection for the SQL
      //sets up SQL for selecting the information from the table
      $stmt->bind_param("ss", $checkID, $conditions[1]); //preparation for an SQL query
    }
    $stmt->execute(); //executes the sql
    $result = $stmt->get_result(); //gets the result from the query
    if ($result->num_rows == 0) {
      return false; //there were no records with the matching criteria
    } else {
      return true; //there was a record found - it exists
    }
  }
  function checkUnique($globalArray,$tableName,$funcName,$primaryField,&$message,$excludedID = 0) {
    include 'connectToServer.php'; //connects to the PHP for the server
    $sql = "SELECT * FROM $tableName WHERE $primaryField <> ?;";
    $stmt = $conn->prepare($sql); //prepares the connection for the SQL
    //sets up SQL for selecting the information from the table
    $stmt->bind_param("s", $excludedID);
    $stmt->execute(); //executes the sql
    $result = $stmt->get_result(); //gets the result from the query
    $error = 0; //defines a value for the errors
    if ($result->num_rows > 0 ) { //if there are any existing records
      while($row = $result->fetch_assoc()) { //passes the row from the table
        $funcName($globalArray,$row,$error,$message); // gets the first error message and if there were errors
        if ($error) break; //if an error was thrown up, the loop is broken - saves wasted time
      }
    } //if there aren't any, unqiueness won't need to be checked
    return $error; //returns the appropiate value
  }
  function checkIdentites($globalArray,$field,$tableField,$tableName,&$message,$conditions = array()) { //checks the identities within the form table
    $error = 1; //defines a value for the errors
    if(!arrayDuplicates($globalArray[$tableField])) { //sees if duplicates in array, i.e. table contains same ID twice
      $message = "There is a duplicate ID in the table"; //defines a value for the message
      $error = 0; //defines a value for the errors
    } else {
      foreach($globalArray[$tableField] as $ele) { //every row in the column
        if(!checkExists($tableName,$field,$ele,$conditions)) { //checks if the ID exists in another table - all IDs are foreign keys
          $message = "Some IDs do not exist in the table"; //defines a value for the message
          $error = 0; //defines a value for the errors
          break; //breaks from loop as the test has been failed
        }
      }
    }
    return $error; //returns the appropiate values
  }
  function arrayDuplicates($array) { //function to check if duplicates in array
    $tempArray = array(); //used for temporary store
    $toReturn = true; //passed function test
    foreach ($array as $arr) {
      if (!in_array($arr,$tempArray)) { //checks if element in array
        array_push($tempArray,$arr); //adds element to array
      } else {
        $toReturn = false; //failed function test
        break; //duplicate found
      }
    }
    return $toReturn; //returns the conclusion
  }
  function deleteRecords($table,$globalArray,$fieldName,$idName) { //creates a function to delete records from a table based on projectID
    include 'connectToServer.php'; //connects to the PHP for the server
    $sql = "DELETE FROM $table WHERE $fieldName = ?;"; //Deletes all records with this primary key from item table
    $stmt = $conn->prepare($sql); //prepares the connection for the SQL
    //The $_POST array is a global array which stores the data passed from the form as the 'post' method is used
    $stmt->bind_param("s", $globalArray[$idName]);
    //Sets each value form the array POST to a string
    $stmt->execute(); //executes the sql
    $stmt->close(); //closes the SQL
    $conn->close(); //closes the connection
  }
  function deleteRecordsTables($tableArray,&$globalArray,$fieldName,$idName) {
    //function to delete records from multiple tables with one execution
      foreach($tableArray as $tableName) { //goes through all the table names
        deleteRecords($tableName,$globalArray,$fieldName,$idName); //executes function to delete all records
      }
        $globalArray = array(); //clears the array passed by reference
  }
  function deleteRecordsTablesMulti($infoArray,&$globalArray) {
    //function to delete records from multiple tables with multiple ID names
      foreach($infoArray as $array) { //goes through all the table names
        deleteRecords($array[0],$globalArray,$array[1],$array[2]); //executes function to delete all records
      }
        $globalArray = array(); //clears the array passed by reference
  }
  function getTableInfo($table,$fieldName,$theID) {
    include 'connectToServer.php'; //connects to the PHP for the server
    $sql = "SELECT * FROM $table WHERE $fieldName = ?;";
    $stmt = $conn->prepare($sql); //prepares the connection for the SQL
    //sets up SQL for selecting the information from the table
    $stmt->bind_param("s", $theID);
    $stmt->execute(); //executes the sql
    $result = $stmt->get_result(); //gets the result from the query
    if ($result->num_rows > 0 ) { //despite this, this will wrk due to there being only one returned record, hopefully
      while($row = $result->fetch_assoc()) { //passes the row from the table as
        return($row); //globalises the variable - allows for use further down
      }
    }
  }
  function getTableInfoMulti($table,$fieldName,$theID) {
    include 'connectToServer.php'; //connects to the PHP for the server
    $sql = "SELECT * FROM $table WHERE $fieldName = ?;"; //gets all the records with this ID
    $stmt = $conn->prepare($sql); //prepares the connection for the SQL
    //sets up SQL for selecting the information from the table
    $stmt->bind_param("s", $theID);
    $stmt->execute(); //executes the sql
    $result = $stmt->get_result(); //gets the result from the query
    $results = array(); //creates an array to store the arrays of results
    if ($result->num_rows > 0) {
      while($line = $result->fetch_assoc()) {
        $results[] = $line; //adds each array as an array to the results array
      }
    }
    return ($results); //will return the array either populated or blank
  }
  function getNextID($table,$fieldName) { //function for getting ID of next record
    include 'connectToServer.php'; //connects to the PHP for the server
    $sql = "SELECT $fieldName FROM $table ORDER BY $fieldName DESC LIMIT 1"; //gets last ID from table
    $result = $conn->query($sql);
    if ($result->num_rows > 0 ) { //despite this, this will work due to there being only one returned record, hopefully
      while($row = $result->fetch_assoc()) { //passes the row from the table as
        $theID = reset($row); //reduces the array to one element
      }
      return ($theID + 1);
    } else {
      return (1); //there are no records so next ID is first ID
    }
  }
  function replaceChars(&$array) { //function to replace characters within an array
    foreach ($array as &$ele) { //iterates through array to make data suitable for database
      //starting the $ele variable with an ampersand passes variable by reference
      $ele = str_replace(array(",","£","%"),"",$ele); //removes pound signs and commas
    }
  }
  function removeCharsReadonly(&$string,$page) { //removes readonly elements of a form depending on whether it's an edit or delete page
    $string = (strpos($page, 'Delete') == false ?  str_replace(array("readonly","disabled"),"",$string) : $string); //removes the readonlys from the page if not a delete page
  }
  function removeCharsRed(&$string,$page) { //removes red *s elements of a form depending on whether it's an edit or delete page
    $string = (strpos($page, 'Delete') !== false ?  str_replace("<span class='red'>*</span>","",$string) : $string); //removes the red *s if a delete page
  }
?>
