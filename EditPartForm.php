<!DOCTYPE html>
<html>

<!--This calls the following PHP files-->
<?php
	include 'EditPart.php'; //connects the PHP file to the file containing the queried data
	include 'PHPFunctions-Part.php'; //connects the file to that which contains code for the edited data
	$myRows = getTableInfo('part','PartID',$_GET['val']);//calls the function to get info
	extract($myRows);
	if (isset($BOMID) && $BOMID !== 'NULL') { //if the first function returns an appropiate result
		$results = getTableInfoMulti('billofmaterials','BOMID',$BOMID); //gets the array of results to iterate
	}
	if (isset($_POST['form_Submitted'])) { //This checks whether the form has been submitted
		$message = "Successful submission"; //defines a value for the message
		$success = false; //condition for redirect at end
		$notUnique = checkUnique($_POST,'part','checkPart','PartID',$message,$_POST['partID']); //checks all requisite fields unique
		if (!$notUnique) { //if all vlaues were unique
			if (isset($_POST['tablePartID'])) { //if there is a table
				$validIdentites = checkIdentites($_POST,'PartID','tablePartID','part',$message); //checks all IDs valid
				if ($validIdentites) { //if all IDs in the table in the form are valid
					$success = true;
				}
			} elseif ($_POST['partType'] == "Assembly") {
				$message = "Bill of materials required - please fill in table";
			} else {
				$success = true;
			}
		}
		echo "<script type='text/javascript'>window.alert('".$message."');</script>"; //echoes the appropiate message
		if ($success) {
			editPartInfo($_POST,'tablePartID'); //edits the appropiate tables
			echo "<script type='text/javascript'>window.location.href='EditPart.php';</script>"; //redirects user to intermediate if successful edit
		}
}
?>

<div class="content">

	<form id="mainForm"  method="post">
		<h3>General Part Information</h3> <br> <!--Title of the form-->
		<label for="partID">Part ID <span class="red">*</span></label> <br>
		<input id="partID" type="text" name="partID" value="<?php  echo (isset($_POST['partID']) ? $_POST['partID'] : $PartID ); ?>" readonly><br><br>
		<label for="partName">Part Name <span class="red">*</span></label> <br>
		<input id="partName" name="partName" type="text" title="Please enter part name" pattern="[a-zA-Z0-9\s]+" oninvalid="setCustomValidity('Please enter letters and numbers only.')" oninput="setCustomValidity('')" required value='<?php  echo (isset($_POST['partName']) ? $_POST['partName'] : $PartName ); ?>'><br><br>
		<label for="partDesc">Part Description</label> <br>
		<textarea id="partDesc" name="partDesc" type="text" rows="5" cols="55" title="Please enter part description" onkeyup="AutoGrowTextArea(this)"><?php  echo (isset($_POST['partDesc']) ? $_POST['partDesc'] : $Description ); ?></textarea><br><br>
		<label for="partType">Category Type <span class="red">*</span></label> <br>
		<!--Passes the value of the selected option into the 'showfield' function-->
		<select id="partType" name="partType" class='redArrow' onchange="showfield(this.options[this.selectedIndex].value)" required>
			<option value="">Select a type</option>
			<option value="Assembly" >Assembly</option>
			<option value="Bespoke" >Bespoke</option>
			<option value="Bought-in-Part">Bought in Part</option>
		</select>
		<?php echo (isset($_POST["partType"])) ? "<script>selectOption('redArrow', '".$_POST['partType']."');</script>" : "<script>selectOption('redArrow', '".$CategoryType."');</script>";?>
		<br><br>
		<label for="supPartNum">Supplier's Part Number <span class="red">*</span></label> <br>
		<input id="supPartNum" name="supPartNum" type="text" title="Please enter supplier's part number" pattern="[a-zA-Z0-9\s]+" oninvalid="setCustomValidity('Please enter a valid supplier part name.')" oninput="setCustomValidity('')" required value='<?php  echo (isset($_POST['supPartNum']) ? $_POST['supPartNum'] : $SupplierPartNum ); ?>'><br><br>
		<label for="revisionNum">Revision Number <span class="red">*</span></label> <br>
		<input id="revisionNum" name="revisionNum" type="text" value="<?php  echo (isset($_POST['revisionNum']) ? $_POST['revisionNum'] : $RevisionNum ); ?>"><br><br>
		<label for="comCode">Commodity Code <span class="red">*</span></label> <br>
		<input id="comCode" name="comCode" type="text" title="Please enter supplier's part number" pattern="[a-zA-Z0-9\s]+" oninvalid="setCustomValidity('Please enter a valid commodity code.')" oninput="setCustomValidity('')" required value='<?php  echo (isset($_POST['comCode']) ? $_POST['comCode'] : $CommodityCode ); ?>'><br><br>
		<label for="attachFile">Attachment <span class="red">*</span></label> <br>
		<!--Can select pdf files only-->
		<input id="attachFile" name="attachFile" type="file" accept=".pdf "title="Please select an appropriate file" oninvalid="setCustomValidity('Please attach an appropriate file.')" oninput="setCustomValidity('')" required value='<?php  echo (isset($_POST['attachFile']) ? $_POST['attachFile'] : $Attachment ); ?>'><br><br>

		<div id="newCode">
		<?php if (isset($_POST["partType"]) && isset($_POST["tablePartID"])) {
				 		if ($_POST["partType"] == "Assembly" || $_POST["partType"] == "Bought-in-Part") showTheField($_POST["partType"],$_POST,$_POST["bomID"]);
				 	} elseif (isset($CategoryType) && ($CategoryType == "Assembly" || $CategoryType == "Bought-in-Part")) {
					 	showTheField($CategoryType,$results,$BOMID);
				 	} elseif (sizeof($results) > 0){
					 	echo "<script>showfield('".$_POST["partType"]."')</script>";
				 	} ?> <!--Calls a PHP function to add the inital table to the page-->

		</div><br> <!--Used for adding the table into the file-->
		<input type="hidden" name="form_Submitted" value="1"><!--Used for PHP management-->
		<input type="submit" value="Resubmit data to database"><!--To resubmit data-->
	</form>

</div>

</html>
