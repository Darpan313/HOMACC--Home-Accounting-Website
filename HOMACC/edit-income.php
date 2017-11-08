<?php

/*

NEW.PHP

Allows user to create a new entry in the database

*/



// creates the new record form

// since this form is used multiple times in this file, I have made it a function that is easily reusable

function renderForm($Id,$date, $amount,$category,$description, $error)

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
<input type="text" name="Id" value="<?php echo $Id; ?>"/>

<div>



<strong>AMOUNT: *</strong> <input type="text" name="amount" value="<?php echo $amount; ?>" /><br/>

<strong>CATEGORY: *</strong> <select name="category" >
<option value="salary" >Salary</option>
<option value="Bank">Bank</option>
<option value="Others">Others</option>

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
// confirm that the 'id' value is a valid integer before getting the form data

if (is_numeric($_POST['Id']))

{

$amount = mysql_real_escape_string(htmlspecialchars($_POST['amount']));

$category = mysql_real_escape_string(htmlspecialchars($_POST['category']));

$description = mysql_real_escape_string(htmlspecialchars($_POST['description']));



// check to make sure both fields are entered

if ($amount == '')

{

// generate error message

$error = 'ERROR: Please fill in all required fields!';



// if either field is blank, display the form again

renderForm($Id,$date, $amount, $category,$description,$error);

}
elseif ($category=='') {
    # code...
    $error = 'ERROR: Please fill in category required fields!';
    renderForm($Id,$date, $amount, $category,$description,$error);

}

else

{

// save the data to the database
//$date= date("F j, Y, g:i a");
$Id = $_GET['Id'];

mysql_query("UPDATE income SET amount='$amount',category='$category',description='$description' WHERE Id='$Id'")

or die(mysql_error());


// once saved, redirect back to the view page

header("Location: check_income.php");

}

}
else

{

// if the 'id' isn't valid, display an error

echo 'Error!';

}
}

else

// if the form hasn't been submitted, display the form

{

//get the 'id' value from the URL (if it exists), making sure that it is valid (checing that it is numeric/larger than 0)

if (isset($_GET['Id']) && is_numeric($_GET['Id']) && $_GET['Id'] > 0)

{

// query db

$Id = $_GET['Id'];

$result = mysql_query("SELECT * FROM income WHERE Id=$Id")

or die(mysql_error());

$row = mysql_fetch_array($result);



// check that the 'id' matches up with a row in the databse

if($row)

{



// get data from db

$Id = $row['Id'];

$date = $row['I_date'];

$amount=$row['amount'] ;

$category=$row['category'] ;

 $description=$row['description'] ;




// show form

renderForm($Id,$date, $amount, $category,$description,'');

}

else

// if no match, display result

{

echo "No results!";

}

}

else

// if the 'id' in the URL isn't valid, or if there is no 'id' value, display an error

{

echo 'Error id not valid!';

}

}

?>