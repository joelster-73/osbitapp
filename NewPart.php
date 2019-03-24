<!DOCTYPE html>
<html>

<head>
	<!--imports CSS files-->
	<link rel="stylesheet" type="text/css" href="stylesMain.css" />
	<link rel="stylesheet" type="text/css" href="stylesForms.css" />
	<!--imports JS files-->
	<script type="text/javascript" src="scriptsMain.js" ></script>
	<script type="text/javascript" src="scriptsForms.js" ></script>
	<script type="text/javascript" src="scriptsFormsParts.js" ></script>
	<title>Parts | Create</title> <!--Appears in the tab-->
 	 <!--Used for the icon of the tab-->
    <link rel="icon" href="/Images/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="/Images/favicon.ico" type="image/x-icon" />
</head>

<!--This php connects this page to the server by carrying out the php script below-->
<?php
	include 'PHPFunctions-Part.php'; //used to connect the part functions for the tables
	include 'PHPFunctions-General.php'; //used to connect the part functions for the tables
	if (isset($_POST['formSubmitted'])) { //This checks whether the form has been submitted
		$message = "Successful submission"; //defines a value for the message
		$notUnique = checkUnique($_POST,'part','checkPart','PartID',$message); //checks all requisite fields unique
		if (!$notUnique) { //if all vlaues were unique
			if (isset($_POST['tablePartID'])) { //if there is a table
				$validIdentites = checkIdentites($_POST,'PartID','tablePartID','part',$message); //checks all IDs valid
				if ($validIdentites) { //if all IDs in the table in the form are valid
					newPartInfo($_POST,'tablePartID'); //calls the function for submitting the part data
				}
			} elseif ($_POST['partType'] == "Assembly") {
				$message = "Bill of materials required - please fill in table";
			} else {
				newPartInfo($_POST,'tablePartID'); //calls the function for submitting the part data as if no IDs then all validation passed
			}
		}
		echo "<script type='text/javascript'>window.alert('".$message."');</script>"; //echoes the appropiate message
	}
?>

<body onload="addNavBar('navigation',window.location.href); formStyling('formTable');">
  <div id="navigation"></div>

	<div class="content">

		<div id="titlebar"> <!--Titles for the page-->
			<h1>Parts</h1>
			<h2>Create a Part</h2>
		</div>

		<form id="mainForm" method="post" onchange="tableStyling('formTable','tableStyleTag');" onchange="tableStyling('formTable','tableStyleTag');">
			<h3>General Part Information</h3> <br> <!--Title of the form-->
			<label for="partName">Part Name <span class="red">*</span></label> <br>
			<input id="partName" name="partName" type="text" title="Please enter part name" pattern="[a-zA-Z0-9\s]+" oninvalid="setCustomValidity('Please enter letters and numbers only.')" oninput="setCustomValidity('')" required value='<?php if(isset($_POST["partName"])) echo $_POST["partName"]; ?>'><br><br>
			<label for="partDesc">Part Description</label> <br>
			<textarea id="partDesc" name="partDesc" type="text" rows="5" cols="55" title="Please enter part description" onkeyup="AutoGrowTextArea(this)"><?php if(isset($_POST["partDesc"])) echo $_POST["partDesc"]; ?></textarea><br><br>
			<label for="partType">Category Type <span class="red">*</span></label> <br>
			<!--Passes the value of the selected option into the 'showfield' function-->
			<select id="partType" name="partType" class='redArrow' onchange="showfield(this.options[this.selectedIndex].value)" required>
				<option value="">Select a type</option>
				<option value="Assembly">Assembly</option>
				<option value="Bespoke">Bespoke</option>
				<option value="Bought-in-Part" >Bought in Part</option>
			</select>
			<?php if (isset($_POST["partType"])) echo "<script>selectOption('redArrow', '".$_POST['partType']."');</script>";?>
			<br><br>
			<label for="supPartNum">Supplier's Part Number <span class="red">*</span></label> <br>
			<input id="supPartNum" name="supPartNum" type="text" title="Please enter supplier's part number" pattern="[a-zA-Z0-9\s]+" oninvalid="setCustomValidity('Please enter a valid supplier part name.')" oninput="setCustomValidity('')" required value='<?php if(isset($_POST["supPartNum"])) echo $_POST["supPartNum"]; ?>'><br><br>
			<label for="revisionNum">Revision Number <span class="red">*</span></label> <br>
			<input id="revisionNum" name="revisionNum" type="text" value="1" readonly><br><br>
			<label for="comCode">Commodity Code <span class="red">*</span></label> <br>
			<input id="comCode" name="comCode" type="text" title="Please enter supplier's part number" pattern="[a-zA-Z0-9\s]+" oninvalid="setCustomValidity('Please enter a valid commodity code.')" oninput="setCustomValidity('')" required value='<?php if(isset($_POST["comCode"])) echo $_POST["comCode"]; ?>'><br><br>
			<label for="attachFile">Attachment <span class="red">*</span></label> <br>
			<!--Can select pdf files only-->
			<input id="attachFile" name="attachFile" type="file" accept=".pdf "title="Please select an appropriate file" oninvalid="setCustomValidity('Please attach an appropriate file.')" oninput="setCustomValidity('')" required value='<?php if(isset($_POST["attachFile"])) echo $_POST["attachFile"]; ?>'><br><br>

			<div id="newCode">
			<?php if (isset($_POST["partType"]) && $_POST["partType"] == "Assembly" || isset($_POST["partType"]) && $_POST["partType"] == "Bought-in-Part") showTheField($_POST["partType"],$_POST); ?> <!--Calls a PHP function to add the inital table to the page-->
			</div> <!--Used for adding the table into the file-->

			<input type="button" value="Clear Form" onclick="resetForm(window.location.href)"><!--To clear form-->
			<input type="hidden" name="formSubmitted" value="1"><!--Used for PHP management-->
			<input type="submit" value="Submit data to database"><!--To submit data-->
		</form>

	</div>

</body>

</html>
