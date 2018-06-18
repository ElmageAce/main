<?php
require_once('core/init.php');

$user = new User();

try {

	if (!$user->canAddPost()) {
		
		Redirect::to(502);

	}

	if (!empty(Input::get('editPost'))) {
		
		$postId = (int) Input::get('editPost');

		if (!is_int($postId)) {
			
			throw new Exception("Invalid post id specified");

		}

		$page = new Page($postId, true);

		$pageData = $page->getPageData();
		
	}
	
	//get data
	if (Input::exists()) {
		
		if (Token::check(Input::get('token'))) {
			
			$validate = new Validate();

			$validation = $validate->check($_POST, array(
				'title' => array(
					'required' => true
				),
				'subtitle' => array(
					'required' => true
				),
				'mytextarea' => array(
					'required' => true
				)
			));

			if ($validation->passed()) {

				$page = new Page();

				if (Input::get('publish') == 'Publish') {
					
					//fields
					$creatorId = $user->data()->id;

					$blogTitle = escape(Input::get('title'));

					$blogSubtitle = escape(Input::get('subtitle'));

					$category = (!empty(Input::get('chkbox')) && is_array(Input::get('chkbox'))) ? Input::get('chkbox')[0] : '';

					$subCategory = (!empty(Input::get('subChkbox')) && is_array(Input::get('subChkbox'))) ? Input::get('subChkbox')[0] : '';

					$content = Input::get('mytextarea');

					$isReviewed = (Input::get('publishOption') === 'reviewPending') ? false : true;
					
					if (!$page->newPost(array(
						'creatorId' => $creatorId,
						'title' => $blogTitle,
						'subtitle' => $blogSubtitle,
						'post_category' => $category,
						'sub_category' => $subCategory,
						'content' => $content,
						'isPublished' => true,
						'isReviewed' => $isReviewed
					))) {
						
						throw new Exception("There was a problem publishing the blog");
						
					}

					$errorMsg = "<div class=\"row\">\n";

					$errorMsg .= "<div class=\"col-lg-12\">\n";

					$errorMsg .= "<div class=\"alert alert-success\">\n";

			        $errorMsg .= 'Post Published';

			        $errorMsg .= "<a href=\"page.php?id=" . $page->getLastPublishedId() . "\"> View Post</a>";

			        $errorMsg .= "</div>\n";

			        $errorMsg .= "</div>\n";

			        $errorMsg .= "</div>\n";

				}

				if (Input::get('saveDraft') !== false) {
					
					//fields
					$creatorId = $user->data()->id;

					$blogTitle = escape(Input::get('title'));

					$blogSubtitle = escape(Input::get('subtitle'));

					$category = (!empty(Input::get('chkbox')) && is_array(Input::get('chkbox'))) ? implode(',', Input::get('chkbox')) : '';

					$subCategory = (!empty(Input::get('subChkbox')) && is_array(Input::get('subChkbox'))) ? implode(',', Input::get('subChkbox')) : '';

					$content = Input::get('mytextarea');

					$isReviewed = (Input::get('publishOption') === 'reviewPending') ? false : true;
					
					if (!$page->newPost(array(
						'creatorId' => $creatorId,
						'title' => $blogTitle,
						'subtitle' => $blogSubtitle,
						'post_category' => $category,
						'sub_category' => $subCategory,
						'content' => $content,
						'isPublished' => false,
						'isReviewed' => $isReviewed
					))) {
						
						throw new Exception("There was an error saving the draft");
						
					}

					$errorMsg = "<div class=\"row\">\n";

					$errorMsg .= "<div class=\"col-lg-12\">\n";

					$errorMsg .= "<div class=\"alert alert-success\">\n";

			        $errorMsg .= 'Draft Saved';

			        $errorMsg .= "</div>\n";

			        $errorMsg .= "</div>\n";

			        $errorMsg .= "</div>\n";

				}

				if (Input::get('publish') == 'Publish Edit') {
					
					//fields
					$creatorId = $user->data()->id;

					$blogTitle = escape(Input::get('title'));

					$blogSubtitle = escape(Input::get('subtitle'));

					$category = (!empty(Input::get('chkbox')) && is_array(Input::get('chkbox'))) ? implode(',', Input::get('chkbox')) : '';

					$subCategory = (!empty(Input::get('subChkbox')) && is_array(Input::get('subChkbox'))) ? implode(',', Input::get('subChkbox')) : '';

					$content = Input::get('mytextarea');

					$isReviewed = (Input::get('publishOption') === 'reviewPending') ? false : true;
					
					if (!$page->updatePost($postId, array(
						'creatorId' => $creatorId,
						'title' => $blogTitle,
						'subtitle' => $blogSubtitle,
						'post_category' => $category,
						'sub_category' => $subCategory,
						'content' => $content,
						'isPublished' => true,
						'isReviewed' => $isReviewed
					))) {
						
						throw new Exception("There was a problem publishing the blog");
						
					}

					$errorMsg = "<div class=\"row\">\n";

					$errorMsg .= "<div class=\"col-lg-12\">\n";

					$errorMsg .= "<div class=\"alert alert-success\">\n";

			        $errorMsg .= 'Post Published';

			        $errorMsg .= "<a href=\"page.php?id=" . $postId . "\"> View Post</a>";

			        $errorMsg .= "</div>\n";

			        $errorMsg .= "</div>\n";

			        $errorMsg .= "</div>\n";
				}

			} else {

				$errorMsg = "<div class=\"row\">\n";

				$errorMsg .= "<div class=\"col-lg-12\">\n";

				$errorMsg .= "<div class=\"alert alert-danger\">\n";

		        foreach ($validation->errors() as $error) {

			        $errorMsg .= $error . "<br>\n";

				}

		        $errorMsg .= "</div>\n";

		        $errorMsg .= "</div>\n";

		        $errorMsg .= "</div>\n";

			}

		}
	}

} catch (Exception $e) {
	
}

if (empty($page)) {
	
	$page = new Page();
	
}

require_once('views/dashboard_header.inc.php');

$posts = " class=\"active\"";

require_once('views/dashboard_sidebar.inc.php');

require_once('views/post.php');

require_once('views/dashboard_footer.inc.php');


?>