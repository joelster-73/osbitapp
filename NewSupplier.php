<!DOCTYPE html>
<html>

<head>
	<!--imports CSS files-->
	<link rel="stylesheet" type="text/css" href="stylesMain.css" />
	<link rel="stylesheet" type="text/css" href="stylesForms.css" />
	<!--imports JS files-->
	<script type="text/javascript" src="scriptsMain.js" ></script>
	<script type="text/javascript" src="scriptsForms.js" ></script>
	<script type="text/javascript" src="scriptsFormsSuppliers.js" ></script>
	<title>Suppliers | Create</title> <!--Appears in the tab-->
	<!--Used for defining the character set of the page - £ symbol-->
	<meta charset="utf-8"><!--Uses UTF-8-->
 	 <!--Used for the icon of the tab-->
    <link rel="icon" href="/Images/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="/Images/favicon.ico" type="image/x-icon" />
</head>

<!--This calls the following PHP files-->
<?php
	include 'PHPFunctions-General.php'; //includes this file for the functions
	include 'PHPFunctions-Supplier.php'; //includes this file for the functions
	if (isset($_POST['formSubmitted'])) { //This checks whether the form has been submitted
		$message = "Successful submission"; //defines a value for the message
		$notUnique = checkUnique($_POST,'supplier','checkSupplier','SupplierID',$message); //gets the returned values from the function for checking the unique values
		if (!$notUnique) { //if all vlaues were unique
			newSupplierInfo($_POST); //calls the function for submitting the supplier data
		}
		echo "<script type='text/javascript'>window.alert('".$message."');</script>"; //echoes the appropiate message
	}
?>

<body onload="addNavBar('navigation',window.location.href); formStyling('formTable');" onchange="tableStyling('formTable','tableStyleTag');"><!--calls function when body loads-->
	<div id="navigation"></div>

	<div class="content">

		<div id="titlebar"> <!--Titles for the page-->
			<h1>Suppliers</h1>
			<h2>Create a Supplier</h2>
		</div>

		<form id="mainForm" method="post">
			<h3>General Supplier Information</h3> <br> <!--Title of the form-->
			<label for="supName">Supplier Name <span class="red">*</span></label> <br>
			<input id="supName" type="text" name="supName" title="Please enter supplier name" pattern="[a-zA-Z0-9\s]+" oninvalid="setCustomValidity('Please enter letters and numbers only.')" oninput="setCustomValidity('')" required value='<?php if(isset($_POST["supName"])) echo $_POST["supName"]; ?>'><br><br>
			<label for="supTeleNum">Telephone Number <span class="red">*</span></label> <br>
			<input id="supTeleNum" type="tel" name="supTeleNum" title="Please enter supplier's telephone number" placeholder="888-888-8888" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" maxlength="12" title="Ten digits code" required value='<?php if(isset($_POST["supTeleNum"])) echo $_POST["supTeleNum"]; ?>'><br><br>
			<label for="supAddressL1">Address Line 1 <span class="red">*</span></label> <br>
			<input id="supAddressL1" type="text" name="supAddressL1" title="Please enter the first line of the address" oninvalid="setCustomValidity('Please enter letters and numbers only.')" oninput="setCustomValidity('')" required pattern="[a-zA-Z0-9\s]+" value='<?php if(isset($_POST["supAddressL1"])) echo $_POST["supAddressL1"]; ?>'><br><br>
			<label for="supAddressL2">Address Line 2</label> <br>
			<input id="supAddressL2" type="text" name="supAddressL2" title="Please enter the second line of the address" oninvalid="setCustomValidity('Please enter letters and numbers only.')" oninput="setCustomValidity('')" pattern="[a-zA-Z0-9\s]+" value='<?php if(isset($_POST["supAddressL2"])) echo $_POST["supAddressL2"]; ?>'><br><br>
			<label for="supAddressTown">Town</label> <br>
			<input id="supAddressTown" type="text" name="supAddressTown" title="Please enter the town of the address" oninvalid="setCustomValidity('Please enter letters and numbers only.')" oninput="setCustomValidity('')" pattern="[a-zA-Z0-9\s]+" value='<?php if(isset($_POST["supAddressTown"])) echo $_POST["supAddressTown"]; ?>'><br><br>
			<label for="supAddressCounty">County</label> <br>
			<input id="supAddressCounty" type="text" name="supAddressCounty" title="Please enter the county of the address" oninvalid="setCustomValidity('Please enter letters and numbers only.')" oninput="setCustomValidity('')" pattern="[a-zA-Z0-9\s]+" value='<?php if(isset($_POST["supAddressCounty"])) echo $_POST["supAddressCounty"]; ?>'><br><br>
			<label for="supAddressPostcode">Postcode <span class="red">*</span></label> <br>
			<input id="supAddressPostcode" type="text" name="supAddressPostcode" title="Please enter the postcode of the address" required oninvalid="setCustomValidity('Please enter a valid postcode.')" oninput="setCustomValidity('')" pattern="[A-Za-z]{1,2}[0-9Rr][0-9A-Za-z]? [0-9][ABD-HJLNP-UW-Zabd-hjlnp-uw-z]{2}" value='<?php if(isset($_POST["supAddressPostcode"])) echo $_POST["supAddressPostcode"]; ?>'><br><br>
			<label for="supEmail">Email <span class="red">*</span> </label> <br>
			<input id="supEmail" type="email" name="supEmail" title="Please enter a valid email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="fake@email.com" oninvalid="setCustomValidity('Please enter a valid email.')" oninput="setCustomValidity('')" required value='<?php if(isset($_POST["supEmail"])) echo $_POST["supEmail"]; ?>'><br><br>
			<label for="supFax">Fax Number</label> <br>
			<input id="supFax" name="supFax" type="tel" name="supFax" title="Please enter the supplier's fax number" placeholder="888-888-8888" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" maxlength="12" title="Ten digits code" value='<?php if(isset($_POST["supFax"])) echo $_POST["supFax"]; ?>'><br><br>

			<input type="button" value="Clear Form" onclick="resetForm(window.location.href)"><!--Clear Form-->
			<input type="hidden" name="formSubmitted" value="1"><!--Used for PHP management-->
			<input type="submit" value="Submit Data to Database"> <!--Submit data-->
		</form>

	</div>

</body>

</html>
