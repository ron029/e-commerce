<?php

/**
 * @property $db;
 */
class Cart extends CI_Model
{
	public function clean_cart($id)
	{
		$this->db->query("DELETE FROM carts WHERE user_id = ?", $id);
	}

	public function get_cart_product_details()
	{
		return $this->db->query("SELECT product_id,products.name, img_url, price, description, carts.quantity FROM products right join carts on products.id = carts.product_id")->result_array();
	}

	public function get_cart_amount($id)
	{
		return $this->db->query("SELECT sum(price * quantity) as cart_price FROM carts left join products p on p.id = carts.product_id WHERE user_id = ?", $id)->row_array();
	}

	public function get_cart_quantity($id)
	{
		return $this->db->query("SELECT sum(quantity) as carts_quantity FROM carts WHERE user_id = ?", $id['id'])->row_array();
	}

	public function get_order_quantity($post)
	{
		return $this->db->query("SELECT quantity FROM carts where product_id = ?", $post['product_id'])->row_array();
	}

	public function get_cart_item_price($product_id, $user_id)
	{
		$query = "select products.price, quantity from carts left join products on carts.product_id = products.id WHERE user_id = ? AND product_id = ?";
		$values = array($user_id, $product_id);
		return $this->db->query($query, $values)->row_array();
	}

	public function updated_cart($post, $old_quantity = 0)
	{
		$qty = ($old_quantity) ? $old_quantity['quantity'] + $post['quantity'] : $post['quantity'];
		$query = "UPDATE carts SET quantity = ? where product_id = ? AND user_id = ?";
		$values = array($qty, $post['product_id'], $post['user_id']);
		return $this->db->query($query, $values);
	}

	public function delete_order($post, $user_id)
	{
		$query = "DELETE FROM capstone.carts WHERE id = ? AND user_id = ?";
		$values = array($post, $user_id);
		$this->db->query($query, $values);
	}

	public function get_cart($user_id)
	{
		return $this->db->query("select carts.id as cart_id, product_id, products.name, products.price, quantity from carts left join products on carts.product_id = products.id WHERE user_id = ?", $user_id)->result_array();
	}

	public function add_cart($data)
	{
		$query = ("INSERT INTO capstone.carts (user_id, product_id, quantity) VALUES (?,?,?)");
		$values = array($data['user_id'], $data['product_id'], $data['quantity']);
		$this->db->query($query, $values);
	}
}
