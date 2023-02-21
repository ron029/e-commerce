<?php
	
	class Product extends CI_Model
	{
		public function delete_category($post) {
			$this->db->query("DELETE FROM capstone.categories WHERE id = ?", $post);
		}
//		public function get_id_new_product() {
//			$query = ("SELECT id FROM capstone.products WHERE name = ? AND category_id = ? AND ")
//		}
		public function get_id_new_category($new_category)
		{
			$query = ("SELECT id FROM capstone.categories WHERE name = ?");
			$values = array($new_category);
			return $this->db->query($query, $values)->row_array();
		}
		
		public function add_product($post, $category_id)
		{
			$query = ("INSERT INTO capstone.products (category_id, name, description, price, stock) VALUES (?,?,?,?,?)");
			$values = array($category_id, $post['product_name'], $post['product_desc'], $post['product_price'], $post['product_qty']);
			return $this->db->query($query, $values);
		}
		
		public function add_category($category_name)
		{
			return $this->db->query("INSERT INTO capstone.categories (name) VALUES (?)", $category_name);
		}
		
		public function edit_category($post, $id)
		{
			$query = "UPDATE categories SET categories.name = ? where id = ?";
			$value = array($post['name'], $id);
			return $this->db->query($query, $value);
		}
		
		public function get_product_by_id($id)
		{
			return $this->db->query("SELECT products.*, categories.name as category_name FROM capstone.products left join categories on categories.id = products.category_id where products.id = ?", $id)->row_array();
		}
		
		public function get_category()
		{
			return $this->db->query("SELECT * FROM capstone.categories")->result_array();
		}
		
		public function get_product()
		{
			return $this->db->query("SELECT * FROM capstone.products")->result_array();
		}
	}
