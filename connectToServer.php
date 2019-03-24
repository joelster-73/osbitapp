<?php //Script to connect file to database
    //Declare Variables
    $servername = "db776573321.hosting-data.io"; //the server's name
    $username = "dbo776573321"; //login credentials
    $password = "FhH2!rDc!r7kADM";
    $dbname = "db776573321"; //the database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
