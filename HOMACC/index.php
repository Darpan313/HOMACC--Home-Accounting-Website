<?php

include('connect-db.php');
require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->isSMTP();                                   // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';                    // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                            // Enable SMTP authentication
$mail->Username = 'darpanpatel3131@gmail.com';          // SMTP username
$mail->Password = 'darnyvirus3131'; // SMTP password
$mail->SMTPSecure = 'tls';                         // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                 // TCP port to connect to

$mail->setFrom('darpanpatel3131@gmail.com', 'darnyvirus3131');
$mail->addReplyTo('darpanpatel3131@gmail.com', 'darnyvirus3131');
$mail->addAddress('hiteshbothrabansal@gmail.com');   // Add a recipient
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

$mail->isHTML(true);  // Set email format to HTML
$todays_date = date("Y-m-d");

$result = mysql_query("SELECT * FROM reminder WHERE reminder_date='2016-11-26'");


$bodyContent="<h1>Reminders for Today</h1>";
while( $row = mysql_fetch_array( $result ))
{

$reminder_desc=$row["reminder_desc"];
$reminder_date = $row["reminder_date"];
$reminder_cat=$row["category"];
$reminder_sub=$row["subcat"];
$reminder_amount=$row["amount"];

$bodyContent .= "<h2>".$reminder_desc."</h2>";
$bodyContent .= "<h3>".$reminder_cat."<pre>                </pre> " .$reminder_sub. "<pre>          </pre>RS- "  .$reminder_amount."</h3>     ";
//$bodyContent .= "<h3>".$reminder_sub."</h3>     ";
//$bodyContent .= "<h3>RS.".$reminder_amount."</h3>";

}





$mail->Subject = 'Email from HOMACC for REMINDER';
$mail->Body    = $bodyContent;

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
?>
