<?php
	class Shop extends CI_Model {
		public function get_product_by_category($id) {
			return $this->db->query("SELECT * FROM products WHERE category_id = ?", $id)->result_array();
		}
		public function get_category_count() {
			return $this->db->query("select count(products.id) as category_count, categories.name as category from products left join categories on products.category_id = categories.id group by categories.name")->result_array();
		}
	}
