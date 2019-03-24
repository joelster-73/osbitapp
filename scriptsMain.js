function AutoGrowTextArea(textField) { //Function for textarea to increase height when typed in across all pages
	if (textField.clientHeight < textField.scrollHeight) {
		textField.style.height = textField.scrollHeight + "px"; //Changes height of area to that of the scroll area - the amount of lines if spread out
		if (textField.clientHeight < textField.scrollHeight) {
			textField.style.height = (textField.scrollHeight * 2 - textField.clientHeight) + "px";
		}
	}
}
function selectOption(theList, criterion, position=0) { //function to assign select to an option
	//takes the list name, in this case the class name, what's being checked and the position in the ultimate list - the $counter
	var lists = document.getElementsByClassName(theList); //gets all the lists by the class name
	for (i=0; i<lists[position].options.length; i++) { //access them through iteration
		if (lists[position].options[i].value == criterion) { //checks if the value matches the criterion
			lists[position].options[i].selected = true; //if so, selects this option
		}
	}
}
function addNavBar(theID,url) { //Function for adding the navigation bar to the top of the page - saves time when editing needed
	//Variable storing the HTML
	var navHTML = `
	<!--Following code defines the head navigation bar-->
  <!--Implemented as an unordered list-->
  <ul id="navbar" class="topnav">
		<li class="logo"></li><!--Osbit's logo-->

    <!--Active class used to style this button as page is active-->
		<li class="block"><a href="index.php"><i id="HomeMenu" class="inactive">Home</i></a></li>

		<li class="dropdown"><!--Begins the drop down box-->
			<a href="Parts.php" class="dropbtn"><i id="PartMenu" class="inactive">Parts</i></a>
			<div class="dropdown-btns">
				<!--Buttons that appears when navbar hovered over-->
				<a href="NewPart.php">Create Part</a>
				<a href="EditPart.php">Edit Part</a>
				<a href="DeletePart.php">Delete Part</a>
				<a href="ViewParts.php">View Parts</a>
			</div>
		</li>

		<li class="dropdown">
			<a href="Projects.php" class="dropbtn"><i id="ProjectMenu" class="inactive">Projects</i></a>
			<div class="dropdown-btns">
				<a href="NewProject.php">Create Project</a>
				<a href="EditProject.php">Edit Project</a>
				<a href="DeleteProject.php">Delete Project</a>
				<a href="ViewProjects.php">View Projects</a>
			</div>
		</li>

		<li class="dropdown">
			<a href="PurchaseOrders.php" class="dropbtn"><i id="POMenu" class="inactive">Purchase Orders</i></a>
			<div class="dropdown-btns">
				<a href="NewPO.php">Create Purchase Order</a>
				<a href="EditPO.php">Edit Purchase Order</a>
				<a href="DeletePO.php">Delete Purchase Order</a>
				<a href="ViewPOs.php">View Purchase Orders</a>
			</div>
		</li>

		<li class="dropdown">
			<a href="Suppliers.php" class="dropbtn"><i id="SupMenu" class="inactive">Suppliers</i></a>
			<div class="dropdown-btns">
				<a href="NewSupplier.php">Create Supplier</a>
				<a href="EditSupplier.php">Edit Supplier</a>
				<a href="DeleteSupplier.php">Delete Supplier</a>
				<a href="ViewSuppliers.php">View Suppliers</a>
			</div>
		</li>

	</ul>
	`
	//Retrieves the location where the HTML is to be inserted
	document.getElementById(theID).innerHTML = navHTML;
	activatePage(url); //Calls the function to assign the active class
}

function activatePage(url) { //Function for adding 'active' class to the nav buttons
	if (url.indexOf("Home") > -1) { //If the index of the parameter is greater than -1, i.e. it is in the link
		document.getElementById("HomeMenu").className = "active"; //Changes the class name to 'active'
	} else if (url.indexOf("Part") > -1) { //An index of -1 is typically used to say the item is not in the list
		document.getElementById("PartMenu").className = "active";
	} else if (url.indexOf("Project") > -1) {
		document.getElementById("ProjectMenu").className = "active";
	} else if (url.indexOf("PO") > -1 || url.indexOf("PurchaseOrder") > -1) {
		document.getElementById("POMenu").className = "active";
	} else if (url.indexOf("Supplier") > -1) {
		document.getElementById("SupMenu").className = "active";
	}
}
