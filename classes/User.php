<?php

/**
* user class, invloving users, authors, admins, and all related actions
*/
class User {

	private $_db;
	private $_data;
	private $_sessionName;
	private $_cookieName;
	private $_isLoggedIn = false;
	
	function __construct($user = null) {

		$this->_db = DB::getInstance();

		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie_name');

		if (!$user) {
			if (Session::exists($this->_sessionName)) {

				$user = Session::get($this->_sessionName);
				
				if($this->find($user)) {
					$this->_isLoggedIn = true;
				} else {
					$this->_isLoggedIn = false;
				}
			}
		} else {
			$this->find($user);
		}

	}

	public function update($id = null, $fields = array()) {

		if (!$id && $this->isLoggedIn()) {
			$id = $this->data()->id;
		}

		if (!$this->_db->update('users', 'id', $id, $fields)) {
			throw new Exception('There was a problem updating');
		}
	}

	public function create($fields = array()) {
		if (!$this->_db->insert('users', $fields)) {
			throw new Exception('There was a problem creating an account.');
			
		}
	}

	public function find($user = null) {
		if ($user) {
			$field = (is_numeric($user)) ? 'id' : 'username';
			$data = $this->_db->get('users', array($field, '=', $user));

			if ($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function login ($username = null, $password = null, $remember = false) {


		if (!$username && !$password && $this->exists()) {
			Session::put($this->_sessionName, $this->data()->id);
		} else {
			$user = $this->find($username);

			if ($user) {
				
				if ($this->data()->password === Hash::make($password, $this->data()->salt)) {

					Session::put($this->_sessionName, $this->data()->id);

					if ($remember) {
						$hash = Hash::unique();
						$hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

						if (!$hashCheck->count()) {
							$this->_db->insert('users_session', array(
								'user_id' => $this->data()->id,
								'hash' => $hash
							));
						} else {
							$hash = $hashCheck->first()->hash;
						}

						Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
					}

					return true;
				}
			}
		}

		return false;
	}

	public function exists() {
		return (!empty($this->_data)) ? true : false;
	}

	public function logout() {
		$this->_db->delete('users_session', array('user_id', '=', $this->data()->id));

		Session::delete($this->_sessionName);

		Cookie::delete($this->_cookieName);

	}

	public function data() {
		return $this->_data;
	}

	public function isLoggedIn() {
		return $this->_isLoggedIn;
	}

	public function isOga($id = null) {

		if (!empty($id)) {
			
			$user = $this->_db->get('users', array('id', '=', $id));

			if ($user == true) {
				
				return ($user->first()->id == 'superAdmin') ? true : false;
			}
		}

		if ($this->isLoggedIn() === false) {

			return false;

		} else {

			$userType = $this->data()->userType;

			return ($userType === 'superAdmin') ? true : false;

		}

	}

	public function isAdmin() {

		if ($this->isLoggedIn() === false) {

			return false;

		} else {

			$userType = $this->data()->userType;

			return ($userType === 'admin' OR $userType === 'superAdmin') ? true : false;

		}

		

	}

	public function isEditor() {
		$userType = (!empty($this->data()->userType)) ? $this->data()->userType : false;

		return ($userType === 'editor') ? true : false;
	}


	public function isAuthor() {
		$userType = $this->data()->userType;

		return ($userType === 'author') ? true : false;
	}

	public function canAddPost() {
		return ($this->isOga() OR $this->isAdmin() OR $this->isEditor() OR $this->isAuthor()) ? true : false;
	}

	public function canEditPost() {
		return ($this->isOga() OR $this->isAdmin() OR $this->isEditor()) ? true : false;
	}

	public function canEditPage() {
		return ($this->isAdmin()) ? true : false;
	}

	public function canCreatePage() {
		return ($this->isAdmin() OR $this->isAuthor()) ? true : false;
	}

	public function getAuthor($id) {

		$author = $this->_db->get('users', array('id', '=', $id));

		if ($author == true) {
			return $author->first();
		}
		return false;
	}

	public function countUsers($userType = null) {

		$users = ($userType) ? $this->_db->get('users', array('userType', '=', $userType)) : $this->_db->get('users', array('id', '>=', 1));

		if ($users == true) {
			
			return $users->count();

		} else {

			return false;

		}
	}

	public function getUsers($userType = null) {

		if ($userType) {
			
			$users = $this->_db->get('users', array('userType', '=', $userType));

			if ($users == true && $users->count() > 0) {
				
				return $users->results();

			} else {

				return false;
				
			}

		}

		$users = $this->_db->get('users', array('id', '>=', 1));

		if ($users == true) {
			
			return $users->results();

		}
	}

	public function getSuperAdmin() {

		$admin = $this->_db->get('users', array('userType', '=', 'superAdmin'));

		if ($admin == true) {
			
			return $admin->first()->id;
		}
	}

	public function getUserPostCount($id) {

		$data = $this->_db->get('post', array('creatorId', '=', $id));

		if ($data == true) {
			
			return $data->count();

		}

		return false;
	}

	public function removeUser($id) {

		if ($this->isOga($id) === true) {
			
			return false;
		}

		$SAdminId = $this->getSuperAdmin();

		//transfer user posts to superAdmin
		if (!$this->_db->update('post', 'creatorId', $id, array('creatorId' => $SAdminId, 'isReviewed' => false))) {
			
			return false;
		}

		//transfer all user trash
		if (!$this->_db->update('trash', 'creatorId', $id, array('creatorId' => $SAdminId))) {
			
			return false;
		}

		if (!$this->_db->delete('users', array('id', '=', $id))) {
			
			return false;
		}

		return true;
	}

	public function changeRole($id, $role) {

		if ($this->isAdmin() === false) {
			return false;
		}

		//cannot change role of sadmin
		if ($this->isOga($id) === true) {
			return true;
		}

		if (!$this->_db->update('users', 'id', $id, array('userType' => $role))) {
			return false;
		}

		return true;
	}

}


?>