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
	<title>Suppliers | Delete</title> <!--Appears in the tab-->
	<!--Used for defining the character set of the page - £ symbol-->
	<meta charset="utf-8"><!--Uses UTF-8-->
 	 <!--Used for the icon of the tab-->
    <link rel="icon" href="/Images/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="/Images/favicon.ico" type="image/x-icon" />
</head>

<!--This php connects this page to the server by carrying out the php script below-->
<?php
	include 'PHPFunctions-General.php'; //connects to file to call functions for suppliers
	if (isset($_GET['formSubmitted'])) {  //checks for the form to be submitted
		$exists = checkExists('supplier','SupplierID',$_GET['supID']);
		if ($exists) { //if the record has been found
			echo "<script type='text/javascript'>window.location.href='DeleteSupplierForm.php?val='+".$_GET['supID'].";</script>"; //redirects user to form to edit if supplier found
		} else {
			echo "<script type='text/javascript'>window.alert('This Supplier was not found'); window.location.href='EditSupplier.php';</script>"; //informed supplier not found if appropiate
		}
	}
?>

<body onload="addNavBar('navigation',window.location.href); formStyling('formTable');"><!--calls function when body loads-->
  <div id="navigation"></div>

	<div class="content">

		<div id="titlebar"> <!--Titles for the page-->
			<h1>Suppliers</h1>
			<h2>Delete a Supplier</h2>
		</div>

		<form id="miniForm" method="get">
			<h3>Find a Supplier to Delete</h3> <br>
			Supplier ID <span class="red">*</span> <br>
			<input id="supID" type="text" name="supID"><br><br>

			<input type="hidden" name="formSubmitted" value="1"><!--Used for PHP management-->
			<input type="submit" value="Find Supplier"><!--To retrieve data to be deleted-->
		</form>

	</div>

</body>

</html>
