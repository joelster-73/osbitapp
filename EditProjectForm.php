<!DOCTYPE html>
<html>

<!--This calls the following PHP files-->
<?php
	include 'EditProject.php'; //connects the PHP file to the file containing the queried data
	include 'PHPFunctions-Project.php'; //used to connect the part functions for the tables
	$myRows = getTableInfo('project','ProjectID',$_GET['val']);//calls the function to get info
	extract($myRows);
	if (isset($ProjectID)) { //if the first function returns an appropiate result
		$results = getTableInfoMulti('item','ProjectID',$ProjectID); //gets the array of results to iterate
	}
	if (isset($_POST['form_Submitted'])) { //This checks whether this named item exists
		$message = "Successful submission"; //defines a value for the message
		$success = false; //condition for redirect at end
		if (isset($_POST['tablePartID'])) { //if there is a table
			$validIdentites = checkIdentites($_POST,'PartID','tablePartID','part',$message); //checks all IDs valid
			if ($validIdentites) { //if all IDs in the table in the form are valid
				$success = true;
			}
		} else {
			$success = true;
		}
		echo "<script type='text/javascript'>window.alert('".$message."');</script>"; //echoes the appropiate message
		if ($success) {
			editProjectInfo($_POST,$ProjectID,'tablePartID'); //edits the appropiate tables
			echo "<script type='text/javascript'>window.location.href='EditProject.php';</script>"; //redirects user to intermediate if successful edit
		}
	}
?>

<div class="content">

	<form id="mainForm" method="post">

		<h3>General Project Information</h3> <br> <!--Title of the form-->

		<label for="projectID">Project ID <span class="red">*</span></label> <br>
		<input id="projectID" type="text" name="projectID" value="<?php echo (isset($_POST['projectID']) ? $_POST['projectID'] : $ProjectID); ?>" readonly><br><br>
		<label for="projectName">Project Name <span class="red">*</span></label> <br>
		<input id="projectName" name="projectName" type="text" title="Please enter project name" required pattern="[a-zA-Z0-9\s]+" oninvalid="setCustomValidity('Please enter letters and numbers only.')" oninput="setCustomValidity('')" value='<?php echo (isset($_POST["projectName"]) ? $_POST["projectName"] : $ProjectName); ?>'><br><br>
		<label for="createDate">Creation Date <span class="red">*</span></label> <br>
		<input id="createDate" name="createDate" type="date" title="Please enter the creation date" required value='<?php echo (isset($_POST["createDate"]) ? $_POST["createDate"] : $CreationDate); ?>'><br><br>

		<h3>Parts of the Projects <span class='red'>*</span></h3>

		<table id='formTable'><tr> <th>Part ID</th> <th>Quantity</th> <th>Location</th> </tr>
			<?php if(isset($_POST["tablePartID"])) {
							showTheField($_POST);
						} elseif (sizeof($results) > 0){
							showTheField($results);
						} ?> <!--Calls a PHP function to add the inital table to the page-->
		</table> <br><br>

		<!--Buttons used for adding/removing row from table-->
		<input type='button' onclick='addRow("formTable")' value='Create Row'>
		<input type='button' onclick='delRow("formTable")' value='Delete Row'><br><br>
		<input type="hidden" name="form_Submitted" value="1"><!--Used for PHP management-->
		<input type="submit" value="Resubmit data to database"><!--To resubmit data-->
	</form>

</div>

</html>
