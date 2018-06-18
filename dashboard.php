<?php
require_once('core/init.php');

$user = new User();

if(!$user->isLoggedIn()) {
    
    Redirect::to('login.php');

}

$page = new Page();

require_once('views/dashboard_header.inc.php');

$dashboard = " class=\"active\"";

require_once('views/dashboard_sidebar.inc.php');

require_once('views/dashboard.inc.php');

require_once('views/dashboard_footer.inc.php');

?>
