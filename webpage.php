<?php
require_once('core/init.php');

$user = new User();

if(!$user->isLoggedIn()) {
    
    Redirect::to(502);

}

try {

	if (Input::exists('get')) {
		
		if (Input::get('author')) {
			
			if (!filter_var(Input::get('author'), FILTER_VALIDATE_INT, array('min_range' => 1))) {

				throw new Exception('An invalid author ID was provided to this page.');

			}

		}

		if (Input::get('published')) {
			
			if (!filter_var(Input::get('published'), FILTER_VALIDATE_INT, array('min_range' => 0))) {

				throw new Exception('An invalid published ID was provided to this page.');

			}

		}
	}

} catch (Exception $e) {

	echo "There was an error getting filter data";

	exit();
	
}

require_once('views/dashboard_header.inc.php');

$webpages = " class=\"active\"";

require_once('views/dashboard_sidebar.inc.php');

$page = new Page();

if (!empty(Input::get('author'))) {

	$author = (int) Input::get('author');

	$allPosts = $page->getAllPages(array('author', $author));

} elseif (!empty(Input::get('isPublished'))) {

	$published = (Input::get('isPublished') === 'true') ? true : false;
	
	$allPosts = $page->getAllPages(array('isPublished', $published));

} elseif (!Input::exists('get')) {
	
	$allPosts = $page->getAllPages();

}

$postCount = (Input::exists('get')) ? $page->getPostCount(true) : $page->getPostCount();

require_once('views/post_edit.php');

require_once('views/dashboard_footer.inc.php');

?>