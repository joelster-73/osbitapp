<!DOCTYPE html>
<html>

<head>
	<!--imports CSS files-->
	<link rel="stylesheet" type="text/css" href="stylesMain.css" />
	<!--imports JS files-->
	<script type="text/javascript" src="scriptsMain.js" ></script>
	<title>Parts | Create</title> <!--Appears in the tab-->
	<!--Used for defining the character set of the page - £ symbol-->
	<meta charset="utf-8"><!--Uses UTF-8-->
 	<!--Used for the icon of the tab-->
    <link rel="icon" href="/Images/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="/Images/favicon.ico" type="image/x-icon" />
</head>

<!--This php connects this page to the server by carrying out the php script below-->
<?php
	include 'connectToServer.php';
?>

<body onload="addNavBar('navigation',window.location.href)"><!--calls function when body loads-->
	<div id="navigation"></div>

	<div class="content">

		<div id="titlebar"> <!--Titles for the page-->
			<h1>Projects</h1>
			<h2>View Projects</h2>
		</div>

	</div>

</body>
</html>
