<?php
class Redirect {
	public static function to($location = null) {
		if ($location) {
			if (is_numeric($location)) {
				switch ($location) {
					case '404':
						header('HTTP/1.0 404 Not Found');
						include 'includes/errors/404.php';
						exit();
					break;
					case '502':
						header('HTTP/1.0 404 Not Found');
						include 'includes/errors/502.php';
						exit();
					break;
					case '148':
						header('HTTP/1.0 404 Not Found');
						include 'includes/errors/148.php';
						exit();
					break;
					case '408':
						header('HTTP/1.0 404 Not Found');
						include 'includes/errors/408.php';
						exit();
					break;
					case '409':
						header('HTTP/1.0 404 Not Found');
						include 'includes/errors/409.php';
						exit();
					break;
					case '504':
						header('HTTP/1.0 404 Not Found');
						include 'includes/errors/504.php';
						exit();
					break;
				}
			}
			header('Location: ' . $location);
			exit();
		}
	}


}

?>