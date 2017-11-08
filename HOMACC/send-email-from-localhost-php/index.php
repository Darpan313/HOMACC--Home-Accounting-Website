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
$todays_date = date( "Y-m-d" );
$result = mysql_query("SELECT * FROM reminder");



$bodyContent="Hitesh";
while( $row = mysql_fetch_array( $result ))
{
$reminder_name = $row["reminder_name"];
$reminder_desc=$row["reminder_desc"];
$reminder_date = $row["reminder_date"];
echo ("Hit");
echo("
<tr>
<td width='30%'>$reminder_name</td>
<td width='40%'>$reminder_desc</td>
<td width='20%'>$reminder_date</td>
<td width='10%'><a href='reminder_list.php?reminder_id=$reminder_id'>delete</a></td>
</tr>
");
$bodyContent .= '<?php echo $reminder_name ?>';
$bodyContent .= '<p>$reminder_desc</p><br><br>';

}



echo("hhbd");

$mail->Subject = 'Email from HOMACC for REMINDER';
$mail->Body    = $bodyContent;

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
?>
