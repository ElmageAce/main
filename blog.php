<?php
require_once('core/init.php');

//instantiate new user
$user = new User();

$pageTitle = 'TWONE Blog';

$currentPage = 1;

$limit = 5;

//include header file
include_once('includes/header.inc.php');
//include body
require_once('views/blog_home.php');
//include footer
include_once('includes/footer.inc.php');


?>