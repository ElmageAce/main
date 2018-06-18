<?php
require_once('core/init.php');

$pageTitle = 'Login';

$user = new User();

if (Input::exists()) {
	
	if (Token::check(Input::get('token'))) {

		$validate = new Validate();

		$validation = $validate->check($_POST, array(
			'username' => array('required' => true),
			'password' => array('required' => true)
		));

		if ($validation->passed()) {

			$remember = (Input::get('remember') === 'on') ? true : false;
			
			$login = $user->login(Input::get('username'), Input::get('password'), $remember);

			if ($login) {
				Redirect::to('index.php');
			} else {
				echo "<div class=\"reg-error\">";

				echo "<div class=\"alert alert-danger\">";

				echo "Username and/or Password Incorrect";

				echo "</div>\n";

				echo "</div>\n";
			}

		} else {
			echo "<div class=\"reg-error\">";

			foreach ($validation->errors() as $error) {
				echo "<div class=\"alert alert-danger\">";

		        echo $error;

		        echo "</div>\n";
			}

			echo "</div>\n";
		}

	}

}

//include header file
include_once('includes/header.inc.php');

require_once('views/login_form.php');
//include footer
include_once('includes/footer.inc.php');


?>