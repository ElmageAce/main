<?php

require_once('core/init.php');
//instantiate new user
$user = new User();

try {

	if (!Input::exists('get') || !filter_var(Input::get('id'), FILTER_VALIDATE_INT, array('min_range' => 1))) {

		throw new Exception('An invalid page ID was provided to this page.');

	}

	$page = new Page(Input::get('id'));

	//get page data
	$pageData = $page->getPageData();

	if (!is_object($pageData)) {

		throw new Exception('Could not access the page with specified ID.');

	}

	if (Input::exists()) {
		
		if (Token::check(Input::get('token'))) {
			
			//validate
			$validate = new Validate();

			if ($user->isLoggedIn()) {
				
				$validation = $validate->check($_POST, array(
					'message' => array(
						'required' => true,
						'min' => 4,
						'max' => 500
					)
				));

				if ($validation->passed()) {

					$name = (!empty($user->data()->publish_name)) ? $user->data()->publish_name : $user->data()->username;

					$email = $user->data()->email;

					$userComment = escape(Input::get('message'));

					$postComment = $page->postComment($name, $email, $userComment);
					
					if (!$postComment) {
						
						throw new Exception("could not post the comment");
						
					}

					$commentId = $postComment;

					//$link = 'page.php?id='. $page->getPageId() . '#comment-' . $postComment;
					$link = 'page.php?id='. $page->getPageId() . '#comment';

					Redirect::to($link);
				}

			} else {

				$validation = $validate->check($_POST, array(
					'name' => array(
						'required' => true,
						'min' => 4,
						'max' => 20
					),
					'email' => array(
						'required' => true,
					),
					'message' => array(
						'required' => true,
						'min' => 4,
						'max' => 500
					)
				));

				if ($validation->passed()) {
					
					$name = escape(Input::get('name'));

					$email = escape(Input::get('email'));

					$userComment = escape(Input::get('message'));

					$website = (!empty(Input::get('website'))) ? escape(Input::get('website')) : '';

					$postComment = $page->postComment($name, $email, $userComment, $website);

					if (!$postComment) {
						
						throw new Exception("could not post the comment");
						
					}

					$commentId = $postComment;

					//$link = 'page.php?id='. $page->getPageId() . '#comment-' . $postComment;
					$link = 'page.php?id='. $page->getPageId() . '#comment';

					Redirect::to($link);
				}
			}
		}
	}

	$pageTitle = $pageData->title;

	$author = clone $user;

    $id = $pageData->creatorId;

    $authorData = $author->find($id);

    if ($authorData == false) {
    	Redirect::to(409);
    }

   $authorName = $author->data()->username;

   $currentLink = $_SERVER["REQUEST_URI"];

   $pageId = Input::get('id');

   $isReviewed = $pageData->isReviewed;

	if (Input::exists('get') && $user->canEditPost() && $isReviewed == false) {
	    
	    if (Input::get('rate') && Input::get('id')) {
	        
	        $rating = (int) escape(Input::get('rate'));

	        $update = $page->updatePost($pageId, array('isReviewed' => true, 'rating' => $rating));

	        if (!$update) {

	            throw new Exception("could not rate the post");

	        }

	    }
	}

} catch (Exception $e) {
	
	echo $e->getMessage();

	exit();
}

//include header file
include_once('includes/header.inc.php');

$datePosted = strtotime($pageData->dateAdded);

$datePosted = date("F d, Y", $datePosted);

//require blog post
require_once('views/blog_post.php');

if ($user->canEditPost() && $isReviewed == false) {

	require_once('views/post_review.php');

}

//require comments
require_once('views/comment_list.php');

if ($user->isLoggedIn()) {
	require_once('views/comment_in.php');
} else {
	require_once('views/comment_out.php');
}

//include footer
include_once('includes/footer.inc.php');




?>