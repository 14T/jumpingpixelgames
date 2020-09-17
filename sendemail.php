<?php 
	header('Content-type: application/json');
 	$status = array(
		'type'=>'success',
		'message'=>'Thank You For Contacting Us! We will revert soon!'
	); 

   /*  $namef = @trim(stripslashes($_POST['namef'])); 
	$namel = @trim(stripslashes($_POST['namel'])); 
    $email = @trim(stripslashes($_POST['mail'])); 
    $subject = "Mail Sent From JumpingPixelsGames Website"; 
	//$subject = @trim(stripslashes($_POST['subject']));
    $message = @trim(stripslashes($_POST['message']));  */
	
	$namef = $_POST['namef']; 
	$namel = $_POST['namel']; 
    $email = $_POST['mail']; 
    $subject = "Mail Sent From JumpingPixelsGames Website"; 
	//$subject = @trim(stripslashes($_POST['subject']));
    $message = $_POST['message'];

    $email_from = $email;
    $email_to = 'contact@jumpingpixelgames.com';

    $body = 'First Name: ' . $namef . "\n\n" . 'Last Name: ' . $namel . "\n\n" . 'Email: ' . $email . "\n\n" . 'Subject: ' . $subject . "\n\n" . 'Message: ' . $message;

    $success = @mail($email_to, $subject, $body, 'From: <'.$email_from.'>');
		
	//echo $body;
		

    echo json_encode($status);
    die;
	
	?>