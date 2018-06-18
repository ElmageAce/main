<?php
require_once('core/init.php');

$user = new User();

if (!$user->isLoggedIn()) {
	
	Redirect::to('login.php');

}

try {
	
	$page = new Page();

	$currentPage = 1;

	$limit = 5;

	$allComments = $page->getAllComments();

	$postCount = count($allComments);

	$postCountAll = $postCount;

	if (Input::exists('get')) {
		
		if (!empty(Input::get('page'))) {
			
			$currentPage = (int) Input::get('page');

			$iteration = $limit * ($currentPage - 1);

			$postCount = $postCount - $iteration;

		}

		if (!empty(Input::get('pending'))) {
			
			if (Input::get('pending') == 1) {

				$commentData = $page->getAllComments('pending');
				
				$allComments = $commentData[1];

				$postCount = $commentData[0];

			}
		}

		if (!empty(Input::get('approved'))) {
			
			if (Input::get('approved') == 1) {

				$commentData = $page->getAllComments('approved');
				
				$allComments = $commentData[1];

				$postCount = $commentData[0];
				
			}
		}

		if (!empty(Input::get('spam'))) {
			
			if (Input::get('spam') == 1) {

				$commentData = $page->getAllComments('spam');
				
				$allComments = $commentData[1];

				$postCount = $commentData[0];
				
			}
		}

		if (!empty(Input::get('trash'))) {
			
			if (Input::get('trash') == 1) {

				$commentData = $page->getAllComments('trash');
				
				$allComments = $commentData[1];

				$postCount = $commentData[0];
				
			}
		}

		if (!empty(Input::get('action')) && !empty(Input::get('modComment'))) {
			
			if (!is_array(Input::get('modComment'))) {
				
				throw new Exception("Invalid comment selected");
				
			}

			$action = escape(Input::get('action'));

			$commentSelected = Input::get('modComment');

			if (!$user->isAdmin() && $action === 'delete') {
				
				throw new Exception("Only an admin can delete comments");

			}

			if (!$user->canEditPost() && ($action === 'approve' OR $action === 'isTrash')) {
				
				throw new Exception("You don't have editor privilages");

			}
			
			if (!$user->canAddPost() && $action === 'isSpam') {
				
				throw new Exception("You Don't have author privilages");

			}

				
			for ($i=0; $i < count($commentSelected); $i++) {

				$commentItr = escape($commentSelected[$i]); 
				
				if (!$page->moderateComment($commentItr, $action)) {
					
					throw new Exception("Error moderating comment");

				}
			}

			Redirect::to('comments.php');
			
		}

	}

} catch (Exception $e) {
	
	$e->getMessage();

	exit();

}

require_once('views/dashboard_header.inc.php');

$comments = " class=\"active\"";

require_once('views/dashboard_sidebar.inc.php');

require_once('views/comments_table.php');

require_once('views/dashboard_footer.inc.php');


?>