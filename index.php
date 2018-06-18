<?php
require_once('core/init.php');
//instantiate new user
$user = new User();

$pageTitle = 'HOME';

//include header file
include_once('includes/header.inc.php');
//include body
require_once('views/home.php');
//include footer
include_once('includes/footer.inc.php');


?>