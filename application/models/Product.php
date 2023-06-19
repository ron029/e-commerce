<?php

class Product extends CI_Model
{
	public function get_category_product_id($id)
	{
		$category_id = $this->db->query("SELECT category_id FROM products WHERE products.id = ?", $id)->row_array();
		return $this->db->query("SELECT * FROM products WHERE category_id = ?", $category_id)->result_array();
	}

	public function delete_product($id)
	{
		$this->db->query("DELETE FROM products WHERE id = ?", $id);
	}

	public function update_product($post)
	{
		$query = ("UPDATE products SET category_id = ?, name = ?, description = ?, price = ?, stock = ?, img_url = ? WHERE id = ?");
		$values = array($post['category_id'], $post['product_name'], $post['product_desc'], $post['product_price'], $post['product_qty'], $post['img_url'], $post['product_id']);
		return $this->db->query($query, $values);
	}

	public function get_category_id_by_name($name)
	{
		return $this->db->query("SELECT id FROM categories WHERE name = ?", $name)->row_array();
	}

	public function add_img_url_new_product($json, $id)
	{
		$query = ("UPDATE products SET img_url = ? WHERE id = ?");
		$values = array($json, $id);
		return $this->db->query($query, $values);
	}

	public function newly_created_product()
	{
		return $this->db->query("select * from products order by id desc limit 1")->row_array();
	}

	public function get_category_name($id)
	{
		return $this->db->query("SELECT name FROM categories WHERE id = ?", $id)->row_array();
	}

	public function delete_category($post)
	{
		$this->db->query("DELETE FROM capstone.categories WHERE id = ?", $post);
	}

	public function get_id_new_category()
	{
		return $this->db->query("SELECT id FROM capstone.categories ORDER BY id DESC LIMIT 1")->row_array();
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
		return $this->db->query("SELECT products.*, categories.name as category_name, category_id FROM capstone.products left join categories on categories.id = products.category_id where products.id = ?", $id)->row_array();
	}

	public function get_category()
	{
		return $this->db->query("SELECT * FROM capstone.categories ORDER BY categories.name ASC")->result_array();
	}

	public function get_product()
	{
		return $this->db->query("SELECT * FROM capstone.products ORDER BY products.id DESC")->result_array();
	}
}
