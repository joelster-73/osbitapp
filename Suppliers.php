<!DOCTYPE html>
<html>

<head>
	<!--imports CSS files-->
	<link rel="stylesheet" type="text/css" href="stylesMain.css"/>
	<!--imports JS files-->
	<script type="text/javascript" src="scriptsMain.js" ></script>
	<title>Suppliers</title> <!--Appears in the tab-->
	<!--Used for defining the character set of the page - £ symbol-->
	<meta charset="utf-8"><!--Uses UTF-8-->
 	 <!--Used for the icon of the tab-->
    <link rel="icon" href="/Images/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="/Images/favicon.ico" type="image/x-icon" />
</head>

<body onload="addNavBar('navigation',window.location.href)"><!--calls function when body loads-->
	<div id="navigation"></div>

	<div class="content">

		<div id="titlebar"> <!--Title for the page-->
			<h1>Suppliers</h1>
		</div>

		<table id="navMenu"><!--Defines four buttons in a table for a navigation menu-->
	    <tr><td><button onclick="window.location.href='NewSupplier.php'">Create</button></td><td><button onclick="window.location.href='EditSupplier.php'">Edit</button></td></tr>
	    <tr><td><button onclick="window.location.href='DeleteSupplier.php'">Delete</button></td><td><button onclick="window.location.href='ViewSuppliers.php'">View</button></td></tr>
	  </table>

	</div>

</body>

</html>
