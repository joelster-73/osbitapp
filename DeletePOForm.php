<!DOCTYPE html>
<html>

<!--This php connects this page to the server by carrying out the php script below-->
<?php
	include 'DeletePO.php'; //connects the PHP file to obtain the information to be put into the
	include 'PHPFunctions-PO.php'; //used to connect the purchase order functions for the tables
	$check = 'tablePartID'; //used in conditional checking throughout the functions
	$theRows = getTableInfo('purchaseorder','POID',$_GET['val']); //calls the function to retrieve data
	extract($theRows); //makes every element a variable
	//the above function will redirect and thus refresh the page if nothing is returned
	if (isset($POID)) { //if the first function returned an appropiate variable
		$results = getTableInfoMulti('orderline','POID',$POID); //executes to get information
		$ProjectID = 0; //will indicate no attached project
		if (sizeof($results) > 0) { //if there is a result
			$ProjectID = $results[0]['ProjectID']; //gets the necessary ProjectID from this table
		}
	}
	if (isset($_POST['form_Submitted'])) { //checks the form has been submitted
		deleteRecordsTables(array('purchaseorder','orderline'),$_POST,'POID','POID'); //deletes all records from the two tables
		echo "<script type='text/javascript'>window.alert('Purchase Order Deleted');window.location.href = 'DeletePO.php';</script>"; //redirects user and informs of deletion
	}
?>

<div class="content">

	<form id="mainForm" method="post" onsubmit="return confirm('Do you really want to delete this record?');"><!--calls function when changes in form detected-->

		<h3>General Purchase Order Information</h3> <br> <!--Title of the form-->

		<label for="POID">Purchase Order ID </label> <br>
		<input id="POID" type="text" name="POID" value="<?php echo $POID; ?>" readonly><br><br>
		<label for="supID">Supplier ID </label> <br>
		<input id="supID" name="supID" type="text" value="<?php echo $SupplierID; ?>" readonly><br><br>
		<label for="delCost">Delivery Price </label> <br>
		<input id="delCost" name="delCost" class="money" value="<?php echo $DeliveryPrice; ?>" type="text" pattern="£[0-9,]*.[0-9]{2}" readonly><br><br> <!--Pattern for input using RegExp-->
		<label for="delDest">Delivery Destination ID  </label> <br>
		<input id="delDest" name="delDest" type="text" value="<?php echo $DeliveryDestination; ?>" readonly><br><br>
		<label for="VAT">VAT Rate  </label> <br> <!--temporarily implemented as %-->
		<input id="VAT" name="VAT" type="text" value="<?php echo $VATOption; ?>" readonly><br><br>
		<label for="discountPercent">Discount Percentage </label> <br>
		<input id="discountPercent" name="discountPercent" class="percent" type="text" pattern="[0-9]*.[0-9]*%" value="<?php echo $DiscountPercent; ?>" readonly><br><br>
		<!--Brings up inputs for selecting dates in user friendly fashion-->
		<label for="ordDate">Order Date  </label> <br>
		<input id="ordDate" name="ordDate" type="date" value="<?php echo $OrderDate; ?>" readonly><br><br>
		<label for="delDate">Delivery Date  </label> <br>
		<input id="delDate" name="delDate" type="date" value="<?php echo $DeliveryDate; ?>" readonly><br><br>
		<label for="status">Purchase Order Status </label> <br>
		<input id="status" name="status" type="text" value="<?php echo $Status; ?>" readonly><br><br>
		<label for="costs">Other Costs </label> <br>
		<input id="costs" name="costs" class="money" value="<?php echo $OtherCost; ?>" type="text" pattern="£[0-9,]*.[0-9]{2}" readonly><br><br>
		<label for="notes">Notes & Description </label> <br>
		<textarea id="notes" name="notes" type="text" rows="5" cols="55" onkeyup="AutoGrowTextArea(this)" readonly><?php echo $Notes; ?></textarea><br><br>
		<!--Function above called on the stroke of the user lifting their finger of a key-->


		<h3>Items on the Purchase Order </h3>

		<label for="projectID">Project ID </label> <br>
		<input id="projectID" name="projectID" type="text" value="<?php echo $ProjectID; ?>" readonly><br><br>
		<?php if (isset($results) && sizeof($results) > 0) { //checks whether the table needs to be loaded on the page
			echo "<table id='formTable' onchange='calcLinePrice(this)'><tr> <th>Item ID</th> <th>Quantity</th> <th>Unit Cost</th> <th>Line Price</th></tr> "; //table headers
		 	showTheField($results,$_SERVER['REQUEST_URI']);
			echo "</table> <br>";
			}
		?>

		<h3>Costs</h3>

		<label for="subtotal">Subtotal </label> <br>
		<input id="subtotal" class="money" value=0 type="text" name="subtotal" pattern="£[0-9]*.[0-9]{2}" readonly><br><br>
		<label for="totalCost">Total Cost (after VAT) </label> <br>
		<input id="totalCost" class="money" value="<?php echo $TotalCost; ?>" type="text" name="totalCost" pattern="£[0-9]*.[0-9]{2}" readonly><br><br>

		<input type="hidden" name="form_Submitted" value="1"><!--Used for PHP management-->
		<input type="submit" value="Delete Data from Database"> <!--To delete data-->

	</form>

</div>

</html>
