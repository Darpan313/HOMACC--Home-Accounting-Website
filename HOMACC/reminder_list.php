

<?php
include('connect-db.php'); // Our database connectivity file
if( empty($_GET['reminder_id']) )
{
?>
<html>
<head><title>List of Reminders</title></head>
<link rel="stylesheet" href="tab.css">
<link rel="stylesheet" href="modal.css">
<body>

<nav class="main-nav" id="main-nav">
  <a href="#">Home</a>
  <a href="check_income.php">Income</a>
  <a href="Expense.php">Expense</a>
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






<h1 align=center>REMINDERS </h1>
<table width="100%" border="0" align="center">

<tr class=main-heading><th>DESCRIPTION</th><th>DATE</th><th>Category</th><th>Sub-cat</th><th>Amount</th><th>DELETE</th></tr>

<?php
$result = mysql_query( "SELECT * FROM reminder" );
$nr = mysql_num_rows( $result );
if(empty($nr))
{
echo("
<tr>
<td colspan='3'>No Reminders setup</td>
</tr>
");
}


while( $row = mysql_fetch_array( $result ))
{

$reminder_desc=$row["reminder_desc"];
$reminder_date = $row["reminder_date"];
$reminder_id = $row["reminder_id"];

$reminder_cat=$row["category"];
$reminder_sub=$row["subcat"];
$reminder_amt=$row["amount"];


echo("
<tr>

<td width='25%'>$reminder_desc</td>
<td width='15%'>$reminder_date</td>
<td width='10%'>$reminder_cat</td>
<td width='10%'>$reminder_sub</td>
<td width='10%'>$reminder_amt</td>
<td width='10%'><a href='reminder_list.php?reminder_id=$reminder_id'>delete</a></td>
</tr>
");
}
mysql_free_result( $result );
?>
</table>
<p align=center><button id=myBtn>Add a new Reminder</button></p>

<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">×</span>
      <h2 align=center>REMINDERS</h2>
    </div>
    <div class="modal-body">




    <?php
include('connect-db.php'); // Our database connectivity file
//if($_POST['step'] != '1')
//{
   
?>

      <script language="javascript" type="text/javascript">
            function dynamicdropdown(listindex)
            {
                document.getElementById("subcategory").length = 0;
                switch (listindex)
                {
                    case "expense" :
                        document.getElementById("subcategory").options[0]=new Option("--Select--","");
                        document.getElementById("subcategory").options[1]=new Option("Food","Food");
                        document.getElementById("subcategory").options[2]=new Option("Transport","Transport");
                        document.getElementById("subcategory").options[3]=new Option("Medical","Medical");
                        document.getElementById("subcategory").options[4]=new Option("Schooling","Schooling");
                        document.getElementById("subcategory").options[5]=new Option("Bill","Bill");
                         document.getElementById("subcategory").options[6]=new Option("Vehicle","Vehicle");
                          document.getElementById("subcategory").options[7]=new Option("Rent","Rent");
                           document.getElementById("subcategory").options[8]=new Option("Lending Money","Lending Money");
                            document.getElementById("subcategory").options[9]=new Option("Insurance","Insurance");
                             document.getElementById("subcategory").options[10]=new Option("Miscellaneous","Miscellaneous");
                        break;
                    
                    case "income" :
                        document.getElementById("subcategory").options[0]=new Option("--Select--","");
                        document.getElementById("subcategory").options[1]=new Option("Bank","Bank");
                        document.getElementById("subcategory").options[2]=new Option("Salary","Salary");
                          document.getElementById("subcategory").options[3]=new Option("Others","Others");
                        break;
                   
                }
                return true;
            }
       </script>


<form name="setup_reminder" action="reminder_setup.php" method="post">
<table border='0' align='center'>


<tr>
<td>Description</td>
<td>
<textarea name="reminder_desc" rows="5" /></textarea>
</td>
</tr>
<tr>
<td>Trigger Date</td>
<td>
<select name="reminder_year">
<?php
$current_year = date("Y");
for($counter=$current_year;$counter<=$current_year+2;$counter++)
{
echo("\n<option>$counter</option>");
}
?>
</select>
<select name="reminder_month">
<?php
for($counter=1;$counter<=12;$counter++)
{
if($counter < 10)
$prefix = "0";
else
$prefix = "";
echo("\n<option>$prefix$counter</option>");
}
?>
</select>
<select name="reminder_date">
<?php
for($counter=1;$counter<=31;$counter++)
{
if($counter < 10)
$prefix = "0";
else
$prefix="";
echo("\n<option>$prefix$counter</option>");
}

?>
</select>
</td>
</tr>
<br>

<tr>
<td><div class="category_div" id="category_div">TYPE:
            <select name="category" class="required-entry" id="category" onchange="javascript: dynamicdropdown(this.options[this.selectedIndex].value);">
                <option value="">--Select--</option>
                <option value="income">Income</option>
                <option value="expense">Expense</option>
            </select>
        </div></td>
        
        
        <td>
        <div class="sub_category_div" id="sub_category_div">CATEGORY:
            <script type="text/javascript" language="JavaScript">
                document.write('<select name="subcategory" id="subcategory"><option value="">--Select--</option></select>')
            </script>
            <noscript>
                <select name="subcategory" id="subcategory" >
                    <option value="">--Select--</option>
                </select>
            </noscript>
        </div></td>
        </tr>
        <tr>
        <td>Amount:</td><td><input type="text" name="reminder_amount" /></td>
        </tr>
<input name="step" type="hidden" value="1" />


</table>
<br>
<input class="btn btn-block"  name="submit" type="submit" value="add" />
</form>


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
</div>
</div>

</body>
</html>
<?php
}
else
{
mysql_query( "DELETE FROM reminder WHERE reminder_id='".addslashes($_GET['reminder_id'])."'" );
// Let's go back to the Reminder List page
Header("Refresh: 1;url=reminder_list.php");
echo <<< _HTML_END_
Reminder Deleted, redirecting...
_HTML_END_;
}
?>
