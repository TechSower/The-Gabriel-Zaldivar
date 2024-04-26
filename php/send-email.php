<?php

// Replace this with your own email address
$to = 'zaldivaranalytics@gmail.com';

function url(){
  return sprintf(
    "%s://%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME']
  );
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
   $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
   $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
   $contact_message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

   if ($subject == '') { $subject = "Contact Form Submission"; }

   // Initialize $message
   $message = "";

   // Set Message
   $message .= "Email from: " . $name . "<br />";
   $message .= "Email address: " . $email . "<br />";
   $message .= "Message: <br />";
   $message .= nl2br($contact_message);
   $message .= "<br /> ----- <br /> This email was sent from your site " . url() . " contact form. <br />";

   // Set From: header
   $from =  $name . " <" . $email . ">";

   // Email Headers
   $subject_encoded = mb_encode_mimeheader($subject, 'UTF-8');
   $headers = "From: " . $from . "\r\n";
   $headers .= "Reply-To: ". $email . "\r\n";
   $headers .= "MIME-Version: 1.0\r\n";
   $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

   // Attempt to send email
   $mail = mail($to, $subject_encoded, $message, $headers);

   if ($mail) { 
      echo "OK"; 
   } else { 
      echo "Something went wrong. Please try again."; 
   }
}

?>
