<?php
	
	class Shop extends CI_Model
	{
		public function get_products_filter_sort($sort)
		{
			if ($sort == 0) {
				$query = "SELECT * FROM products ORDER BY price";
			} else if ($sort == 1) {
				$query = "SELECT * FROM products ORDER BY price DESC";
			}
			return $this->db->query($query)->result_array();
		}
		
		public function get_products_filter($category_id, $order)
		{
			if ($order == 0) {
				$query = "SELECT * FROM products WHERE category_id = ? ORDER BY price";
			} else if ($order == 1) {
				$query = "SELECT * FROM products WHERE category_id = ? ORDER BY price DESC";
			}
			$values = array($category_id);
			return $this->db->query($query, $values)->result_array();
		}
		
		public function get_product_by_category($id)
		{
			return $this->db->query("SELECT * FROM products WHERE category_id = ? ORDER BY price", $id)->result_array();
		}
		
		public function get_category_count()
		{
			return $this->db->query("select count(products.id) as category_count,categories.id as id, categories.name as category from products left join categories on products.category_id = categories.id group by categories.name")->result_array();
		}
	}
