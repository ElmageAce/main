<?php
require_once('core/init.php');

$user = new User();

if(!$user->isLoggedIn()) {
    
    Redirect::to('login.php');

} elseif (!$user->isAdmin()) {
	
	Redirect::to(502);

}

try {

	if (Input::exists('get')) {
		
		if (Input::get('users')) {
			
			if (!filter_var(Input::get('users'), FILTER_SANITIZE_STRING)) {

				throw new Exception('An invalid user type was provided to this page.');

			}

		}

		if (Input::get('published')) {
			
			if (!filter_var(Input::get('published'), FILTER_VALIDATE_INT, array('min_range' => 0))) {

				throw new Exception('An invalid published ID was provided to this page.');

			}

		}
	}

} catch (Exception $e) {

	echo "There was an error getting filtered data\n";

	echo $e->getMessage();

	exit();
	
}

if (!empty(Input::get('users'))) {

	$userType = escape(Input::get('users'));

	$allUsers = $user->getUsers($userType);

} else {

	$allUsers = $user->getUsers();

}

$postCount = (!empty(Input::get('users')))? $user->countUsers($userType) : $user->countUsers();

$currentPage = 1;

$limit = 5;

try {
	
	if (Input::exists('get')) {
	
		if (Input::get('apply') && Input::get('action') == 'remove' && !empty(Input::get('chkbox'))) {
			
			if (!is_array(Input::get('chkbox'))) {
				
				throw new Exception("You have provided an invalid user");
				
			}

			$arrCount = count(Input::get('chkbox'));

			for ($i=0; $i < $arrCount; $i++) {

				$userId = (int) Input::get('chkbox')[$i]; 
				
				if ($user->removeUser($userId) === false) {
					
					throw new Exception("Error Deleting User");
					
				}

				$errorMsg = "<div class=\"row\">\n";

				$errorMsg .= "<div class=\"col-lg-12\">\n";

				$errorMsg .= "<div class=\"alert alert-success\">\n";

		        $errorMsg .= 'User(s) deleted';

		        $errorMsg .= "</div>\n";

		        $errorMsg .= "</div>\n";

		        $errorMsg .= "</div>\n";

			}

		}

		if (Input::get('change') && !empty(Input::get('userRole')) && !empty(Input::get('chkbox'))) {
			
			if (!is_array(Input::get('chkbox'))) {
				
				throw new Exception("You have provided an invalid user");
			}

			$arrCount = count(Input::get('chkbox'));

			$userRole = escape(Input::get('userRole'));

			for ($i=0; $i < $arrCount; $i++) { 
				
				$userId = (int) Input::get('chkbox')[$i];

				if ($user->changeRole($userId, $userRole) === false) {
					
					throw new Exception("Error changing user role");
				}

				$errorMsg = "<div class=\"row\">\n";

				$errorMsg .= "<div class=\"col-lg-12\">\n";

				$errorMsg .= "<div class=\"alert alert-success\">\n";

		        $errorMsg .= 'User(s) role changed!';

		        $errorMsg .= "</div>\n";

		        $errorMsg .= "</div>\n";

		        $errorMsg .= "</div>\n";
			}
		}

		if (!empty(Input::get('page'))) {
			
			$currentPage = (int) Input::get('page');

			$iteration = $limit * ($currentPage - 1);

			$postCount = $postCount - $iteration;

		}
	}

} catch (Exception $e) {

	echo $e->getMessage();

	exit();

}

require_once('views/dashboard_header.inc.php');

$users = " class=\"active\"";

require_once('views/dashboard_sidebar.inc.php');

require_once('views/blog_users.php');

require_once('views/dashboard_footer.inc.php');

?>