<?php
	
	class Cart extends CI_Model
	{
		public function clean_cart() {
			$this->db->query("DELETE FROM carts");
		}
		public function get_cart_product_details()
		{
			return $this->db->query("SELECT product_id,products.name, img_url, price, description, carts.quantity FROM products right join carts on products.id = carts.product_id")->result_array();
		}
		
		
		public function get_cart_amount()
		{
			return $this->db->query("SELECT sum(price) as cart_price FROM carts left join products p on p.id = carts.product_id")->row_array();
		}
		
		public function get_cart_quantity()
		{
			return $this->db->query("SELECT sum(quantity) as carts_quantity FROM carts")->row_array();
		}
		
		public function updated_cart($post, $old_quantity)
		{
			$qty = $old_quantity['quantity'] + $post['quantity'];
			$query = "UPDATE carts SET quantity = ? where product_id = ?";
			$values = array($qty, $post['product_id']);
			return $this->db->query($query, $values);
		}
		
		public function delete_order($post)
		{
			$this->db->query("DELETE FROM capstone.carts WHERE id = ?", $post);
		}
		
		public function get_cart()
		{
			return $this->db->query("select carts.id as cart_id, product_id, products.name, products.price, quantity from carts left join products on carts.product_id = products.id")->result_array();
		}
		
		public function add_cart($data)
		{
			$query = ("INSERT INTO capstone.carts (user_id, product_id, quantity) VALUES (?,?,?)");
			$values = array($data['user_id'], $data['product_id'], $data['quantity']);
			$this->db->query($query, $values);
		}
	}
