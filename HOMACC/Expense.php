<!DOCTYPE html>
<head>

<title>View Records</title>
<link rel="stylesheet" href="tab.css">
<link rel="stylesheet" href="modal.css">
</head>

<body>
<nav class="main-nav" id="main-nav">
  <a href="#">Home</a>
  <a href="check_income.php">Income</a>
  <a href="#">Expense</a>
  <a href="#">Net-worth</a>
  <a href="reminder_list.php">Reminders</a>
  <a href="#">Loans</a>
  <a href="#">Insurances</a>

</nav>
<div class="page-wrap">

  <header class="main-header">
    <a href="#main-nav" class="open-menu">
      ☰
    </a>
    <a href="#" class="close-menu">
      ☰
    </a>
    
    <h1>HOMACC</h1>
  </header>



<div class="content">
<h1 align=center>EXPENSE </h1>

<form action="" method="post" align="center">
<strong>CATEGORY:</strong><select name="cat">
<option value="All">Select All</option>
<option value="Food" >Food</option>
<option value="Transport">Transport</option>
<option value="Medical">Medical</option>
<option value="Schooling">Schooling</option>
<option value="Bill">Bill</option>
<option value="Vehicle">Vehicle</option>
<option value="Rent">Rent</option>
<option value="Lending Money">Lending Money</option>
<option value="Insurance">Insurance</option>
<option value="Miscellineous">Miscellaneous</option>>


</select>

<strong>DATA:</strong>
<select id="dat" name="dat" onchange="myf()">
<option value="all">ALL</option>
<option value="TM">This month</option>
<option value="custom">Customize</option>
</select>
<br><br>
<div id="cusdt" style="display: none;">
<strong>Start Date:</strong> <input type="date" name="Sd">

<strong>End Date:</strong> <input type="date" name="Ed">
</div>

<script>
function myf(){
var v=document.getElementById("dat").value;
 if(v== "custom")
{
    document.getElementById("cusdt").style.display="block";

}
else if(v == "TM")
{
   document.getElementById("cusdt").style.display="none";
}
else if(v == "all")
{
   document.getElementById("cusdt").style.display="none";
}
}
</script>
<br>
<input  type="submit" name="Go" value="Go">

</form>







<?php

/*

VIEW.PHP

Displays all data from 'players' table

*/



// connect to the database

include('connect-db.php');

$sum="SELECT SUM(amount) AS amt FROM expense";
$re=mysql_query($sum);
while($row=mysql_fetch_array( $re ))
{
  $amount=number_format($row['amt'],2);
  echo '<strong> Total-Expense: &#x20B9; ' .$amount. '</strong>';
}



// get results from database
if (isset($_POST['Go'])){
$catee= mysql_real_escape_string(htmlspecialchars($_POST['cat']));
$datopt= mysql_real_escape_string(htmlspecialchars($_POST['dat']));
$sd=mysql_real_escape_string(htmlspecialchars($_POST['Sd']));
$ed=mysql_real_escape_string(htmlspecialchars($_POST['Ed']));
if($datopt=='TM'){
if($catee=='All'){
  $result = mysql_query("SELECT * FROM expense WHERE EXTRACT(MONTH FROM I_date)=EXTRACT(MONTH FROM CURDATE())")

or die(mysql_error());

$sum="SELECT SUM(amount) AS amt FROM expense WHERE EXTRACT(MONTH FROM I_date)=EXTRACT(MONTH FROM CURDATE())";
$re=mysql_query($sum);
while($row=mysql_fetch_array( $re ))
{
  $amount=number_format($row['amt'],2);
  echo '<br>';
  echo '<strong> Total-Expense in all categories in this month is: &#x20B9; ' .$amount. '</strong>';
}

}


else{
$result = mysql_query("SELECT * FROM expense WHERE category='$catee' AND EXTRACT(MONTH FROM I_date)=EXTRACT(MONTH FROM CURDATE())")

or die(mysql_error());

$sum="SELECT SUM(amount) AS amt FROM expense WHERE EXTRACT(MONTH FROM I_date)=EXTRACT(MONTH FROM CURDATE()) AND category='$catee'";
$re=mysql_query($sum);
while($row=mysql_fetch_array( $re ))
{
  $amount=number_format($row['amt'],2);
 echo '<br>';
  echo '<strong> Total-Expense in '.$catee.' category in this month is: &#x20B9; ' .$amount. '</strong>';
}

}
}


else if($datopt=='custom')
{
  if($catee=='All'){
  $result = mysql_query("SELECT * FROM expense WHERE DATE(I_date) BETWEEN '$sd' AND '$ed'")

or die(mysql_error());

$sum="SELECT SUM(amount) AS amt FROM expense WHERE DATE(I_date) BETWEEN '$sd' AND '$ed'";
$re=mysql_query($sum);
while($row=mysql_fetch_array( $re ))
{
  $amount=number_format($row['amt'],2);
  echo '<br>';
  echo '<strong> Total-Expense in all categories from <'.$sd.'> to <'.$ed. '>is: &#x20B9; ' .$amount. '</strong>';
}


}
else{
$result = mysql_query("SELECT * FROM expense WHERE category='$catee' AND DATE(I_date) BETWEEN '$sd' AND '$ed'")

or die(mysql_error());

$sum="SELECT SUM(amount) AS amt FROM expense WHERE DATE(I_date) BETWEEN '$sd' AND '$ed' AND category='$catee'";
$re=mysql_query($sum);
while($row=mysql_fetch_array( $re ))
{
  $amount=number_format($row['amt'],2);
 echo '<br>';
  echo '<strong> Total-Expense in '.$catee.' category from <'.$sd.'> to <'.$ed. '>is: &#x20B9; ' .$amount. '</strong>';
}

}
}


else if($datopt=='all')
{
   if($catee=='All'){
  $result = mysql_query("SELECT * FROM expense")

or die(mysql_error());
}
else{
$result = mysql_query("SELECT * FROM expense WHERE category='$catee'")

or die(mysql_error());}
}



// display data in table

#echo "<p><b>View All</b> | <a href='view-paginated.php?page=1'>View Paginated</a></p>";



echo "<table border='1' cellpadding='10' align=center>";

echo "<tr class=main-heading><th>DATE</th> <th>AMOUNT( &#x20B9;)</th><th>CATEGORY</th><th>DESCRIPTION</th> <th>EDIT</th> <th>DELETE</th></tr>";



// loop through results of database query, displaying them in the table

while($row = mysql_fetch_array( $result )) {



// echo out the contents of each row into a table

echo "<tr>";

//echo '<td>' . $row['Id'] . '</td>';

echo '<td>' . $row['I_date'] . '</td>';
$amt=number_format($row['amount'],2);
echo '<td>' . $amt . '</td>';

echo '<td>' . $row['category'] . '</td>';

echo '<td>' . $row['description'] . '</td>';

echo '<td><a href="edit-expense.php?Id=' . $row['Id'] . '">Edit</a></td>';

echo '<td><a href="delete_expense.php?Id=' . $row['Id'] . '">Delete</a></td>';

echo "</tr>";

}



// close table>

echo "</table>";

}

?>

<br>
<p align=center><button id=myBtn>Add a new record</button></p>
<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">×</span>
      <h2 align=center>EXPENSE</h2>
    </div>
    <div class="modal-body">


    <?php

/*

NEW.PHP

Allows user to create a new entry in the database

*/



// creates the new record form

// since this form is used multiple times in this file, I have made it a function that is easily reusable

function renderForm($date, $amount,$category,$description, $error)

{

?>



<?php
date_default_timezone_set('UTC');

// if there are any errors, display them

if ($error != '')

{

echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';

}

?>



<form action="" method="post">

<div>



<strong>AMOUNT: *</strong> <input type="text" name="amount" value="<?php echo $amount; ?>" /><br/><br>

<strong>CATEGORY: *</strong> <select name="category" >
<option value="Food" >Food</option>
<option value="Transport">Transport</option>
<option value="Medical">Medical</option>
<option value="Schooling">Schooling</option>
<option value="Bill">Bill</option>
<option value="Vehicle">Vehicle</option>
<option value="Rent">Rent</option>
<option value="Lending Money">Lending Money</option>
<option value="Insurance">Insurance</option>
<option value="Miscellineous">Miscellaneous</option>


</select>
<br/><br>

<strong>DESCRIPTION: *</strong> <input type="text" name="description" value="<?php echo $description; ?>" /><br/><br>


<p>* required</p>

<input class="btn btn-block" type="submit" name="submit" value="Submit">

</div>

</form>



<?php

}









// connect to the database

include('connect-db.php');



// check if the form has been submitted. If it has, start to process the form and save it to the database

if (isset($_POST['submit']))

{

// get form data, making sure it is valid



$amount = mysql_real_escape_string(htmlspecialchars($_POST['amount']));

$category = mysql_real_escape_string(htmlspecialchars($_POST['category']));

$description = mysql_real_escape_string(htmlspecialchars($_POST['description']));



// check to make sure both fields are entered

if ($amount == '')

{

// generate error message

$error = 'ERROR: Please fill in all required fields!';



// if either field is blank, display the form again

renderForm($date, $amount, $category,$description,$error);

}
elseif ($category=='') {
    # code...
    $error = 'ERROR: Please fill in category required fields!';
    renderForm($date, $amount, $category,$description,$error);

}

else

{

// save the data to the database
//$date= date("F j, Y, g:i a");

mysql_query("INSERT expense SET I_date= now(), amount='$amount',category='$category',description='$description'")

or die(mysql_error());



// once saved, redirect back to the view page

header("Location: Expense.php");

}

}

else

// if the form hasn't been submitted, display the form

{

renderForm('','','','','');

}

?>

</div>
    <div class="modal-footer">
      
    </div>
  </div>

</div>
<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
</div>
</div>

</body>

</html>