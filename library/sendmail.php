<?php
  /**
   * Sets error header and json error message response.
   *
   * @param  String $messsage error message of response
   * @return void
   */
  function errorResponse ($messsage) {
    header('HTTP/1.1 500 Internal Server Error');
    die(json_encode(array('message' => $messsage)));
  }
  /**
   * Pulls posted values for all fields in $fields_req array.
   * If a required field does not have a value, an error response is given.
   */
  function constructMessageBody () {
    $fields_req =  array("name" => true, "email" => true, "message" => true);
    $message_body = "";
    foreach ($fields_req as $name => $required) {
      $postedValue = $_POST[$name];
      if ($required && empty($postedValue)) {
        errorResponse("$name is empty.");
      } else {
        $message_body .= ucfirst($name) . ":  " . $postedValue . "\n";
      }
    }
    return $message_body;
  }
  header('Content-type: application/json');
  //do Captcha check, make sure the submitter is not a robot:)...
  $url = 'https://www.google.com/recaptcha/api/siteverify';
  $opts = array('http' =>
    array(
      'method'  => 'POST',
      'header'  => 'Content-type: application/x-www-form-urlencoded',
      'content' => http_build_query(array('secret' => '6LeJYygTAAAAAB8aFFrDV7AeJBIN5c3TAy2OhAsC', 'response' => $_POST["g-recaptcha-response"]))
    )
  );
  $context  = stream_context_create($opts);
  $result = json_decode(file_get_contents($url, false, $context, -1, 40000));

  if (!$result->success) {
    errorResponse('reCAPTCHA checked failed!');
  }
  //attempt to send email
  $messageBody = constructMessageBody();
  require './vender/php_mailer/PHPMailerAutoload.php';
  $mail = new PHPMailer;
  $mail->CharSet = 'UTF-8';
 // $mail->Host = 'localhost';
  
  $mail->isSMTP();
  $mail->Host = "smtp.gmail.com";
  $mail->SMTPAuth = true;
  $mail->Username = "cos2v88@gmail.com";
  $mail->Password = "PQRSTUV15121989";
  
/*   $mail->SMTPSecure = 'tls';
  $mail->Port = 587; */
  $mail->SMTPSecure = 'ssl';
  $mail->Port = 465;
  
 // $mail->setFrom($_POST['email'], $_POST['name']);
  $mail->setFrom('web_message@connect.jumpingpixelgames.com','WebMail');
  $mail->addAddress('contact@jumpingpixelgames.com');
  $mail->Subject = $_POST['reason'];
  //$mail->Body  = "FROM :". $_POST['email'] .",". $_POST['name'].$messageBody;
  $mail->Body  = $messageBody;
  //try to send the message
  if($mail->send()) {
    echo json_encode(array('message' => 'Your message was successfully submitted.'));
  } else {
	echo json_encode(array('message' => 'Your message was NOT successfully submitted.'. $mail->ErrorInfo));
   // errorResponse('An unexpected error occured while attempting to send the email: ' . $mail->ErrorInfo);
  }
?>