<?php
require_once('core/init.php');
//instantiate new user
$user = new User();

if (!$user->isLoggedIn()) {
	Redirect::to('login.php');
}

$pageTitle = 'Register';


//include header file
include_once('includes/header.inc.php');

if (!$user->isAdmin()) {
	
	Redirect::to(502);

} else {

	if (Input::exists()) {
		
		if (Token::check(Input::get('token'))) {
			
			$validate = new Validate();

			$validation = $validate->check($_POST, array(
				'username' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'unique' => 'users'
				),
				'password' => array(
					'required' => true,
					'min' => 10
				),
				'password_again' => array(
					'required' => true,
					'matches' => 'password'
				),
				'email' => array(
					'required' => true,
					'min' => 2,
					'max' => 100
				)
			));

			if ($validation->passed()) {

				$salt = Hash::salt(32);

				try {

					$user->create(array(
						'userType' => 'public',
						'username' => Input::get('username'),
						'email' => Input::get('email'),
						'password' => Hash::make(Input::get('password'), $salt),
						'salt' => $salt
					));

				} catch(Exception $e) {

					die($e->getMessage());

				}

				Redirect::to('dashboard.php');
				
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

}

if (!$user->isAdmin()) {
	//register user
} else {

	require_once('views/register_form.php');

}

//include footer
include_once('includes/footer.inc.php');


?>