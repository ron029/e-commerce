<?php
	
	class User extends CI_Model
	{
		public function get_user_full_name($id) {
			return $this->db->query("SELECT concat(first_name, ' ', last_name) as full_name FROM capstone.users WHERE id = ?", $id)->row_array();
		}
		public function check_user($post)
		{
			$query = ("SELECT * from users where email = ? and password = ?");
			$values = array($post['email_contact_number'], $post['password']);
			return $this->db->query($query, $values)->row_array();
		}
	}
