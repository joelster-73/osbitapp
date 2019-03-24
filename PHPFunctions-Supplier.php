<?php
  function checkSupplier($globalArray,$row,&$error,&$message) { //function to check the supplier values
    extract($row); //extracts the varaibles from the array
    $error = 1;  //presets that there has been an error
    if ($TelephoneNum==$globalArray['supTeleNum']) { //if the input is in the database - not unique
      $message = "Telephone Number already exists"; //returns the approiate error message
    } elseif ($AddressLine1==$globalArray['supAddressL1'] && $AddressPostcode==$globalArray['supAddressPostcode']) {
      $message = "Address Line 1 and Postcode Combination already exists";
    } elseif ($SupplierEmail==$globalArray['supEmail']) {
      $message = "Email already exists";
    } elseif ($SupplierFax==$globalArray['supFax']) {
      $message = "Fax already exists";
    } else {
      $error = 0; //there has been no error
    }
  }
  function newSupplierInfo(&$globalArray) { //function called for the form
    newSupplier($globalArray);
    $globalArray = array();
  }
  function newSupplier($globalArray) {
    include 'connectToServer.php'; //connects to the PHP for the server
    $sql = "INSERT INTO supplier (SupplierName, TelephoneNum, AddressLine1, AddressLine2, AddressTown, AddressCounty, AddressPostcode, SupplierEmail, SupplierFax)
            VALUES (?,?,?,?,?,?,?,?,?);"; //Defines the SQL for inputting data into the database table
    $stmt = $conn->prepare($sql); //prepares the connection for the SQL
    //The $globalArray array is a global array which stores the data passed from the form as the 'post' method is used
    $stmt->bind_param("sssssssss", $globalArray['supName'], $globalArray['supTeleNum'], $globalArray['supAddressL1'], $globalArray['supAddressL2'], $globalArray['supAddressTown'], $globalArray['supAddressCounty'], $globalArray['supAddressPostcode'], $globalArray['supEmail'], $globalArray['supFax']);
    //Sets each value form the array POST to a string
    $stmt->execute(); //executes the sql
    $stmt->close(); //closes the SQL
    $conn->close(); //closes the connection
  }
  function editSupplierInfo(&$globalArray) { //function called for the form
    editSupplier($globalArray);
    $globalArray = array(); //clears the array
  }
  function editSupplier($globalArray) { //made specific for the supplier - does not need to be as dynamic
    include 'connectToServer.php'; //connects to the PHP for the server
    $sql = "UPDATE supplier
            SET SupplierName = ?, TelephoneNum = ?, AddressLine1 = ?, AddressLine2 = ?, AddressTown = ?, AddressCounty = ?, AddressPostcode = ?, SupplierEmail = ?, SupplierFax = ?
            WHERE SupplierID = ?"; //Defines the SQL for editing data in the database table
    $stmt = $conn->prepare($sql); //prepares the connection for the SQL
    //The $globalArray array is a global array which stores the data passed from the form as the 'post' method is used
    $stmt->bind_param("ssssssssss", $globalArray['supName'], $globalArray['supTeleNum'], $globalArray['supAddressL1'], $globalArray['supAddressL2'], $globalArray['supAddressTown'], $globalArray['supAddressCounty'], $globalArray['supAddressPostcode'], $globalArray['supEmail'], $globalArray['supFax'], $globalArray['supID']);
    //Sets each value form the array POST to a string
    $stmt->execute(); //executes the sql
    $stmt->close(); //closes the SQL
    $conn->close(); //closes the connection
  }
 ?>
