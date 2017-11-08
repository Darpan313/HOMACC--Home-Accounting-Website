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

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>

<title>New Record</title>

</head>

<body>

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



<strong>AMOUNT: *</strong> <input type="text" name="amount" value="<?php echo $amount; ?>" /><br/>

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
<option value="Miscellineous">Miscellineous</option>


</select>
<br/>

<strong>DESCRIPTION: *</strong> <input type="text" name="description" value="<?php echo $description; ?>" /><br/>


<p>* required</p>

<input type="submit" name="submit" value="Submit">

</div>

</form>

</body>

</html>

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

header("Location: expense.php");

}

}

else

// if the form hasn't been submitted, display the form

{

renderForm('','','','','');

}

?>