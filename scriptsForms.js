function formatMoney() {
  //number-format the user inputs as currency
  var elements = document.getElementsByClassName('money'); //gets all elements to format
  for (var i=0; i < elements.length; i++) { //iterates through the above list
    if (elements[i].value.length != 0) { //if there's an input
      //set the numeric value to a number input
      var theValue = parseFloat(elements[i].value.replace(/,|£/g, "")) //removes all commas and £s
                      .toFixed(2) //converts to a 2dp number
                      .toString() //converts to a string
                      .replace(/\B(?=(\d{3})+(?!\d))/g, ","); //replaces every three digits with that and a comma
      elements[i].value = "£".concat(theValue); //adds pound sign to front
    }
  }
}
function formatPercent() {
  //number-format the user inputs as percentage
  var elements = document.getElementsByClassName('percent'); //gets all elements to format
  for (var i=0; i < elements.length; i++) { //iterates through the above list
    if (elements[i].value.length != 0) { //if there's an input
      //set the numeric value to a number input
      var theValue = parseFloat(elements[i].value.replace(/%/g, "")) //removes all %s
                      .toString(); //converts to a string
      elements[i].value = theValue.concat("%"); //adds pound sign to front
    }
  }
}
function resetForm(url) { //Used to reset form by redirecting to the page currently on - Alt+F5
	document.location.assign(url);
}
function delRow(name) { //function for deleting the bottom row of a table
	var table = document.getElementById(name); //get the table in the file
	var numRows = table.rows.length; //takes number of rows from the table
	if (numRows > 1) { //so not to delete the header row off the table
		document.getElementById(name).deleteRow(numRows-1); //deletes bottom row
	}
}
var defaultWidth = 100; //when want to change default width for form inputs
function formStyling(tableID,theWidth) { //function for styling the form
  theWidth = theWidth || defaultWidth; //if no parameter passed in, the width is set to the default
  //defines variable for the new CSS
  var newCSS = `:root {
  	--box-width: ${theWidth}%; /*Defines a variable*/
  }
  input, select, textarea{
  	width: var(--box-width); /*Uses variable as value*/
  	box-sizing: border-box;
  	margin: 10px 0px;
  	text-indent: 2px; /*Added to make text not touch border*/
  }
  input[type=submit], input[type=button], input[type="date"] {/*Customises the submit inputs*/
  	width: auto !important; /*Overrides all other formatting to have auto width*/
  } `
  addCSS(newCSS,'formStyleTag'); //calls the function to add the CSS
  if (document.getElementById(tableID) !== null) tableStyling(tableID,'tableStyleTag',theWidth);
}
function tableStyling(tableID,className,theWidth) {
  theWidth = theWidth || defaultWidth; //if no parameter passed in, the width is set to the default
  var numCols = document.getElementById(tableID).rows[0].cells.length; //gets number of columns of table
  //defines variable for the new CSS
  var newCSS = ` :root {
  	--box-width: ${theWidth}%; /*Defines a variable*/
  }
 /*Formatting for table at bottom of form*/
  #${tableID} {
  	width: var(--box-width); /*Uses variable as value*/
  	border-spacing: 0;
  }
  #${tableID} th {
  	font-weight: normal;
  	font-size: 16px;
  }
  #${tableID} th, #${tableID} td {
  	width: var(--box-width)/${numCols}; /*Divides value between n coloumns*/
  }
  #${tableID} input, #${tableID} select { /*Customises these inputs within table*/
  	width: 100%;
  	margin: 0px;
  }`
  addCSS(newCSS,className); //calls the function to add the CSS
}
function addCSS(css,className) { //function for adding CSS to head tag
  if (document.getElementsByClassName(className).length == 0) { //prevents multiple copies of same script being added
    var head = document.getElementsByTagName('head')[0]; //gets first head tag
    var s = document.createElement('style'); //creates a new style tag
    s.setAttribute('type','text/css'); //gives this this attrivbute
    s.setAttribute('class',className); //gives this this attrivbute
    if (s.styleSheet) { //for IE
      s.styleSheet.cssText = css;//adds the CSS
    } else { //actual stuff
      s.appendChild(document.createTextNode(css)); //adds the CSS
    }
    head.appendChild(s); //adds styling to the head
  }
}
