<?php
// Include your database connection file
include 'config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Perform authentication (Replace this with your actual authentication logic)
    $loginQuery = "SELECT * FROM admin_users WHERE email = '$email' AND password = '$password'";
    $loginResult = $conn->query($loginQuery);

    if ($loginResult->num_rows > 0) {
        // Authentication successful, start a new session
        session_start();

        // Fetch user data
        $userData = $loginResult->fetch_assoc();

        // Store user ID in the session
        $_SESSION['user_id'] = $userData['id'];

        // Redirect to the dashboard or perform other actions
        header("Location: index.php");
        exit();
    } else {
        // Authentication failed, display an error message
        echo "Invalid email or password";
    }
}

// Close the database connection
$conn->close();
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="css/datepicker3.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/select2.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.css">
    <link rel="stylesheet" href="css/AdminLTE.min.css">
    <link rel="stylesheet" href="css/_all-skins.min.css">

    <link rel="stylesheet" href="style.css">
</head>

<body class="hold-transition login-page sidebar-mini">


<div class="login-box">
    <div class="login-logo">
        <b>Admin Panel</b>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Log in to start your session</p>

        <form action="login.php" method="post">
            <div class="form-group has-feedback">
                <input class="form-control" placeholder="Email address" name="email" type="email" autocomplete="off" autofocus required>
            </div>
            <div class="form-group has-feedback">
                <input class="form-control" placeholder="Password" name="password" type="password" autocomplete="off" value="" required>
            </div>
            <div class="row">
                <div class="col-xs-8"></div>
                <div class="col-xs-4">
                    <input type="submit" class="btn btn-success btn-block btn-flat login-button" name="form1" value="Log In">
                </div>
            </div>
        </form>
    </div>
</div>

<script src="js/jquery-2.2.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/select2.full.min.js"></script>
<script src="js/jquery.inputmask.js"></script>
<script src="js/jquery.inputmask.date.extensions.js"></script>
<script src="js/jquery.inputmask.extensions.js"></script>
<script src="js/moment.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/icheck.min.js"></script>
<script src="js/fastclick.js"></script>
<script src="js/jquery.sparkline.min.js"></script>
<script src="js/jquery.slimscroll.min.js"></script>
<script src="js/app.min.js"></script>
<script src="js/demo.js"></script>

</body>
</html>
