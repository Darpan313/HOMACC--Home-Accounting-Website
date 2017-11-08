<?php
include('connect-db.php'); // Our database connectivity file

if($_POST['step'] != '1')
{
   
?>
<html>
<head><title>Add Reminders</title>
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

</head>
<body>
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
        </tr>
        <br>
        <tr><td>
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
<td> </td>
<td>
<input name="step" type="hidden" value="1" />
<input name="submit" type="submit" value="add" />
</td>
</tr>
</table>
</form>
</body>
</html>
<?php
}

else
{
$error_list = "";
$todays_date = date( "Ymd" );
echo"$todays_date";
$reminder_date = $_POST['reminder_year'].$_POST['reminder_month'].$_POST['reminder_date'];


if( !checkdate( $_POST['reminder_month'], $_POST['reminder_date'], $_POST['reminder_year'] ))
$error_list .= "Reminder Date is invalid<br />";
else if( $reminder_date < $todays_date )
$error_list .= "Reminder Date is not a future date<br />";
if( empty( $error_list ) )
{
// No error let's add the entry
echo"Addded";
$reminder_date = $_POST['reminder_year']."-".$_POST['reminder_month']."-".$_POST['reminder_date'];
mysql_query( "INSERT INTO reminder( `reminder_desc`, `reminder_date`,`category`,`subcat`,`amount`) VALUES('".addslashes($_POST['reminder_desc'])."', '".addslashes($reminder_date)."','".addslashes($_POST['category'])."',
'".addslashes($_POST['subcategory'])."','".addslashes($_POST['reminder_amount'])."')" );
// Let's go to the Reminder List page
Header("Refresh: 1;url=reminder_list.php");
echo <<< _HTML_END_
Reminder Added, redirecting ...
_HTML_END_;
}
else
{
// Error occurred let's notify it
echo( $error_list );
}
}
?>
