function showfield(name,bomID=0) { //function for creating table at bottom of form
	var newHTML = "<h3>Parts for Bill of Materials";
  if (name=='Assembly') { //if this option is selected
		newHTML += " <span class='red'>*</span>"; //to say field is compulsary
	}
	newHTML += " </h3><br>";
	if (bomID != 0) { //Check whether the page is not a new part page
		newHTML += "<br>BOMID <br> <input type='text' name='bomID' value='"+bomID+"' readonly/><br><br>";
	}
	newHTML += "<table id='formTable'> <tr> <th>PartID</th> <th>Quantity</th> </tr>";
	var row = "<tr> <td><input name='tablePartID[]' type='text' title='Please enter the part ID' oninvalid='setCustomValidity(\"Please enter a valid part ID.\")' oninput='setCustomValidity(\"\")' required /></td>"; //adds this HTML to the first cell
	row += "<td><input name='tableQty[]' type='text' pattern='[0-9]+' title='Please enter the quantity' oninvalid='setCustomValidity(\"Please enter a valid number.\")' oninput='setCustomValidity(\"\")' required /></td>";
	newHTML += row.concat(row,row,' </table> <br>'); // combines three rows together
	newHTML += "<input type='button' onclick='addRow(\"formTable\")' value='Create Row'> <input type='button' onclick='delRow(\"formTable\")' value='Delete Row'><br><br>";
	if (name == 'Bespoke' || name == 'Base') {
		newHTML = ''; //will clear the new HTML if this option is selected
	}
	document.getElementById('newCode').innerHTML = newHTML; //adds HTML code to the page
}

function addRow(name) { //function for adding new row to the table
	var table = document.getElementById(name); //get the table in the file
	var numRows = table.rows.length; //takes number of rows from the table
	var row = table.insertRow(numRows); //row inserted into the bottom of the table
	var cell1 = row.insertCell(0); //defines the first cell of the row
	var cell2 = row.insertCell(1);
	cell1.innerHTML = "<input name='tablePartID[]' type='text' title='Please enter the part ID' oninvalid='setCustomValidity(\"Please enter a valid part ID.\")' oninput='setCustomValidity(\"\")' required />"; //adds this HTML to the first cell
	cell2.innerHTML = "<input name='tableQty[]' type='text' pattern='[0-9]+' title='Please enter the quantity' oninvalid='setCustomValidity(\"Please enter a valid number.\")' oninput='setCustomValidity(\"\")' required />";
}
