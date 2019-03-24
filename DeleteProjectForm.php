<!DOCTYPE html>
<html>

<!--This php connects this page to the server by carrying out the php script below-->
<?php
	include 'DeleteProject.php'; //this is used to extract the data from the form
	include 'PHPFunctions-Project.php'; //used to connect the part functions for the tables
	$myRows = getTableInfo('project','ProjectID',$_GET['val']);//calls the function to get info
	extract($myRows);
	if (isset($ProjectID)) { //if the first function returns an appropiate result
		$results = getTableInfoMulti('item','ProjectID',$ProjectID); //gets the array of results to iterate
	}
  if (isset($_POST['form_Submitted'])) { //checks the form has been submitted
		deleteRecordsTables(array('project','item'),$_POST,'ProjectID','projectID'); //deletes all records from the two tables
		echo "<script type='text/javascript'>window.alert('Project Deleted');window.location.href = 'DeleteProject.php';</script>"; //redirects user and informs of deletion
	}
?>

<div class="content">

	<form id="mainForm" method="post" onsubmit="return confirm('Do you really want to delete this record?');">

		<h3>General Project Information</h3> <br> <!--Title of the form-->

		<label for="projectID">Project ID </label> <br>
		<input id="projectID" type="text" name="projectID" value="<?php echo $ProjectID; ?>" readonly><br><br>
		<label for="projectName">Project Name </label> <br>
		<input id="projectName" type="text" name="projectName" value="<?php echo $ProjectName; ?>" readonly><br><br>
		<label for="createDate">Creation Date </label> <br>
		<input id="createDate" type="date" name="createDate" value="<?php echo $CreationDate; ?>" readonly><br><br>

		<?php if (isset($results) && sizeof($results) > 0) { //checks whether the table needs to be loaded on the page

			echo "<h3>Parts of the Projects <span class='red'>*</span></h3> <table id='formTable'><tr> <th>Part ID</th> <th>Quantity</th> <th>Location</th> </tr>"; //table headers
			showTheField($results); //table info
			echo "</table> <br><br>";
			}
		?>

		<input type="hidden" name="form_Submitted" value="1"><!--Used for PHP management-->
		<input type="submit" value="Delete Data from Database"><!--To resubmit data-->
	</form>

</div>

</html>
