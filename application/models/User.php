<?php
	
	class User extends CI_Model
	{
		public function check_user($post) {
			$query = ("SELECT * from users where email = ? and password = ?");
			$values = array($post['email_contact_number'], $post['password']);
			return $this->db->query($query, $values)->row_array();
		}
	}
