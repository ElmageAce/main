<?php

class Page {
	private $_db;
	private $_pageData= null;
	private $_allPages = null;
	private $_filteredPages = null;
	private $_postCount = null;
	private $_pageId;

	public function __construct($page = null, $editMode = false) {

		if (is_null($page)) {

			$table = 'isPublished';

			$operator = '=';

			$page = 1;

		} elseif ($page === 'all') {
			
			$table = 'id';

			$operator = '>=';

			$page = 1;

		} else {

			$this->_pageId = (int) $page;

			$table = 'id';

			$operator = '=';

		}

		$this->_db = DB::getInstance();
		
		try {

			//get page data
			$pageData = $this->_db->get('post', array($table, $operator, $page));

			if ($pageData == false) {
				throw new Exception('Error getting page data');
				
			}

			if ($table === 'isPublished' OR $operator === '>=') {
				
				$this->_allPages = $pageData->results();

				$this->_postCount = count($this->_allPages);

			} elseif ($table === 'id' && ($pageData->first()->isPublished == true OR $editMode === true)) {
				
				$this->_pageData = $pageData->first();

			}

		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}

	public function getPageId() {
		return $this->_pageId;
	}

	public function getPostCount($filter = null, $countSelector = null) {

		if (!empty($filter)) {

			if ($filter === true) {
				return count($this->_filteredPages);
			}

			$j = 0;

			$cnt = (empty($this->_filteredPages) OR $countSelector === 'all') ? $this->_postCount : count($this->_filteredPages);

			for ($i=0; $i < $cnt; $i++) { 

				if ($filter[0] === 'author') {

					$pagefilter = $this->_allPages[$i]->creatorId;

				} elseif ($filter[0] === 'category') {

					$pagefilter = $this->_allPages[$i]->post_category;

				} elseif ($filter[0] === 'isPublished') {

					$pagefilter = $this->_allPages[$i]->isPublished;
					
				}

				if ($pagefilter == $filter[1]) {
					
					$j++;

				}

			}

			return $j;

		}

		return $this->_postCount;
	}

	public function getPageData() {
		return $this->_pageData;
	}

	public function setPageData($data) {
		$this->_pageData = $data;
	}

	public function getAllPages($filter = null, $filterSec = null) {

		if (!empty($filter)) {

			if (!empty($this->_filteredPages)) {
				
				return $this->_filteredPages;
				
			}

			$cnt = $this->getPostCount();

			$filteredData = [];

			$j = 0;
			
			for ($i=0; $i < $cnt; $i++) {

				if ($filter[0] === 'author') {

					$pagefilter = $this->_allPages[$i]->creatorId;

				} elseif ($filter[0] === 'category') {

					$pagefilter = $this->_allPages[$i]->post_category;

				} elseif ($filter[0] === 'isPublished') {

					$pagefilter = $this->_allPages[$i]->isPublished;
					
				} elseif ($filter[0] === 'dateAdded') {

					$pagefilter = $this->_allPages[$i]->dateAdded;
					
				} elseif ($filter[0] === 'isReviewed') {

					$pagefilter = $this->_allPages[$i]->isReviewed;
					
				} else {

					return false;
				}

				if ($filterSec) {
					
					if ($filterSec[0] === 'author') {

						$pagefilter2 = $this->_allPages[$i]->creatorId;

					} elseif ($filterSec[0] === 'category') {

						$pagefilter2 = $this->_allPages[$i]->post_category;

					} elseif ($filterSec[0] === 'isPublished') {

						$pagefilter2 = $this->_allPages[$i]->isPublished;
						
					} elseif ($filterSec[0] === 'dateAdded') {

						$pagefilter2 = $this->_allPages[$i]->dateAdded;
						
					}  else {

						return false;
					}
				}

				if (!empty($pagefilter2) && $pagefilter == $filter[1] && $pagefilter2 == $filterSec[1]) {
					
					$filteredData[$j] = $this->_allPages[$i];

					$j++;

				} elseif ($pagefilter == $filter[1] && $filter[0] != 'dateAdded') {
					
					$filteredData[$j] = $this->_allPages[$i];

					$j++;

				} elseif ($filter[0] === 'dateAdded') {
					
					$dateString = $this->formatDate($pagefilter, "F Y");

					//$dateFilter = $this->formatDate($filter[1], 'M Y');

					if ($filter[1] == $dateString) {
						
						$filteredData[$j] = $this->_allPages[$i];

						$j++;

					}
				}
			}

			$this->_filteredPages = $filteredData;

			return $this->_filteredPages;

		}

		return $this->_allPages;
	}

	public function getContent() {
		return $this->_pageData->content;
	}

	public function getIntro($count = 200, $type = null) {
		if (is_numeric($type)) {
			return substr(strip_tags ($this->getAllPages()[$type]->content), 0, $count) . '...';
		}
		return substr(strip_tags ($this->getContent()), 0, $count) . '...';
	}

	public function getLatestPages($amt) {

		if ($this->getAllPages() == null) {

			return false;

		}

		$pageNums = count($this->getAllPages());

		if ($pageNums < $amt) {
			return false;
		}

		$lastIndex = $pageNums - 1;

		$j = 0;

		$latestIndex = [];

		for ($i=$lastIndex; $i>=0; $i--) { 
			
			$latestIndex[$j] = $i;

			$j++;

			if ($amt == count($latestIndex)) {
				break;
			}
		}

		return $latestIndex;
	}

	public function formatDate($date, $format = null) {

		if ($format === true) {
			return date("F d, Y", strtotime($date));
		}

		if ($format === "F Y") {
			
			return date($format, strtotime($date));

		}

		if ($format === 'time') {
			$dateStr = date("F d, Y", strtotime($date));

			$dateStr .= ' AT ' . date("h:i A", strtotime($date));

			return $dateStr;
		}

		$presentTime = time();

		$dbTime = strtotime($date);

		$timeDiff = $presentTime - $dbTime;

		$hours = round($timeDiff / 60 / 60);

		if ($timeDiff < 3600 && $timeDiff > 0) {
			
			return ($timeDiff / 60) . 'minutes ago';

		} elseif ($hours == 1) {
			
			return $hours . ' hour ago';

		} elseif ($hours > 1 && $hours < 24 && $timeDiff > 0) {

			return $hours . ' hours ago';

		} elseif ($hours >= 24 && $hours < 36) {
			
			return 'Yesterday';

		} else {

			return date("F d, Y", strtotime($date));
		}

	}

	public function deletePost($id) {

		if ($this->_db->delete('post', array('id', '=', $id))) {
			return true;
		}

		return false;
	}

	public function trashPost($id) {

		//get post
		$postToTrash = $this->_db->get('post', array('id', '=', $id));

		if ($postToTrash == false) {
			
			return false;

		}

		$postObj = $postToTrash->first();

		if ($this->deletePost($id)) {
			
			if ($this->_db->insert('trash', array(
				'id' => $postObj->id,
				'creatorId' => $postObj->creatorId,
				'title' => $postObj->title,
				'content' => $postObj->content,
				'post_category' => $postObj->post_category,
				'dateAdded' => $postObj->dateAdded,
				'dateUpdated' => $postObj->dateUpdated
			))) {
				return true;
			}
		}

		return false;
	}

	public function newPost($field = array()) {

		if (!$this->_db->insert('post', $field)) {
			return false;
		}

		return true;
	}

	public function updatePost($id, $field = array()) {

		if (!$this->_db->update('post', 'id', $id, $field)) {
			return false;
		}

		return true;
	}

	public function getLastPublishedId() {

		return $this->_db->lastId();
	}

	public function getAllCategories() {

		$cat = $this->_db->get('categories', array('id', '>=', 1));

		if ($cat == true) {
			
			return $cat->results();

		}

		return false;
	}

	public function getCategoryName($id, $select = false) {

		$id = (int) $id;

		$cat = $this->_db->get('categories', array('id', '=', $id));

		if ($cat == true) {
			
			$category = $cat->first()->category_name;

			$isParent = $cat->first()->isParentCategory;

			if ($isParent == true OR $select == true) {
				
				return $category;

			}

			$parent = $cat->first()->parentCategoryId;

			$cat = $this->_db->get('categories', array('id', '=', $parent));

			if ($cat == true) {
				
				$categorySec = $cat->first()->category_name;

				return $category . '/' . $categorySec;
			}
		}
	}

	public function postComment($name, $email, $comment, $website = null) {

		if (empty($website)) {
			
			$website = '';

		}

		if (!$this->_db->insert('comments', array(
			'pageId' => $this->getPageId(),
			'name' => $name,
			'email' => $email,
			'website' => $website,
			'comment' => $comment,
			'isApproved' => false,
			'isTrashed' => false
		))) {

			return false;

		}

		$commentId = $this->_db->lastId();

		return $commentId;

	}

	public function getPageComments() {

		$pageId = $this->getPageId();

		$pageComments = $this->_db->get('comments', array('pageId', '=', $pageId));

		if ($pageComments == true) {

			$j = 0;

			$comments = [];
			
			for ($i=0; $i < $pageComments->count(); $i++) { 
				
				if ($pageComments->results()[$i]->isTrashed == false) {
					
					$comments[$j] = $pageComments->results()[$i];

					$j++;
				}
			}

			return $comments;
		}
	}

	public function getNewComment($status = '') {

		$newcomment = $this->_db->get('comments', array('isApproved', '=', false));

		if ($newcomment == true) {
			
			if ($status === 'count') {
				return $newcomment->count();

			}

			return $newcomment->results();
		}
	}

	public function getAllComments($filter = null) {

		$pageComments = $this->_db->get('comments', array('id', '>=', 1));

		if ($pageComments == true) {

			$cnt = $pageComments->count();

			$allComments = $pageComments->results();

			if (!empty($this->_allComments)) {
				
				$allComments = $this->_allComments;
				
			}

			$j = 0;

			$filterArray = [];

			if ($filter) {
				
				for ($i=0; $i < $cnt; $i++) {

					if ($filter == 'pending') {
					 	
					 	$obj = $allComments[$i]->isApproved;

					 	$value = false;

					} elseif ($filter == 'approved') {
						
						$obj = $allComments[$i]->isApproved;

					 	$value = true;

					} elseif ($filter == 'spam') {
						
						$obj = $allComments[$i]->isSpam;

					 	$value = true;

					} elseif ($filter == 'trash') {
						
						$obj = $allComments[$i]->isTrashed;

					 	$value = true;

					}
					
					if ($obj == $value) {
						
						$filterArray[$j] = $allComments[$i];

						$j++;
					}

				}

				return [count($filterArray), $filterArray];

			}

			$this->_allComments = $pageComments->results();
			
			return $pageComments->results();

		}

		return false;
	}

	public function getPost($id) {

		if (!empty($this->_allPages)) {
			
			for ($i=0; $i < count($this->_allPages); $i++) { 
				
				if ($this->_allPages[$i]->id == $id) {
					
					return $this->_allPages[$i];
				}
			}
		}

		$post = $this->_db->get('post', array('id', '=', $id));

		if ($post == true) {
			
			return $post->first();

		}

		return false;
	}

	public function moderateComment($id, $moderation) {

		$id = (int) $id;

		switch ($moderation) {
			case 'approve':
				
				if (!$this->_db->update('comments', 'id', $id, array('isApproved' => true, 'isSpam' => false))) {
					return false;
				}

				break;

			case 'isSpam':
				
				if (!$this->_db->update('comments', 'id', $id, array('isApproved' => false, 'isSpam' => true))) {
					return false;
				}
				
				break;

			case 'isTrash':
				
				if (!$this->_db->update('comments', 'id', $id, array('isTrashed' => true, 'isApproved' => false))) {
					return false;
				}
				
				break;

			case 'delete':
				
				if (!$this->_db->delete('comments', array('id', '=', $id))) {
					return false;
				}
				
				break;
			
			default:
				return false;
				break;
		}

		return true;
	}

	public function postCategory($name, $desc, $pId, $cmdStr = 'new') {

		$isParent = ($pId === '0') ? true : false;

		if ($cmdStr === 'new') {

			if ($this->_db->insert('categories', array(
				'category_name' => $name,
				'description' => $desc,
				'isParentCategory' => $isParent,
				'parentCategoryId' => $pId
			))) {
				
				return false;
			}
		}

		if (is_int($cmdStr)) {

			if ($this->_db->update('categories', 'id', $cmdStr, array(
				'category_name' => $name,
				'description' => $desc,
				'isParentCategory' => $isParent,
				'parentCategoryId' => $pId
			))) {
				
				return false;
			}
		}

		return true;

	}

	public function deleteCategory($id) {

		$id = (int) $id;

		if (!$this->_db->delete('categories', array('id', '=', $id))) {
			
			return false;
		}

		if (!$this->_db->update('post', 'post_category', $id, array(
			'post_category' => 0,
			'sub_category' => 0
		))) {
			return false;
		}

		if (!$this->_db->update('post', 'sub_category', $id, array(
			'post_category' => 0,
			'sub_category' => 0
		))) {
			return false;
		}

		return true;
	}

}

?>