<?php
include 'config.php';
session_start();

$isLoggedIn = isset($_SESSION['user_id']);
$user_id = isset($_SESSION['user_id']);
// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page
    header("Location: login.php");
    exit();
}

$profileQuery = "SELECT * FROM admin_users WHERE id = $user_id";
$profileResult = $conn->query($profileQuery);

if ($profileResult->num_rows > 0) {
    $profileData = $profileResult->fetch_assoc();
    $username = $profileData['username'];
    $profileImage = $profileData['profile_image'];
} else {
    // Handle error or redirect as needed
    echo "Error: Admin profile not found!";
    exit();
}
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Admin Panel</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />


<!-- Icon and manifest links for various devices -->
<link rel="apple-touch-icon" sizes="180x180" href="../assets/img/favicon/apple-touch-icon.png" />
<link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicon/favicon-32x32.png" />
<link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicon/favicon-16x16.png" />
<link rel="icon" sizes="192x192" href="../assets/img/favicon/android-chrome-192x192.png" />
<link rel="icon" sizes="512x512" href="../assets/img/favicon/android-chrome-512x512.png" />
<link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
<link rel="manifest" href="../assets/img/favicon/site.webmanifest" />



  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/font-awesome.min.css" />
  <link rel="stylesheet" href="css/ionicons.min.css" />
  <link rel="stylesheet" href="css/datepicker3.css" />
  <link rel="stylesheet" href="css/all.css" />
  <link rel="stylesheet" href="css/select2.min.css" />
  <link rel="stylesheet" href="css/dataTables.bootstrap.css" />
  <link rel="stylesheet" href="css/jquery.fancybox.css" />
  <link rel="stylesheet" href="css/AdminLTE.min.css" />
  <link rel="stylesheet" href="css/_all-skins.min.css" />
  <link rel="stylesheet" href="css/on-off-switch.css" />
  <link rel="stylesheet" href="css/summernote.css" />
  <link rel="stylesheet" href="style.css" />
  <script src="https://kit.fontawesome.com/399b1d9929.js" crossorigin="anonymous"></script>

  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }

    #chat-box {
      max-width: 99%;
      margin: 20px auto;
      background-color: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    #chat-messages {
      height: 450px;
      overflow-y: scroll;
      padding: 10px;
    }

    .message-container {
      margin-bottom: 10px;
    }

    .sent-message {
      background-color: lightgreen;
      color: #888;
      border-radius: 15px;
      padding: 10px;
      position: relative;
      display: inline-block;
    }

    .sent-message img {
      max-width: 100px;
      display: block;
      margin-top: 5px;
    }

    .timestamp {
      font-size: 10px;
      color: #999;
      margin-top: 5px;
    }

    #attachment-preview {
      max-width: 100%;
      overflow: hidden;
      padding: 10px;
    }

    .input-container {
      position: relative;
    }

    input {
      width: calc(100% - 150px);
      padding: 10px;
      margin: 5px;
    }

    .attachment-icon {
      position: absolute;
      right: 120px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      border: none;
      width: 20px;
      background: #fff;
    }

    .send-btn {
      background-color: #3caea3;
      border-radius: 4px;
      color: #fff;
      width: 100px;
      padding: 10px;
      cursor: pointer;
      border: none;
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      height: 43px;
    }

    .send-btn:hover {
      background-color: #338a7d;
    }
  </style>
</head>

<body class="hold-transition fixed skin-blue sidebar-mini">
  <div class="wrapper">
    <header class="main-header">
      <a href="index" class="logo">
        <span class="logo-lg">PORTFOLIO ADMIN</span>
      </a>

      <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <span style="
              float: left;
              line-height: 50px;
              color: #fff;
              padding-left: 15px;
              font-size: 18px;
            ">Admin Panel</span>
        <!-- Top Bar ... User Inforamtion .. Login/Log out Area -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo $profileImage; ?>" class="user-image"
                alt="User Image">
                <span class="hidden-xs">
                  <?php echo $username; ?>
                </span>
              </a>
              <ul class="dropdown-menu">
                <li class="user-footer">
                  <div>
                    <a href="profile-edit" class="btn btn-default btn-flat">Edit Profile</a>
                  </div>
                  <div>
                    <a href="logout" class="btn btn-default btn-flat">Log out</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <?php $cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); ?>
    <!-- Side Bar to Manage Shop Activities -->
    <aside class="main-sidebar">
      <section class="sidebar">
        <ul class="sidebar-menu">
          <li class="treeview <?php if($cur_page == 'index.php') {echo 'active';} ?>">
            <a href="index">
              <i class="fa fa-dashboard"></i> <span>Home</span>
            </a>
          </li>



          <li class="treeview <?php if( ($cur_page == 'change_header.php') || ($cur_page == 'update_content.php') || ($cur_page == 'update_about.php') || ($cur_page == 'update_facts.php') || ($cur_page == 'update_skills.php') || ($cur_page == 'update_resume.php') || ($cur_page == 'update_portfolio.php') || ($cur_page == 'update_services.php') || ($cur_page == 'update_testinomials.php') || ($cur_page == 'update_contact.php') || ($cur_page == 'update_footer.php') ) {echo 'active';} ?>">
                        <a href="#">
                            <i class="fa fa-cogs"></i>
                            <span>website Settings</span>
                            <span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
                        </a>
                        <ul class="treeview-menu">
                        <li class="treeview <?php if( ($cur_page == 'change_header.php') ) {echo 'active';} ?>">
            <a href="change_header">
              <i class="fa fa-arrow-right"></i> <span>Head Settings</span>
            </a>
          </li>
          
          <li class="treeview <?php if( ($cur_page == 'update_content.php') ) {echo 'active';} ?>">
            <a href="update_content">
              <i class="fa fa-arrow-right"></i> <span>update Content</span>
            </a>
          </li>

          <li class="treeview <?php if( ($cur_page == 'update_about.php') ) {echo 'active';} ?>">
            <a href="update_about">
              <i class="fa fa-arrow-right"></i> <span>About Update</span>
            </a>
          </li>

          <li class="treeview <?php if( ($cur_page == 'update_facts.php') ) {echo 'active';} ?>">
            <a href="update_facts">
              <i class="fa fa-arrow-right"></i> <span>Update Facts</span>
            </a>
          </li>

          <li class="treeview <?php if( ($cur_page == 'update_skills.php') ) {echo 'active';} ?>">
            <a href="update_skills">
              <i class="fa fa-arrow-right"></i> <span>Update Skills</span>
            </a>
          </li>

          <li class="treeview <?php if( ($cur_page == 'update_resume.php') ) {echo 'active';} ?>">
            <a href="update_resume">
              <i class="fa fa-arrow-right"></i> <span>Update Resume</span>
            </a>
          </li>
          
          <li class="treeview <?php if( ($cur_page == 'update_portfolio.php') ) {echo 'active';} ?>">
            <a href="update_portfolio">
              <i class="fa fa-arrow-right"></i> <span>Update portfolio</span>
            </a>
          </li>

          <li class="treeview <?php if( ($cur_page == 'update_services.php') ) {echo 'active';} ?>">
            <a href="update_services">
              <i class="fa fa-arrow-right"></i> <span>Update services</span>
            </a>
          </li>

          <li class="treeview <?php if( ($cur_page == 'update_testinomials.php') ) {echo 'active';} ?>">
            <a href="update_testinomials">
              <i class="fa fa-arrow-right"></i> <span>Update Testimonials</span>
            </a>
          </li>
          
          <li class="treeview <?php if( ($cur_page == 'update_contact.php') ) {echo 'active';} ?>">
            <a href="update_contact">
              <i class="fa fa-arrow-right"></i> <span>Update contact</span>
            </a>
          </li>

          <li class="treeview <?php if( ($cur_page == 'update_footer.php') ) {echo 'active';} ?>">
            <a href="update_footer">
              <i class="fa fa-arrow-right"></i> <span>Update footer</span>
            </a>
          </li>

              </ul>
                </li>

                <li class="treeview <?php if($cur_page == 'site_visitors.php') {echo 'active';} ?>">
            <a href="site_visitors">
              <i class="fa fa-users"></i> <span>Site Visitors</span>
            </a>
          </li>

        </ul>
      </section>
    </aside>

    <div class="content-wrapper">