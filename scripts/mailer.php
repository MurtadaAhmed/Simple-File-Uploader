<?php

function send_verification_email($email, $verification_code) {
    $subject = "Verify your email";
    $message = "Click the link below to verify your email: \n";
    $domain = $_SERVER['HTTP_HOST'];
    $message .= "http://$domain/verify.php?code=" . $verification_code;
    $headers = "From: noreply@$domain";
    mail($email, $subject, $message, $headers);
}

?>