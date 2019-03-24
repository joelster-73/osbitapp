<?php
  function showTheField($type, $array, $theID = 0) {
    $theNewHTML = "<h3>Parts for Bill of Materials";
    if ($type=='Assembly') { //if this option is selected
      $theNewHTML .= " <span class='red'>*</span> "; //to say field is compulsary
    }
    $theNewHTML .= "</h3>"; //put here due to line below
    //the ID will only be passed if non-create page
    if ($theID !==0) $theNewHTML .= "<br>BOMID <br> <input type='text' name='bomID' value='$theID' readonly/><br><br>";
    $theNewHTML .= "<table id='formTable'> <tr> <th>PartID</th> <th>Quantity</th> </tr>";
    if (!in_array($array,$GLOBALS)) {
      foreach ($array as $arr) { //iterates through 2D array
        $theNewHTML .= "<tr> <td><input name='tablePartID[]' type='text' title='Please enter the part ID' oninvalid='setCustomValidity(\"Please enter a valid part ID.\")' oninput='setCustomValidity(\"\")' required value='".$arr['PartID']."'></td>";
        $theNewHTML .= "<td><input name='tableQty[]' type='text' pattern='[0-9]+' title='Please enter the quantity' oninvalid='setCustomValidity(\"Please enter a valid number.\")' oninput='setCustomValidity(\"\")' required value='".$arr['Quantity']."' /></td> </tr>";
      }
    } else {
      for ($i = 0; $i < sizeof($array['tablePartID']); $i++) { //iterates through 2D array
        $theNewHTML .= "<tr> <td><input name='tablePartID[]' type='text' title='Please enter the part ID' oninvalid='setCustomValidity(\"Please enter a valid part ID.\")' oninput='setCustomValidity(\"\")' required value='".$array['tablePartID'][$i]."'></td>";
        $theNewHTML .= "<td><input name='tableQty[]' type='text' title='Please enter the quantity' oninvalid='setCustomValidity(\"Please enter a valid number.\")' oninput='setCustomValidity(\"\")' required value='".$array['tableQty'][$i]."' /></td> </tr>";
      }
    }
    $theNewHTML .= "</table> <br> <input type='button' onclick='addRow(\"formTable\")' value='Create Row'> <input type='button' onclick='delRow(\"formTable\")' value='Delete Row'><br><br>";
    if ($type == 'Bespoke' || $type == '') {
      $theNewHTML = ''; //will clear the new HTML if this option is selected
    }
    echo $theNewHTML; //adds HTML code to the page
  }
  function checkPart($globalArray,$row,&$error,&$message) { //function to check the supplier values
    extract($row); //extracts the varaibles from the array
    $error = 1;  //presets that there has been an error
    if ($PartName==$globalArray['partName']) { //if the input is in the database - not unique
      $message = "Part Name already exists"; //returns the approiate error message
    } elseif ($SupplierPartNum==$globalArray['supPartNum']) {
      $message = "Supplier\'s Part Number already exists";
    } else {
      $error = 0; //there has been no error
    }
  }
  function newPartInfo(&$globalArray,$checker) {
    $last_id = NULL; //predefines this variable to be null
    if ($globalArray['partType'] == "Assembly" ||  $globalArray['partType'] == "Bought-in-Part") {
      if (isset($globalArray[$checker]) && sizeof($globalArray[$checker]) > 0) {
        $last_id = getNextID('billofmaterials','BOMID'); //executes the function to find the next ID
        newBOM($globalArray,$last_id,$checker);
      }
    }
    newPart($globalArray,$last_id); //executes function to create new part
    $globalArray = array(); //clears the array
  }
  function newBOM($globalArray,$BOM_ID,$checker) {
    include 'connectToServer.php'; //connects to the PHP for the server
    for ($i = 0; $i < sizeof($globalArray[$checker]); $i++) { //loops through for number of items in the array
      $sql  = "INSERT INTO billofmaterials VALUES (?,?,?);";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssi", $BOM_ID, $globalArray['tablePartID'][$i], $globalArray['tableQty'][$i]);
      $stmt->execute(); //executes the sql
      $stmt->close(); //closes the statement
    }
    $conn->close(); //closes connection to database
  }
  function newPart($globalArray,$last_id) {
    include 'connectToServer.php'; //connects to the PHP for the server
    $sql = "INSERT INTO part (PartName, Description, CategoryType, SupplierPartNum, RevisionNum, CommodityCode, BOMID, Attachment)
            VALUES (?,?,?,?,?,?,?,?);"; //Defines the SQL for inputting data into the database table
    $stmt = $conn->prepare($sql); //prepares the connection for the SQL
    //The $_POST array is a global array which stores the data passed from the form as the 'post' method is used
    $stmt->bind_param("ssssisss", $globalArray['partName'], $globalArray['partDesc'], $globalArray['partType'], $globalArray['supPartNum'], $globalArray['revisionNum'], $globalArray['comCode'], $last_id, $globalArray['attachFile']);
    //Sets each value form the array POST to a string
    $stmt->execute(); //executes the sql
    $stmt->close(); //closes the SQL
    $conn->close(); //closes the connection
  }
  function editPartInfo(&$globalArray,$checker) {
    editPart($globalArray);
    editBOM($globalArray,$checker);
    $globalArray = array(); //clears the array
  }
  function editPart($globalArray) {
    include 'connectToServer.php'; //connects to the PHP for the server
    $sql = "UPDATE part
            SET PartName = ?, Description = ?, CategoryType = ?, SupplierPartNum = ?, RevisionNum = ?, CommodityCode = ?, Attachment = ?
            WHERE PartID = ?"; //Deines the SQL for editing data in the database table
    $stmt = $conn->prepare($sql); //prepares the connection for the SQL
    //The $_POST array is a global array which stores the data passed from the form as the 'post' method is used
    $stmt->bind_param("ssssssss", $_POST['partName'], $_POST['partDesc'], $_POST['partType'], $_POST['supPartNum'], $_POST['revisionNum'], $_POST['comCode'], $_POST['attachFile'], $_POST['partID']);
    //Sets each value form the array POST to a string
    $stmt->execute(); //executes the sql
    $stmt->close(); //closes the SQL
    $conn->close(); //closes the connection
  }
  function editBOM($globalArray,$checker) {
    deleterecords('billofmaterials',$globalArray,'BOMID','bomID');
    if (isset($globalArray[$checker])) {
      newBOM($globalArray,$globalArray['bomID'],$checker);
    }
  }
 ?>
