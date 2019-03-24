<!DOCTYPE html>
<html>

<!--This php connects this page to the server by carrying out the php script below-->
<?php
	include 'DeletePart.php'; //this is used to extract the data from the form
	$myRows = getTableInfo('part','PartID',$_GET['val']);//calls the function to get info
	extract($myRows);
	if (isset($BOMID) && $BOMID !== 'NULL') { //if the first function returns an appropiate result
		$results = getTableInfoMulti('billofmaterials','BOMID',$BOMID); //gets the array of results to iterate
	}
	if (isset($_POST['form_Submitted'])) { //checks whether the form has been submitted
      deleteRecordsTablesMulti(array(array('part','PartID','partID'),array('billofmaterials','BOMID','bomID')),$_POST); //deletes all records from the two tables
			echo "<script type='text/javascript'>window.alert('Part Deleted');window.location.href = 'DeletePart.php';</script>"; //redirects user and informs of deletion
  }
?>

<div class="content">

	<form id="mainForm"  method="post" onsubmit="return confirm('Do you really want to delete this record?');">
		<h3>General Part Information</h3> <br> <!--Title of the form-->

		<label for="partID">Part ID </label> <br>
		<input id="partID" type="text" name="partID" value="<?php echo $PartID; ?>" readonly><br><br>
		<label for="partName">Part Name</label> <br>
		<input id="partName" type="text" name="partName" value="<?php echo $PartName; ?>" readonly><br><br>
		<label for="partDesc">Part Description</label> <br>
		<textarea id="partDesc" type="text" rows="5" cols="55" name="partDesc" onkeyup="AutoGrowTextArea(this)" readonly><?php echo $Description; ?></textarea><br><br>
		<label for="partType">Category Type</label> <br>
		<!--Passes the value of the selected option into the 'showfield' function-->
		<select id="partType" name="partType" class='redArrow' onchange="showfield(this.options[this.selectedIndex].value,window.location.href)" disabled></label> <br>
			<option value="Base" selected>Select a type</option>
			<option value="Assembly" <?php if ($CategoryType == "Assembly") echo 'selected' ; ?>>Assembly</option>
			<option value="Bespoke" <?php if ($CategoryType == "Bespoke") echo 'selected' ; ?>>Bespoke</option>
			<option value="Bought-in-Part" <?php if ($CategoryType == "Bought-in-Part") echo 'selected' ; ?>>Bought in Part</option>
		</select>
		<br><br>
		<label for="supPartNum">Supplier's Part Number</label> <br>
		<input id="supPartNum" type="text" name="supPartNum" value="<?php echo $SupplierPartNum; ?>" readonly><br><br>
		<label for="revisionNum">Revision Number</label> <br>
		<input id="revisionNum" type="text" name="revisionNum" value="<?php echo $RevisionNum; ?>" readonly><br><br>
		<label for="comCode">Commodity Code</label> <br>
		<input id="comCode" type="text" name="comCode" value="<?php echo $CommodityCode; ?>" readonly><br><br>
		<label for="attachFile">Attachment</label> <br>
		<!--Can select pdf files only-->
		<input id="attachFile" name="attachFile" type="file" accept=".pdf" value="<?php echo $Attachment; ?>" disabled><br><br>

		<div id="newCode">
		<?php  if (isset($BOMID) && $BOMID !== 'NULL') showTheField($CategoryType,$results,$BOMID); ?> <!--Calls a PHP function to add the inital table to the page-->
		</div><br> <!--Used for adding the table into the file-->
		<input type="hidden" name="form_Submitted" value="1"><!--Used for PHP management-->
		<input type="submit" value="Delete Data from Database"> <!--To delete data-->
	</form>

</div>

</html>
