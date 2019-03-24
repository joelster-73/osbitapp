<!DOCTYPE html>
<html>

<head>
	<!--imports CSS files-->
	<link rel="stylesheet" type="text/css" href="stylesMain.css" />
	<link rel="stylesheet" type="text/css" href="stylesForms.css" />
	<!--imports JS files-->
	<script type="text/javascript" src="scriptsMain.js" ></script>
	<script type="text/javascript" src="scriptsForms.js" ></script>
	<script type="text/javascript" src="scriptsFormsProjects.js" ></script>
	<title>Projects | Create</title> <!--Appears in the tab-->
	<!--Used for defining the character set of the page - £ symbol-->
	<meta charset="utf-8"><!--Uses UTF-8-->
 	 <!--Used for the icon of the tab-->
    <link rel="icon" href="/Images/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="/Images/favicon.ico" type="image/x-icon" />
</head>

<!--This php connects this page to the server by carrying out the php script below-->
<?php
	include 'PHPFunctions-Project.php'; //used to connect the part functions for the tables
	include 'PHPFunctions-General.php'; //used to connect the part functions for the tables
	if (isset($_POST['formSubmitted'])) { //This checks whether this named item exists
		$message = "Successful submission"; //defines a value for the message
		if (isset($_POST['tablePartID'])) { //if there is a table
			$validIdentites = checkIdentites($_POST,'PartID','tablePartID','part',$message); //checks all IDs valid
			if ($validIdentites) { //if all IDs in the table in the form are valid
				newProjectInfo($_POST,'tablePartID'); //calls the function for submitting the part data
			}
		} else {
			newProjectInfo($_POST,'tablePartID'); //calls the function for submitting the part data as if no IDs then all validation passed
		}
		echo "<script type='text/javascript'>window.alert('".$message."');</script>"; //echoes the appropiate message
	}
?>

<body onload="addNavBar('navigation',window.location.href); setDate(); formStyling('formTable');" onchange="tableStyling('formTable','tableStyleTag');"><!--calls function when body loads-->
	<div id="navigation"></div>

	<div class="content">

		<div id="titlebar"> <!--Titles for the page-->
			<h1>Projects</h1>
			<h2>Create a Project</h2>
		</div>

		<form id="mainForm" method="post">
			<h3>General Project Information</h3> <br> <!--Title of the form-->
			<label for="projectName">Project Name <span class="red">*</span></label> <br>
			<input id="projectName" name="projectName" type="text" title="Please enter project name" required pattern="[a-zA-Z0-9\s]+" oninvalid="setCustomValidity('Please enter letters and numbers only.')" oninput="setCustomValidity('')" value='<?php if(isset($_POST["projectName"])) echo $_POST["projectName"]; ?>'><br><br>
			<label for="createDate">Creation Date <span class="red">*</span></label> <br>
			<input id="createDate" name="createDate" type="date" title="Please enter the creation date" required value='<?php echo (isset($_POST["createDate"]) ? $_POST["createDate"] : '2001-05-10'); ?>'><br><br>
			<h3>Parts of the Projects </h3>
			<table id='formTable'>
				<tr> <th>Part ID</th> <th>Quantity</th> <th>Location</th> </tr>
				<?php if (isset($_POST["tablePartID"])) showTheField($_POST); ?>
			</table>
			<!--Buttons used for adding/removing row from table-->
			<input type='button' onclick='addRow("formTable")' value='Create Row'>
			<input type='button' onclick='delRow("formTable")' value='Delete Row'><br><br>
			<input type="button" value="Clear Form" onclick="resetForm(window.location.href)"><!--To clear form-->
			<input type="hidden" name="formSubmitted" value="1"><!--Used for PHP management-->
			<input type="submit" value="Submit data to database"><!--To submit data-->
		</form>

	</div>


</body>

</html>
