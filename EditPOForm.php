<!DOCTYPE html>
<html>

<!--This php connects this page to the server by carrying out the php script below-->
<?php
	include 'EditPO.php'; //connects the PHP file to the file containing the queried data
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
	if (isset($_POST['formSubmitted'])) { //This checks whether this named item exists
		$message = "Successful submission"; //defines a value for the message
		if (checkExists('supplier','SupplierID',$_POST['supID'])) { //could be implemented in a function for checking multiple tables
			if (checkExists('project','ProjectID',$_POST['projectID'])) { //could be implemented in a function for checking multiple tables
				if (isset($_POST['tablePartID'])) { //if there is a table
					if (checkIdentites($_POST,'PartID','tablePartID','item',$message,array('ProjectID',$_POST['projectID']))) { //if all IDs in the table in the form are valid
						$success = true;
					}
				} else {
					$success = true;
				}
			} else {
				$message = "Project ID does not exist";
			}
		} else {
			$message = "Supplier ID does not exist";
		}
		echo "<script type='text/javascript'>window.alert('".$message."');</script>"; //echoes the appropiate message
		if ($success) {
			editPOInfo($_POST,'EditPO.php',$_POST['POID'],$check); //edits the appropiate tables
			echo "<script type='text/javascript'>window.location.href='EditPO.php';</script>"; //redirects user to intermediate if successful edit
		}
	}
?>

<div class="content">

	<form id="mainForm" onchange="calcTotalCost(); formatMoney(); formatPercent();" method="post"><!--calls function when changes in form detected-->

		<h3>General Purchase Order Information</h3> <br> <!--Title of the form-->

		<label for="POID">Purchase Order ID <span class="red">*</span></label> <br>
		<input id="POID" type="text" name="POID" value='<?php echo (isset($_POST["POID"]) ? $_POST["POID"] : $POID); ?>' readonly><br><br>
		<label for="supID">Supplier ID <span class="red">*</span></label> <br>
		<input id="supID" name="supID" type="text" title="Please enter supplier ID" required value='<?php echo (isset($_POST["supID"]) ? $_POST["supID"] : $SupplierID); ?>'><br><br>
		<label for="delCost">Delivery Price <span class="red">*</span></label> <br>
		<input id="delCost" name="delCost" class="money" type="text" title="Please enter cost for delievery" required pattern="£[0-9,]*.[0-9]{2}" oninvalid="setCustomValidity('Please enter a valid cost.')" oninput="setCustomValidity('')" value='<?php echo (isset($_POST["delCost"]) ? $_POST["delCost"] : $DeliveryPrice); ?>'><br><br> <!--Pattern for input using RegExp-->
		<label for="delDest">Delivery Destination ID <span class="red">*</span> </label> <br>
		<input id="delDest" name="delDest" type="text" title="Please enter delivery destination" required value='<?php echo (isset($_POST["delDest"]) ? $_POST["delDest"] : $DeliveryDestination); ?>'><br><br>
		<label for="VAT">VAT Rate <span class="red">*</span> </label> <br> <!--temporarily implemented as %-->
		<input id="VAT" name="VAT" type="text" class="percent" title="Please enter VAT rate" pattern="[0-9]*.[0-9]*%" required oninvalid="setCustomValidity('Please enter a valid VAT rate.')" oninput="setCustomValidity('')" value='<?php echo (isset($_POST["VAT"]) ? $_POST["VAT"]: $VATOption); ?>'><br><br>
		<label for="discountPercent">Discount Percentage </label> <br>
		<input id="discountPercent" name="discountPercent" class="percent" type="text" title="Please enter discount percentage" required pattern="[0-9]*.[0-9]*%" oninvalid="setCustomValidity('Please enter a valid percentage.')" oninput="setCustomValidity('')" value='<?php echo (isset($_POST["discountPercent"]) ? $_POST["discountPercent"] : $DiscountPercent); ?>'><br><br>
		<!--Brings up inputs for selecting dates in user friendly fashion-->
		<label for="ordDate">Order Date <span class="red">*</span> </label> <br>
		<input id="ordDate" name="ordDate" type="date" title="Please select order date" required value='<?php echo (isset($_POST["ordDate"]) ? $_POST["ordDate"] : $OrderDate); ?>'><br><br>
		<label for="delDate">Delivery Date <span class="red">*</span> </label> <br>
		<input id="delDate" name="delDate" type="date" title="Please select delivery date" required value='<?php echo (isset($_POST["delDate"]) ? $_POST["delDate"] : $DeliveryDate); ?>'><br><br>
		<label for="status">Purchase Order Status </label> <br>
		<input id="status" name="status" type="text" title="Please enter purchase order status" pattern="[a-zA-Z0-9\s]+" oninvalid="setCustomValidity('Please enter letters and numbers only.')" oninput="setCustomValidity('')" value='<?php echo (isset($_POST["status"]) ? $_POST["status"] : $Status); ?>'><br><br>
		<label for="costs">Other Costs </label> <br>
		<input id="costs" name="costs" class="money" type="text" title="Please enter other costs for purchase order" pattern="£[0-9,]*.[0-9]{2}" oninvalid="setCustomValidity('Please enter a valid cost.')" oninput="setCustomValidity('')" value='<?php echo (isset($_POST["costs"]) ? $_POST["costs"] : $OtherCost); ?>'><br><br>
		<label for="notes">Notes & Description </label> <br>
		<textarea id="notes" name="notes" type="text" rows="5" cols="55" onkeyup="AutoGrowTextArea(this)" title="Please enter notes and description for purchase order"><?php echo (isset($_POST["notes"]) ? $_POST["notes"] : $Notes); ?></textarea><br><br>
		<!--Function above called on the stroke of the user lifting their finger of a key-->

		<h3>Items on the Purchase Order <span class="red">*</span></h3>

		<label for="projectID">Project ID </label> <br>
		<input id="projectID" name="projectID" type="text" title="Please enter ID of project for which this is the purchase order" value='<?php echo (isset($_POST["projectID"]) ? $_POST["projectID"] : $ProjectID); ?>'><br><br>

		<table id='formTable' onchange="calcLinePrice(this)"> <!--passes this table as a parameter-->
		<!--When a change is detected in the table, the function above is called-->
			<tr> <th>Part ID</th> <th>Quantity</th> <th>Unit Cost</th> <th>Line Price</th></tr>
			<?php if(isset($_POST["tablePartID"])) {
							showTheField($_POST,$_SERVER['REQUEST_URI']);
						} elseif (sizeof($results) > 0){
							showTheField($results,$_SERVER['REQUEST_URI']);
						} ?>
		</table>
		<!--Buttons used for adding/removing row from table-->
		<input type='button' onclick='addRow("formTable")' value='Create Row'>
		<input type='button' onclick='delRow("formTable")' value='Delete Row'><br><br><br>

		<h3>Costs <span class="red">*</span> </h3>

		<label for="subtotal">Subtotal </label> <br>
		<input id="subtotal" name="subtotal" class="money" type="text" pattern="£[0-9,]*.[0-9]{2}" readonly><br><br>
		<label for="totalCost">Total Cost (after VAT) </label> <br>
		<input id="totalCost" name="totalCost" class="money" type="text" pattern="£[0-9,]*.[0-9]{2}" readonly><br><br>

		<input type="button" value="Clear Form" onclick="resetForm(window.location.href)"><!--To clear form-->
		<input type="hidden" name="formSubmitted" value="1"><!--Used for PHP management-->
		<input type="submit" value="Submit data to database"><!--To submit data-->

	</form>

</div>

</html>
