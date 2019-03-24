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
	<title>Parts | Edit</title> <!--Appears in the tab-->
	<!--Used for defining the character set of the page - £ symbol-->
	<meta charset="utf-8"><!--Uses UTF-8-->
 	 <!--Used for the icon of the tab-->
    <link rel="icon" href="/Images/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="/Images/favicon.ico" type="image/x-icon" />
</head>

<!--This php connects this page to the server by carrying out the php script below-->
<?php
	include 'PHPFunctions-General.php'; //used to connect the general functions for the tables
	if (isset($_GET['formSubmitted'])) {  //checks for the form to be submitted
		$exists = checkExists('part','PartID',$_GET['partID']);
		if ($exists) { //if the record has been found
			echo "<script type='text/javascript'>window.location.href='EditPartForm.php?val='+".$_GET['partID'].";</script>"; //redirects user to form to edit if supplier found
		} else {
			echo "<script type='text/javascript'>window.alert('This Part was not found'); window.location.href='EditPart.php';</script>"; //informed supplier not found if appropiate
		}
	}
?>

<body onload="addNavBar('navigation',window.location.href); formStyling('formTable');" onchange="tableStyling('formTable','tableStyleTag');"><!--calls function when body loads-->
  <div id="navigation"></div>

  <div class="content">

		<div id="titlebar"> <!--Titles for the page-->
			<h1>Parts</h1>
			<h2>Edit a Part</h2>
		</div>

		<form id="miniForm" method="get">
			<h3>Find a Part to Edit</h3> <br> <!--Title of the form-->

			<label for="partID">Part ID <span class="red">*</span></label> <br>
			<input id="partID" type="text" name="partID"><br><br>

			<input type="hidden" name="formSubmitted" value="1"><!--Used for PHP management-->
			<input type="submit" value="Find Part"><!--To retrieve data to be editted-->
		</form>

  </div>

</body>

</html>
