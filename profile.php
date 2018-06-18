<?php
require_once('core/init.php');

$visitor = new User();

if(!$visitor->isLoggedIn()) {
    
    Redirect::to(502);

}

try {

	if (Input::exists('get')) {

		if (Input::get('id')) {
			
			if (!filter_var(Input::get('id'), FILTER_VALIDATE_INT, array('min_range' => 0))) {

				throw new Exception('An invalid profile ID was provided to this page.');

			}

		}

		$user = new User(Input::get('id'));

		$visitorId = (int) $visitor->data()->id;

		$userId = (int) $user->data()->id;

		if (!$visitor->isAdmin() && $userId !== $visitorId) {
			
			Redirect::to(502);

		}
	}

	if (Input::exists()) {
		
		if (Token::check(Input::get('token'))) {
			
			$validate = new Validate();

			$validation = $validate->check($_POST, array(
				'first_name' => array(
					'required' => true,
					'min' => 3,
					'max' => 20,
				),
				'last_name' => array(
					'required' => true,
					'min' => 3,
					'max' => 20,
				),
				'publish_name' => array(
					'required' => true,
					'min' => 3,
					'max' => 40,
				),
				'email' => array(
					'required' => true,
					'min' => 8
				)
			));

			if ($validation->passed()) {
				
				$salt = Hash::salt(32);

				$user->update($userId, array(
					'first_name' => Input::get('first_name'),
					'last_name' => Input::get('last_name'),
					'publish_name' => Input::get('publish_name'),
					'email' => Input::get('email'),
					'bio' => Input::get('bio')
				));

				echo "<div class=\"upd-error\">";

				echo "<div class=\"alert alert-success\">";

		        echo 'Records updated!';

		        echo "</div>\n";

				echo "</div>\n";

			} else {

				echo "<div class=\"upd-error\">";

				foreach ($validation->errors() as $error) {
					echo "<div class=\"alert alert-danger\">";

			          echo $error;

			        echo "</div>\n";
				}

				echo "</div>\n";
			}

		}
	}

} catch (Exception $e) {

	echo $e->getMessage();
	
}

require_once('views/dashboard_header.inc.php');

$profile = " class=\"active\"";


require_once('views/dashboard_sidebar.inc.php');

require_once('views/user_profile.php');

require_once('views/dashboard_footer.inc.php');

?>