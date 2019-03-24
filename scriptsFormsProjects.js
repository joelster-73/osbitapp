function addRow(name) { //function for adding new row to the table
	var table = document.getElementById(name); //get the table in the file
	var numRows = table.rows.length;
	var row = table.insertRow(numRows); //row inserted into the bottom of the table
	var cell1 = row.insertCell(0); //defines the first cell of the row
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);
	cell1.innerHTML = "<input name='tablePartID[]' type='text' title='Please enter the part ID' oninvalid='setCustomValidity(\"Please enter a valid part ID.\")' oninput='setCustomValidity(\"\")' required />"; //adds this HTML to the first cell
	cell2.innerHTML = "<input name='tableQty[]' type='text' title='Please enter the quantity' oninvalid='setCustomValidity(\"Please enter a valid number.\")' oninput='setCustomValidity(\"\")' required />";
	cell3.innerHTML = "<select class='redArrow' name='location[]' title='Please select an option' required> <option value=''>Select a location</option><option value='NotonPO'>Not on a PO</option><option value='OnPONotOrd'>On a PO but not ordered</option><option value='OrdNotDel'>Ordered not delivered</option><option value='Store'>In the stores</option><option value='Assembled'>Assembled</option><option value='Shipped'>Shipped to customer</option></select>";
}
function setDate() {  //function for setting the initial date of the date input
	var d = new Date(); //variable storing the current date
  var month = (d.getMonth() + 1); //months start at 0
  var day = d.getDate();
  var year = d.getFullYear();

  if (month < 10) month = '0' + month; //to format the date correctly
  if (day < 10) day = '0' + day;

  var today = [year, month, day].join('-'); //combines to form a date

	if (document.getElementById('createDate').value == "2001-05-10") {
		document.getElementById('createDate').value = today; //if the date is the base value - i.e. not changed by the function as it's in the past
	}
}
