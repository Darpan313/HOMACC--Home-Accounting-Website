<!DOCTYPE html>
<head>

<title>View Records</title>
<link rel="stylesheet" href="tab.css">

</head>

<body>

<h1 align=center>INCOME </h1>

<?php

/*

VIEW.PHP

Displays all data from 'players' table

*/



// connect to the database


include('connect-db.php');



// get results from database

$result = mysql_query("SELECT * FROM income")

or die(mysql_error());



// display data in table

#echo "<p><b>View All</b> | <a href='view-paginated.php?page=1'>View Paginated</a></p>";



echo "<table border='1' cellpadding='10' align=center>";

echo "<thead><tr class= main-heading > <th>ID</th> <th>DATE</th> <th>AMOUNT(Rs)</th><th>CATEGORY</th><th>DESCRIPTION</th> <th>EDIT</th> <th>DELETE</th></tr></thead>";



// loop through results of database query, displaying them in the table

while($row = mysql_fetch_array( $result )) {



// echo out the contents of each row into a table

echo "<tr>";

echo '<td>' . $row['Id'] . '</td>';

echo '<td>' . $row['I_date'] . '</td>';

echo '<td>' . $row['amount'] . '</td>';

echo '<td>' . $row['category'] . '</td>';

echo '<td>' . $row['description'] . '</td>';

echo '<td><a href="edit-income.php?Id=' . $row['Id'] . '">Edit</a></td>';

echo '<td><a href="delete_income.php?Id=' . $row['Id'] . '">Delete</a></td>';

echo "</tr>";

}



// close table>

echo "</table>";

?>

<p align=center><a href="new-income.php">Add a new record</a></p>



</body>

</html>