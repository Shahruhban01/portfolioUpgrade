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

<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
    <h1>Contact Us</h1>

<form method="post">

<div class="mb-3 mx-5">
  <label for="name" class="form-label">Name</label>
  <input type="text" class="form-control" id="name" name="name" placeholder="Your name">
</div>

    <div class="mb-3 mx-5">
  <label for="email" class="form-label">Email address</label>
  <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
</div>

<div class="mb-3 mx-5">
  <label for="subject" class="form-label">Subject</label>
  <input type="text" class="form-control" id="subject" name="subject" ">
</div>

<div class="mb-3 mx-5">
  <label for="message" class="form-label">Message</label>
  <textarea class="form-control" id="message" name="message" rows="5"></textarea>
</div>

<div class="mb-3 mx-5">
    <button class="btn btn-primary" type="submit">Submit form</button>
  </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>