<?php

class Order extends CI_Model
{
	public function get_orders()
	{
		return $this->db->query("SELECT * FROM orders")->result_array();
	}

	public function add_order($data)
	{
		$query = "INSERT INTO capstone.orders (user_id, order_items, shipping, billing, shipping_fee) VALUES (?,?,?,?,?)";
		$values = array('user_id' => $data['user_id'], 'order_items' => $data['order_items'], 'shipping' => $data['shipping'], 'billing' => $data['billing'], 'shipping_fee' => $data['shipping_fee']);
		$this->db->query($query, $values);
	}

	public function check_order_exist($post)
	{
		return $this->db->query("SELECT 1 FROM carts WHERE product_id = ?", $post)->row_array();
	}
}
