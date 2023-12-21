<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Replace with your receiving email address
    $to_email = 'contact@ruhbanabdulla.in';
    
    // Extract form fields
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Validate inputs (you can add more validation as needed)
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo 'All fields are required.';
        exit;
    }

    // Compose the email content
    // $email_content = "Name: $name\n";
    // $email_content .= "Email: $email\n";
    // $email_content .= "Subject: $subject\n";
    // $email_content .= "Message:\n$message\n";
    $email_content .= "$message\n";


    // Set the email headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    
    // Send the email
    if (mail($to_email, $subject, $email_content, $headers)) {
        echo '<div class="alert alert-primary" role="alert">Message sent successfully!</div>';
    } else {
        echo 'Failed to send the message. Please try again later.';
    }
}
?>