<?php

require_once 'vendor/autoload.php';
require_once 'Config/constants.php';

// Create the Transport
$transport = (new Swift_SmtpTransport ('smtp.gmail.com', 465, 'ssl'))
  ->setUsername (EMAIL)
  ->setPassword (PASSWORD);

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer ($transport);

function sendVerificationEmail ($userEmail, $token) {
    global $mailer;
    $body = '<!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <title>Verify email</title>
        <link rel="stylesheet" href="http://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css">
        <style>
            .wrapper {
                background-color: black;
                color: whitesmoke;
            }
        </style>
    </head>
    
    <body>
        <div class="wrapper">
            <p>Thank you for signing up on our website. Please click on the link
               below to verify your email.
            </p>
            <a href="http://localhost/Proiect Info/homepage.php?token=' . $token . '">
                Verify your email address
            </a>
        </div>
    </body>
    
    </html>';

	// Create a message
    $message = (new Swift_Message ('Verify your email address'))
    ->setFrom (EMAIL)
    ->setTo ($userEmail)
    ->setBody ($body, 'text/html');

    // Send the message
    $result = $mailer->send ($message);
}

function sendPasswordResetLink ($userEmail, $token) {
    global $mailer;
    $body = '<!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <title>Reset Password</title>
        <link rel="stylesheet" href="http://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css">
        <style>
            .wrapper {
                background-color: black;
                color: whitesmoke;
            }
        </style>
    </head>
    
    <body>
        <div class="wrapper">
            <p>
                Hello there! Please click on the link below to reset your password!
            </p>
            <a href="http://localhost/Proiect Info/homepage.php?password-token=' . $token . '">
                Reset password
            </a>
        </div>
    </body>
    
    </html>';

	// Create a message
    $message = (new Swift_Message ('Reset your password'))
    ->setFrom (EMAIL)
    ->setTo ($userEmail)
    ->setBody ($body, 'text/html');

    // Send the message
    $result = $mailer->send ($message);
}