<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php echo (!empty($pageTitle)) ? $pageTitle : 'Welcome to TWONE Studios'; ?></title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="lib/animate/animate.min.css" rel="stylesheet">
  <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/mystyle.css" rel="stylesheet">

  <!-- =======================================================
    Theme Name: Regna
    Theme URL: https://bootstrapmade.com/regna-bootstrap-onepage-template/
    Author: BootstrapMade.com
    License: https://bootstrapmade.com/license/
  ======================================================= -->
</head>

<body>

  <!--==========================
  Header
  ============================-->
  <header id="header">
    <div class="container">

      <div id="logo" class="pull-left">
      <!--
        <a href="#hero"><img src="img/logo.png" alt="" title="" /></img></a>
      -->
        <!-- Uncomment below if you prefer to use a text logo -->
        <h1><a href="index.php#hero">TWONE</a></h1>
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="index.php#hero">Home</a></li>
          <?php if ($user->isLoggedIn() && $pageTitle != 'HOME') { echo '<li><a href="logout.php">Logout</a></li>'; } elseif(($pageTitle != 'HOME' OR empty($pageTitle))) { echo '<li><a href="login.php">Login</a></li>'; } ?>
          <?php if (($user->isAdmin()) && ($pageTitle != 'HOME' OR empty($pageTitle))) { echo "\n" . '<li><a href="register.php">Register User</a></li>' . "\n" ; }?>
          <?php
          if ($pageTitle === 'HOME') {
            ?>
              <li><a href="index.php#services">Services</a></li>
              <li><a href="index.php#portfolio">Portfolio</a></li>
              <li><a href="index.php#blog">Latest News</a></li>
          <?php

            }

            ?>
          <?php
          if ($pageTitle != 'HOME') {
            ?>
              <li class="menu-has-children"><a href="">Categories</a>
                <ul>
                  <li><a href="#">Web Development</a></li>
                  <li class="menu-has-children"><a href="#">Mobile App Design</a>
                    <ul>
                      <li><a href="#">IOS</a></li>
                      <li><a href="#">Android</a></li>
                      <li><a href="#">Misc</a></li>
                    </ul>
                  </li>
                  <li><a href="#">Mobile App Designs</a></li>
                  <li><a href="#">Graphic Designs</a></li>
                  <li><a href="#">SEO</a></li>
                </ul>
              </li>
          <?php
        }

          ?>
          <?php if($pageTitle !== 'TWONE Blog') {echo "<li><a href=\"blog.php\">Blog</a></li>";}
            else{echo "<li><a href=\"archive.php\">Archives</a></li>";}?>
          <li><a href="index.php#about">About Us</a></li>
          <li><a href="index.php#contact">Contact Us</a></li>
          <?php if ($user->isLoggedIn()) { echo "\n" . '<li><a href="dashboard.php">Dashboard</a></li>' . "\n" ; }?>
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->