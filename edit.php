<?php
require_once('core/init.php');

$user = new User();

if(!$user->isLoggedIn()) {
    
    Redirect::to('login.php');

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

try {
	
	$page = new Page('all');

	$currentPage = 1;

	$limit = 5;

	if (!empty(Input::get('author'))) {

		$author = (int) Input::get('author');

		$allPosts = $page->getAllPages(array('author', $author));

	} elseif (!empty(Input::get('isPublished'))) {

		$published = (Input::get('isPublished') === 'true') ? true : false;
		
		$allPosts = $page->getAllPages(array('isPublished', $published));

	} else {
		
		$allPosts = $page->getAllPages();

	}

	$postCount = (Input::exists('get')) ? $page->getPostCount(true) : $page->getPostCount();

	if (Input::exists('get')) {
		
		//to delete post
		if (Input::get('apply') !== false && !empty(Input::get('chkbox')) && Input::get('actions') == 'delete' && $user->isAdmin()) {

			$chk = Input::get('chkbox');

			for ($i=0; $i < count($chk); $i++) { 
				
				if (!$page->deletePost($chk[$i])) {

					throw new Exception("Error deleting selected post(s)");
					
				}

			}

			$errorMsg = "<div class=\"row\">";

			$errorMsg .= "<div class=\"alert alert-success\">";

	        $errorMsg .= 'Post Deleted';

	        $errorMsg .= "</div>\n";

	        $errorMsg .= "</div>\n";

		}

		//to trash post
		if (Input::get('apply') !== false && !empty(Input::get('chkbox')) && Input::get('actions') == 'trash' && $user->canEditPost()) {

			$chk = Input::get('chkbox');

			for ($i=0; $i < count($chk); $i++) { 

				if (!$page->trashPost(escape(Input::get('chkbox')))) {
					
					throw new Exception("Error deleting selected post(s)");

				}

			}
		
			$errorMsg = "<div class=\"row\">";

			$errorMsg .= "<div class=\"alert alert-success\">";

	        $errorMsg .= 'Post moved to Trash';

	        $errorMsg .= "</div>\n";

	        $errorMsg .= "</div>\n";

		}

		//to filter via date
		if (Input::get('cat') != '0' && !empty(Input::get('dateFilter')) && Input::get('filter') !== false) {

			$dateFilter = escape(Input::get('dateFilter'));

			$cat = escape(Input::get('cat'));
			
			$allPosts = $page->getAllPages(array('category', $cat), array('dateAdded', $dateFilter));

			$postCount = count($allPosts);

		} elseif (!empty(Input::get('dateFilter')) && Input::get('filter') !== false) {

			$dateFilter = escape(Input::get('dateFilter'));
			
			$allPosts = $page->getAllPages(array('dateAdded', $dateFilter));

			$postCount = count($allPosts);

		} elseif (!empty(Input::get('cat')) && Input::get('filter') !== false) {

			$cat = escape(Input::get('cat'));
			
			$allPosts = $page->getAllPages(array('category', $cat));

			$postCount = count($allPosts);

		}

		if (!empty(Input::get('page'))) {
			
			$currentPage = (int) Input::get('page');

			$iteration = $limit * ($currentPage - 1);

			$postCount = ($postCount == 0) ? $page->getPostCount() - $iteration : $postCount - $iteration;

		}

		//to edit post
		if (Input::get('apply') == 'post' && !empty(Input::get('chkbox')) && Input::get('actions') == 'edit' && $user->canEditPost()) {
			
			//can only select one to edit
			if (!is_array(Input::get('chkbox'))) {
				
				throw new Exception("Invalid checked element");
				
			} elseif (count(Input::get('chkbox')) > 1) {
				
				throw new Exception("Cannot select multiple post to edit");

			}

			//get value of checked element
			$pageId = (int) Input::get('chkbox')[0];

			$link = 'new_post.php?editPost=' . $pageId;

			//redirect to edit page
			Redirect::to($link);

		}

		//to edit category
		if (Input::get('apply') == 'editCategory' && !empty(Input::get('categoryCheck')) && Input::get('actions') == 'editCategory' && $user->canEditPost()) {
			
			//can only select one to edit
			if (!is_array(Input::get('categoryCheck'))) {
				
				throw new Exception("Invalid checked element");
				
			} elseif (count(Input::get('categoryCheck')) > 1) {
				
				throw new Exception("Cannot select multiple categories to edit");

			}

			//get value of checked element
			$catId = (int) Input::get('categoryCheck')[0];

			$link = 'edit.php?modCategory=true&editCat=' . $catId;

			//redirect to edit page
			Redirect::to($link);

		}

		if (!empty(Input::get('editCat'))) {
			
			$editCat = escape(Input::get('editCat'));

		}

		//to delete category
		if (Input::get('actions') == 'deleteCategory' && !empty(Input::get('categoryCheck')) && $user->canEditPost()) {
			
			if (!is_array(Input::get('categoryCheck'))) {
				
				throw new Exception("Invalid checked element");
				
			}

			$arrCnt = count(Input::get('categoryCheck'));

			for ($i=0; $i < $arrCnt; $i++) {

				$cat = escape(Input::get('categoryCheck')[$i]); 
				
				if (!$page->deleteCategory($cat)) {
					
					throw new Exception("Error deleting category");

				}
			}

			Redirect::to('edit.php?modCategory=true');

		}

	}

	//post form
	if (Input::exists('post') && $user->canEditPost()) {
		
		if (Token::check(Input::get('token'))) {
			
			$validate = new Validate();

			if (empty($editCat)) {
				
				$validation = $validate->check($_POST, array(
					'category_name' => array(
						'required' => true,
						'min' => 3,
						'max' => 40,
						'unique' => 'categories'
					),
					'description' => array(
						'required' => true,
						'min' => 10
					),
					'parent' => array(
						'required' => true
					)
				));

			} else {

				$validation = $validate->check($_POST, array(
					'category_name' => array(
						'required' => true,
						'min' => 3,
						'max' => 40
					),
					'description' => array(
						'required' => true,
						'min' => 10
					)
				));

			}

			if ($validation->passed()) {

				$cmd = (empty($editCat)) ? 'new' : (int) $editCat;
				
				//get name
				$catName = escape(Input::get('category_name'));

				$description = escape(Input::get('description'));

				$parent = escape(Input::get('parent'));


				if ($page->postCategory($catName, $description, $parent, $cmd) === true) {
					
					Redirect::to('edit.php?modCategory=true');
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
	
	echo $e->getMessage();

	exit();
}

require_once('views/dashboard_header.inc.php');

$posts = " class=\"active\"";

require_once('views/dashboard_sidebar.inc.php');

if (!empty(Input::get('modCategory')) && $user->canEditPost()) {
	
	require_once('views/modCategory.php');

} else {

	require_once('views/post_edit.php');

}

require_once('views/dashboard_footer.inc.php');

?>