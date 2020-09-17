<?php
$field_namef = $_POST['namef'];
$field_namel = $_POST['namel'];
$field_email = $_POST['email'];
$field_message = $_POST['message'];

$mail_to = 'contact@jumpingpixelgames.com';
$subject = 'Message from a Website Visitor alias : '.$field_namef ."".$field_namel;

$body_message = 'From: '.$field_namef."\n";
$body_message .= 'E-mail: '.$field_email."\n";
$body_message .= 'Message: '.$field_message;

$headers = 'From: '.$field_email."\r\n";
$headers .= 'Reply-To: '.$field_email."\r\n";

$mail_status = mail($mail_to, $subject, $body_message, $headers);

if ($mail_status) { ?>
	<script language="javascript" type="text/javascript">
		alert('We will revert once the Game is Over.Thanks for your feedback!');
		window.location = 'http://www.jumpingpixelgames.com/contact-us.html';
	</script>
<?php
}
else { ?>
	<script language="javascript" type="text/javascript">
		alert('Message failed. Please, send an email to contact@jumpingpixelgames.com');
		window.location = 'http://www.jumpingpixelgames.com/contact-us.html';
	</script>
<?php
}
?>