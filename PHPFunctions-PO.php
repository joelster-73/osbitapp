<?php
  function showTheField($array,$page) { //function to add rows to table for items
    $theNewHTML = "";
    $counter = 0; //starts a counter - used in accessing function later down
    if (!in_array($array,$GLOBALS)) {
      foreach ($array as $arr) { //iterates through 2D array
        $theNewHTML .= "<tr> <td><input name='tablePartID[]' type='text' title='Please enter the part ID' oninvalid='setCustomValidity(\"Please enter a valid part ID.\")' oninput='setCustomValidity(\"\")' required value='".$arr['PartID']."' readonly/></td>";
        $theNewHTML .= "<td><input name='tableQty[]' type='text' title='Please enter the quantity' oninvalid='setCustomValidity(\"Please enter a valid number.\")' oninput='setCustomValidity(\"\")' required value='".$arr['Quantity']."' readonly/></td>";
        $theNewHTML .= "<td><input name='unitCost[]' class='money' type='text' title='Please enter the line price' oninvalid='setCustomValidity(\"Please enter a valid cost.\")' oninput='setCustomValidity(\"\")' required pattern='£[0-9,]*.[0-9]{2}' value='".$arr['UnitCost']."' readonly/></td>";
        removeCharsReadonly($theNewHTML,$page); //calls function to remove the readonlys
        $theNewHTML .= "<td><input name='linePrice[]' class='money' type='text' pattern='£[0-9,]*.[0-9]{2}' value='".$arr['LinePrice']."' readonly/></td>"; //does not want to remove this readonly
        $counter += 1; //increases counter for next use
      }
    } else {
      for ($i = 0; $i < sizeof($array['tablePartID']); $i++) { //iterates through 2D array
        $theNewHTML .= "<tr> <td><input name='tablePartID[]' type='text' title='Please enter the part ID' oninvalid='setCustomValidity(\"Please enter a valid part ID.\")' oninput='setCustomValidity(\"\")' value='".$array['tablePartID'][$i]."' readonly/></td>";
        $theNewHTML .= "<td><input name='tableQty[]' type='text' title='Please enter the quantity' oninvalid='setCustomValidity(\"Please enter a valid number.\")' oninput='setCustomValidity(\"\")' required value='".$array['tableQty'][$i]."' readonly/></td>";
        $theNewHTML .= "<td><input name='unitCost[]' class='money' title='Please enter the line price' oninvalid='setCustomValidity(\"Please enter a valid cost.\")' oninput='setCustomValidity(\"\")' required type='text' pattern='£[0-9,]*.[0-9]{2}' value='".$array['unitCost'][$i]."' readonly/></td>";
        removeCharsReadonly($theNewHTML,$page); //calls function to remove the readonlys
        $theNewHTML .= "<td><input name='linePrice[]' class='money' type='text' pattern='£[0-9,]*.[0-9]{2}' value='".$array['linePrice'][$i]."' readonly/></td>"; //does not want to remove this readonly
        $counter += 1; //increases counter for next use
      }
    }
    echo $theNewHTML; //adds HTML code to the page
  }
  function newPOInfo(&$globalArray,$checker) {
    replaceChars($globalArray); //Calls the function to remove all the special characters
    $last_id = newPO($globalArray);
    if (isset($globalArray[$checker]) && sizeof($globalArray[$checker]) > 0) {
      newOrderLine($globalArray,$last_id,$checker); //executes function to create new project
    }
    $globalArray = array(); //clears the array
  }
  function newPO($globalArray) {
    include 'connectToServer.php'; //connects to the PHP for the server
    $sql = "INSERT INTO purchaseorder (SupplierID, DeliveryPrice, DeliveryDestination, VATOption, DiscountPercent, OtherCost, TotalCost, OrderDate, DeliveryDate, Status, Notes)
            VALUES (?,?,?,?,?,?,?,?,?,?,?);"; //Defines the SQL for inputting data into the database table
    $stmt = $conn->prepare($sql); //prepares the connection for the SQL
    //The $_POST array is a global array which stores the data passed from the form as the 'post' method is used
    $stmt->bind_param("sssssssssss", $_POST['supID'], $_POST['delCost'], $_POST['delDest'], $_POST['VAT'], $_POST['discountPercent'], $_POST['costs'], $_POST['totalCost'], $_POST['ordDate'], $_POST['delDate'], $_POST['status'], $_POST['notes']);
    //Sets each value form the array POST to a string
    if ($stmt->execute() === TRUE) { //executes the sql and checks whether is executed correctly
      $last_id = $conn->insert_id; //if so, the ID of the new record created is stored as variable
    }; //for the ID of the next project, for that below
    return (isset($last_id) ? $last_id : 1); //this statement has been added to evade an error with PHP script loading before form execution
    $stmt->close();
  }
  function newOrderLine($globalArray,$PO_ID,$checker) {
    include 'connectToServer.php'; //connects to the PHP for the server
    for ($i = 0; $i < sizeof($_POST[$checker]); $i++) { //loops through for number of items in the array
      $sql = "INSERT INTO orderline VALUES (?,?,?,?,?,?);";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sssiss", $PO_ID, $_POST['tablePartID'][$i], $_POST['projectID'], $_POST['tableQty'][$i], $_POST['unitCost'][$i], $_POST['linePrice'][$i]);
      $stmt->execute();
      $stmt->close();
    }
    $conn->close(); //closes connection to database
  }
  function editPOInfo(&$globalArray,$theID,$checker) {
    replaceChars($globalArray); //removes uneanted characters
    editPO($globalArray,$theID);
    editOrderLine($globalArray,$theID,$checker);
    $globalArray = array(); //clears the array
  }
  function editPO($globalArray,$Project_ID) {
    include 'connectToServer.php'; //connects to the PHP for the server
    $sql = "UPDATE purchaseorder
            SET SupplierID = ?, DeliveryPrice = ?, DeliveryDestination = ?, VATOption = ?, DiscountPercent = ?, OtherCost = ?, TotalCost = ?, OrderDate = ?, DeliveryDate = ?, Status = ?, Notes = ?
            WHERE POID = ?"; //Defines the SQL for editing data in the database table
    $stmt = $conn->prepare($sql); //prepares the connection for the SQL
    //The $_POST array is a global array which stores the data passed from the form as the 'post' method is used
    $stmt->bind_param("ssssssssssss", $_POST['supID'], $_POST['delCost'], $_POST['delDest'], $_POST['VAT'], $_POST['discountPercent'], $_POST['costs'], $_POST['totalCost'], $_POST['ordDate'], $_POST['delDate'], $_POST['status'], $_POST['notes'], $_POST['POID']);
    //Sets each value form the array POST to a string
    $stmt->execute(); //executes the sql
    $stmt->close(); //closes the SQL
  }
  function editOrderLine($globalArray,$theID,$checker) {
    deleterecords('orderline',$globalArray,'POID','POID');
    if (isset($globalArray[$checker])) {
      newOrderLine($globalArray,$theID,$checker);
    }
  }
 ?>
