<?php
  function showTheField($array) {
    $theNewHTML = "";
    $selectHTML = "<td><select class='redArrow' name='location[]' title='Please select an option' required >
    <option value=''>Select a location</option>
    <option value='NotonPO'>Not on a PO</option>
    <option value='OnPONotOrd'>On a PO but not ordered</option>
    <option value='OrdNotDel'>Ordered not delivered</option>
    <option value='Store'>In the stores</option><option value='Assembled'>Assembled</option>
    <option value='Shipped'>Shipped to customer</option>
    </select></td> </tr>"; //to reduce lines below as identical structure
    $counter = 0; //starts a counter - used in accessing function later down
    if (!in_array($array,$GLOBALS)) {
      foreach ($array as $arr) { //iterates through 2D array
        $theNewHTML .= "<tr> <td><input name='tablePartID[]' type='text' title='Please enter the part ID' oninvalid='setCustomValidity(\"Please enter a valid part ID.\")' oninput='setCustomValidity(\"\")' required value='".$arr['PartID']."'></td>";
        $theNewHTML .= "<td><input name='tableQty[]' type='text' title='Please enter the quantity' oninvalid='setCustomValidity(\"Please enter a valid number.\")' oninput='setCustomValidity(\"\")' required value='".$arr['Quantity']."' /></td>";
        $theNewHTML .= $selectHTML;
        $theNewHTML .= "<script>selectOption('redArrow','".$arr['Location']."', '".$counter."');</script>";
        $counter += 1; //increases counter for next use
      }
    } else {
      for ($i = 0; $i < sizeof($array['tablePartID']); $i++) { //iterates through 2D array
        $theNewHTML .= "<tr> <td><input name='tablePartID[]' type='text'title='Please enter the part ID' oninvalid='setCustomValidity(\"Please enter a valid part ID.\")' oninput='setCustomValidity(\"\")' required value='".$array['tablePartID'][$i]."'></td>";
        $theNewHTML .= "<td><input name='tableQty[]' type='text' title='Please enter the quantity' oninvalid='setCustomValidity(\"Please enter a valid number.\")' oninput='setCustomValidity(\"\")' required value='".$array['tableQty'][$i]."' /></td>";
        $theNewHTML .= $selectHTML;
        $theNewHTML .= "<script>selectOption('redArrow','".$array['location'][$i]."', '".$counter."');</script>";
        $counter += 1; //increases counter for next use
      }
    }
    echo $theNewHTML; //adds HTML code to the page
  }
  function newProjectInfo(&$globalArray,$checker) {
    $last_id = newProject($globalArray);
    if (isset($globalArray[$checker]) && sizeof($globalArray[$checker]) > 0) {
      newItem($globalArray,$last_id,$checker); //executes function to create new project
    }
    $globalArray = array(); //clears the array
  }
  function newProject($globalArray) {
    include 'connectToServer.php'; //connects to the PHP for the server
    $sql =  "INSERT INTO project (ProjectName, CreationDate)
              VALUES (?,?);"; //Defines the SQL for inputting data into the database table 'project'
    $stmt = $conn->prepare($sql); //prepares the connection for the SQL
    //The $_POST array is a global array which stores the data passed from the form as the 'post' method is used
    $stmt->bind_param("ss", $_POST['projectName'], $_POST['createDate']);
    //Sets each value form the array POST to a string
    if ($stmt->execute() === TRUE) { //executes the sql and checks whether is executed correctly
      $last_id = $conn->insert_id; //if so, the ID of the new record created is stored as variable
    }; //for the ID of the next project, for that below
    return (isset($last_id) ? $last_id : 1);
    $stmt->close();
  }
  function newItem($globalArray,$Project_ID,$checker) {
    include 'connectToServer.php'; //connects to the PHP for the server
    for ($i = 0; $i < sizeof($globalArray[$checker]); $i++) { //loops through for number of items in the array
      $sql = "INSERT INTO item VALUES (?, ?, ?, ?);"; //Defines the SQL for inputting data into the database table 'item'
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssis", $Project_ID, $globalArray['tablePartID'][$i], $globalArray['tableQty'][$i], $globalArray['location'][$i]);
      $stmt->execute();
      $stmt->close();
      }
    $conn->close(); //closes connection to database
  }
  function editProjectInfo(&$globalArray,$theID,$checker) {
    editProject($globalArray,$theID);
    editItem($globalArray,$theID,$checker);
    $globalArray = array(); //clears the array
  }
  function editProject($globalArray,$Project_ID) {
    include 'connectToServer.php'; //connects to the PHP for the server
    $sql = "UPDATE project
            SET ProjectName = ?, CreationDate = ?
            WHERE ProjectID = ?;"; //Defines the SQL for editing data into the database table 'project'
    $stmt = $conn->prepare($sql); //prepares the connection for the SQL
    //The $_POST array is a global array which stores the data passed from the form as the 'post' method is used
    $stmt->bind_param("sss", $globalArray['projectName'], $globalArray['createDate'], $Project_ID);
    //Sets each value form the array POST to a string
    $stmt->execute(); //executes the sql
    $stmt->close(); //closes the SQL
  }
  function editItem($globalArray,$theID,$checker) {
    deleterecords('item',$globalArray,'ProjectID','projectID');
    if (isset($globalArray[$checker])) {
      newItem($globalArray,$theID,$checker);
    }
  }
 ?>
