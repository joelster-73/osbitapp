<!DOCTYPE html>
<html>

<head>
	<!--imports CSS files-->
	<link rel="stylesheet" type="text/css" href="stylesMain.css" />
	<link rel="stylesheet" type="text/css" href="stylesForms.css" />
	<!--imports JS files-->
	<script type="text/javascript" src="scriptsMain.js" ></script>
	<script type="text/javascript" src="scriptsForms.js" ></script>
	<script type="text/javascript" src="scriptsFormsPOs.js" ></script>
	<title>Purchase Orders | Delete</title> <!--Appears in the tab-->
	<!--Used for defining the character set of the page - £ symbol-->
	<meta charset="utf-8"><!--Uses UTF-8-->
 	 <!--Used for the icon of the tab-->
    <link rel="icon" href="/Images/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="/Images/favicon.ico" type="image/x-icon" />
</head>

<!--This php connects this page to the server by carrying out the php script below-->
<?php
	include 'PHPFunctions-General.php'; //used to connect the general functions for the tables
	if (isset($_GET['formSubmitted'])) {
		$exists = checkExists('purchaseorder','POID',$_GET['POID']);
		if ($exists) { //if the record has been found
			echo "<script type='text/javascript'>window.location.href='DeletePOForm.php?val='+".$_GET['POID'].";</script>"; //redirects user to form to edit if supplier found
		} else {
			echo "<script type='text/javascript'>window.alert('This Purchase Order was not found'); window.location.href='DeletePO.php';</script>"; //informed supplier not found if appropiate
		}
	}
?>

<body onload="addNavBar('navigation',window.location.href); formStyling('formTable'); calcTotalCost(); formatMoney(); formatPercent();"><!--calls function when body loads-->
  <div id="navigation"></div>

	<div class="content">

		<div id="titlebar"> <!--Titles for the page-->
			<h1>Purchase Orders</h1>
			<h2>Delete a Purchase Order</h2>
		</div>

		<form id="miniForm" method="get">

			<h3>Find a Purchase Order to Delete</h3> <br> <!--Title of the form-->

			<label for="POID">Purchase Order ID <span class="red">*</span> </label> <br>
			<input id="POID" type="text" name="POID"><br><br>

			<input type="hidden" name="formSubmitted" value="1"><!--Used for PHP management-->
			<input type="submit" value="Find Purchase Order"> <!--To delete data-->

		</form>

	</div>

</body>

</html>
