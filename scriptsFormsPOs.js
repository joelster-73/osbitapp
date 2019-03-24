function addRow(name) { //function for adding new row to the table
	var table = document.getElementById(name); //get the table in the file
	var numRows = table.rows.length; //takes number of rows from the table
	var row = table.insertRow(numRows); //row inserted into the bottom of the table
	var cell1 = row.insertCell(0); //defines the first cell of the row
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);
	var cell4 = row.insertCell(3);
	cell1.innerHTML = "<input name='tablePartID[]' type='text' title='Please enter the part ID' oninvalid='setCustomValidity(\"Please enter a valid part ID.\")' oninput='setCustomValidity(\"\")' required/>";
	cell2.innerHTML = "<input name='tableQty[]' type='text' title='Please enter the quantity' oninvalid='setCustomValidity(\"Please enter a valid number.\")' oninput='setCustomValidity(\"\")' required/>";
	cell3.innerHTML = "<input name='unitCost[]' class='money' type='text' title='Please enter the unit cost' oninvalid='setCustomValidity(\"Please enter a valid cost.\")' oninput='setCustomValidity(\"\")' required pattern='£[0-9,]*.[0-9]{2}'/>";
	cell4.innerHTML = "<input name='linePrice[]' class='money' type='text' pattern='£[0-9,]*.[0-9]{2}' readonly/></td>";
}
function setDate() { //function for setting the initial date of the date input

	function formatDate(theDate) { //creates function to format the date
		var theDay = theDate.getDate();
		var theMonth = (theDate.getMonth() + 1); //months start at 0
	  var theYear = theDate.getFullYear();
		if (theMonth < 10) theMonth = '0' + theMonth; //to format the date correctly
	  if (theDay < 10) theDay = '0' + theDay;
		var formattedDate = [theYear, theMonth, theDay].join('-'); //combines to form a date for today
		return (formattedDate);
	}
	var currentDate = new Date(); //variable storing the current date under currentDate
	//if the date is the base value - i.e. not changed by the function as it's in the past
	if (document.getElementById('ordDate').value == "2001-05-10") {
		document.getElementById('ordDate').value = formatDate(currentDate); //calls function to format date
	}

	var nextDate = new Date(currentDate); //to predefine tomorrow
	nextDate.setDate(currentDate.getDate()+1); //gets the date for tomorrow - returns integer and uses this to set date

  if (document.getElementById('delDate').value == "2001-05-10") {
		document.getElementById('delDate').value = formatDate(nextDate);
	}
}

function calcLinePrice(theTable) { //function to calculate the line price of a row of the table
	var table = document.getElementById(theTable.id); //get the table in the file from the passed element's ID
	for (var i = 1; i < table.rows.length; i++) { //iterates through all rows
		var col1 = table.rows[i].cells[1].children[0].value.replace(/,|£/g, ""); //retrieves value of input from table cell
		var col2 = table.rows[i].cells[2].children[0].value.replace(/,|£/g, "");
		//checks whether the columns' values have a length of 0, i.e. there has been no input
		//if the length of both inputs is not 0, the price is calculated and then added to the third column
		if (col1.length != 0 && col2.length != 0 ) table.rows[i].cells[3].children[0].value = col1 * col2;
	}
}

function calcTotalCost() { //function for calculating total cost of purchase order
	var delCost = Number(document.getElementById('delCost').value.replace(/,|£/g, "")); //Retrieves these values
	var otherCosts = Number(document.getElementById('costs').value.replace(/,|£/g, ""));
	var expenses = (delCost + otherCosts);
	var itemsTotal = 0.00; //Defines total for items in table
	var discount = Number(document.getElementById('discountPercent').value.replace(/%/g, ""));
	var linePrices = document.getElementsByName('linePrice[]'); //Gets all line prices
	for (var i = 0; i < linePrices.length; i++) {
		itemsTotal += Number(linePrices[i].value.replace(/,|£/g, "")); //Adds each one to the total
	}
	var subtotal = expenses + itemsTotal;
	var vat = Number(document.getElementById('VAT').value.replace(/%/g, "")); //Gets the VAT rate
	var added = vat*0.01*itemsTotal;

	var theSubtotal = (100-discount)*0.01*subtotal //takes discount into account
	var theTotal = (100-discount)*0.01*(subtotal + added)
	document.getElementById('subtotal').value = theSubtotal; //Returns the values
	document.getElementById('totalCost').value = theTotal;
}
