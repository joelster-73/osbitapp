<!DOCTYPE html>
<html>

<!--This php connects this page to the server by carrying out the php script below-->
<?php
	include 'DeleteSupplier.php'; //connects the PHP file to the file containing the queried data
	$myRows = getTableInfo('supplier','SupplierID',$_GET['val']);//calls the function to get info
	extract($myRows);
	if (isset($_POST['form_Submitted'])) { //checks whether the form has been submitted
		deleteRecordsTables(array('supplier'),$_POST,'SupplierID','supID');
		echo "<script type='text/javascript'>window.alert('Supplier Deleted');window.location.href = 'DeleteSupplier.php';</script>"; //redirects user and informs of deletion
	}
?>

<div class="content">

	<form id="mainForm" method="post" onsubmit="return confirm('Do you really want to delete this record?');">
		<h3>General Supplier Information</h3> <br> <!--Title of the form-->
		<label for="supID">Supplier ID <span class="red">*</span></label> <br>
		<input id="supID" type="text" name="supID" value="<?php  echo (isset($_POST['supID']) ? $_POST['supID'] : $SupplierID ); ?>" readonly><br><br>
		<label for="supName">Supplier Name <span class="red">*</span></label> <br>
		<input id="supName" type="text" name="supName" value='<?php  echo (isset($_POST['supName']) ? $_POST['supName'] : $SupplierName ); ?>'><br><br>
		<label for="supTeleNum">Telephone Number <span class="red">*</span></label> <br>
		<input id="supTeleNum" type="tel" name="supTeleNum" value='<?php echo (isset($_POST['supTeleNum']) ? $_POST['supTeleNum'] : $TelephoneNum ); ?>'><br><br>
		<label for="supAddressL1">Address Line 1 <span class="red">*</span></label> <br>
		<input id="supAddressL1" type="text" name="supAddressL1" value='<?php echo (isset($_POST['supAddressL1']) ? $_POST['supAddressL1'] : $AddressLine1 ); ?>'><br><br>
		<label for="supAddressL2">Address Line 2</label> <br>
		<input id="supAddressL2" type="text" name="supAddressL2" value='<?php echo (isset($_POST['supAddressL2']) ? $_POST['supAddressL2'] : $AddressLine2 ); ?>'><br><br>
		<label for="supAddressTown">Town</label> <br>
		<input id="supAddressTown" type="text" name="supAddressTown" value='<?php echo (isset($_POST['supAddressTown']) ? $_POST['supAddressTown'] : $AddressTown ); ?>'><br><br>
		<label for="supAddressCounty">County</label> <br>
		<input id="supAddressCounty" type="text" name="supAddressCounty" value='<?php echo (isset($_POST['supAddressCounty']) ? $_POST['supAddressCounty'] : $AddressCounty ); ?>'><br><br>
		<label for="supAddressPostcode">Postcode <span class="red">*</span></label> <br>
		<input id="supAddressPostcode" type="text" name="supAddressPostcode" value='<?php echo (isset($_POST['supAddressPostcode']) ? $AddressPostcode : $AddressPostcode ); ?>'><br><br>
		<label for="supEmail">Email <span class="red">*</span> </label> <br>
		<input id="supEmail" type="email" name="supEmail" value='<?php echo (isset($_POST['supEmail']) ? $_POST['supEmail'] : $SupplierEmail ); ?>'><br><br>
		<label for="supFax">Fax Number</label> <br>
		<input id="supFax" name="supFax" type="tel" name="supFax" value='<?php echo (isset($_POST['supFax']) ? $_POST['supFax'] : $SupplierFax ); ?>'><br><br>

		<input type="hidden" name="form_Submitted" value="1"><!--Used for PHP management-->
		<input type="submit" value="Delete Data from Database"> <!--To delete data-->
	</form>

</div>

</html>
