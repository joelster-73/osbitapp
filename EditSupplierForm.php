<!DOCTYPE html>
<html>

<!--This calls the following PHP files-->
<?php
	include 'EditSupplier.php'; //connects the PHP file to the file containing the queried data
	include 'PHPFunctions-Supplier.php'; //connects the file to that which contains code for the edited data
	$myRows = getTableInfo('supplier','SupplierID',$_GET['val']);//calls the function to get info
	extract($myRows);
	if (isset($_POST['form_Submitted'])) { //This checks whether the form has been submitted
		$message = "Successful submission"; //defines a value for the message
		$notUnique = checkUnique($_POST,'supplier','checkSupplier','SupplierID',$_POST['supID'],$message); //gets the returned values from the function for checking the unique values
		echo "<script type='text/javascript'>window.alert('$message');</script>"; //echoes the appropiate message
		if (!$notUnique) { //if all vlaues were unique
			editSupplierInfo($_POST);
		}
	}
?>

<div class="content">

	<form id="mainForm" method="post">
		<h3>General Supplier Information</h3> <br> <!--Title of the form-->
		<label for="supID">Supplier ID <span class="red">*</span></label> <br>
		<input id="supID" type="text" name="supID" value="<?php  echo (isset($_POST['supID']) ? $_POST['supID'] : $SupplierID ); ?>" readonly><br><br>
		<label for="supName">Supplier Name <span class="red">*</span></label> <br>
		<input id="supName" type="text" name="supName" title="Please enter supplier name" pattern="[a-zA-Z0-9\s]+" oninvalid="setCustomValidity('Please enter letters and numbers only.')" oninput="setCustomValidity('')" required value='<?php  echo (isset($_POST['supName']) ? $_POST['supName'] : $SupplierName ); ?>'><br><br>
		<label for="supTeleNum">Telephone Number <span class="red">*</span></label> <br>
		<input id="supTeleNum" type="tel" name="supTeleNum" title="Please enter supplier's telephone number" placeholder="888-888-8888" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" maxlength="12" title="Ten digits code" required value='<?php echo (isset($_POST['supTeleNum']) ? $_POST['supTeleNum'] : $TelephoneNum ); ?>'><br><br>
		<label for="supAddressL1">Address Line 1 <span class="red">*</span></label> <br>
		<input id="supAddressL1" type="text" name="supAddressL1" title="Please enter the first line of the address" oninvalid="setCustomValidity('Please enter letters and numbers only.')" oninput="setCustomValidity('')" required pattern="[a-zA-Z0-9\s]+" value='<?php echo (isset($_POST['supAddressL1']) ? $_POST['supAddressL1'] : $AddressLine1 ); ?>'><br><br>
		<label for="supAddressL2">Address Line 2</label> <br>
		<input id="supAddressL2" type="text" name="supAddressL2" title="Please enter the second line of the address" oninvalid="setCustomValidity('Please enter letters and numbers only.')" oninput="setCustomValidity('')" pattern="[a-zA-Z0-9\s]+" value='<?php echo (isset($_POST['supAddressL2']) ? $_POST['supAddressL2'] : $AddressLine2 ); ?>'><br><br>
		<label for="supAddressTown">Town</label> <br>
		<input id="supAddressTown" type="text" name="supAddressTown" title="Please enter the town of the address" oninvalid="setCustomValidity('Please enter letters and numbers only.')" oninput="setCustomValidity('')" pattern="[a-zA-Z0-9\s]+" value='<?php echo (isset($_POST['supAddressTown']) ? $_POST['supAddressTown'] : $AddressTown ); ?>'><br><br>
		<label for="supAddressCounty">County</label> <br>
		<input id="supAddressCounty" type="text" name="supAddressCounty" title="Please enter the county of the address" oninvalid="setCustomValidity('Please enter letters and numbers only.')" oninput="setCustomValidity('')" pattern="[a-zA-Z0-9\s]+" value='<?php echo (isset($_POST['supAddressCounty']) ? $_POST['supAddressCounty'] : $AddressCounty ); ?>'><br><br>
		<label for="supAddressPostcode">Postcode <span class="red">*</span></label> <br>
		<input id="supAddressPostcode" type="text" name="supAddressPostcode" title="Please enter the postcode of the address" required oninvalid="setCustomValidity('Please enter a valid postcode.')" oninput="setCustomValidity('')" pattern="[A-Za-z]{1,2}[0-9Rr][0-9A-Za-z]? [0-9][ABD-HJLNP-UW-Zabd-hjlnp-uw-z]{2}" value='<?php echo (isset($_POST['supAddressPostcode']) ? $AddressPostcode : $AddressPostcode ); ?>'><br><br>
		<label for="supEmail">Email <span class="red">*</span> </label> <br>
		<input id="supEmail" type="email" name="supEmail" title="Please enter a valid email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="fake@email.com" oninvalid="setCustomValidity('Please enter a valid email.')" oninput="setCustomValidity('')" required value='<?php echo (isset($_POST['supEmail']) ? $_POST['supEmail'] : $SupplierEmail ); ?>'><br><br>
		<label for="supFax">Fax Number</label> <br>
		<input id="supFax" name="supFax" type="tel" name="supFax" title="Please enter the supplier's fax number" placeholder="888-888-8888" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" maxlength="12" title="Ten digits code" value='<?php echo (isset($_POST['supFax']) ? $_POST['supFax'] : $SupplierFax ); ?>'><br><br>

		<input type="hidden" name="form_Submitted" value="1"><!--Used for PHP management-->
		<input type="submit" value="Resubmit Data to Database"><!--To resubmit data-->
	</form>

</div>

</html>
