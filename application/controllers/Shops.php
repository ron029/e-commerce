<?php

/** @property Product Product
 * @property Shop Shop
 * @property Cart Cart
 */
class Shops extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$user_id = $this->session->userdata('user');
		if (!isset($user_id)) redirect('/');
		$this->load->model('Product');
		$this->load->model('Shop');
		$this->load->model('Cart');
	}

	public function index()
	{
		$user_id = $this->session->userdata('user');
		$data['carts_quantity'] = $this->Cart->get_cart_quantity($user_id);
		$this->load->view('product/products_page', $data);
	}

	public function index_html()
	{
		$categories = $this->Shop->get_category_count();
		$products = $this->Product->get_product();
		$data = array('categories' => $categories, 'products' => $products, 'category_name' => 'All Products');
		$this->load->view('product/ajax/products_page_ajax', $data);
	}

	public function carts_quantity()
	{
		$user_id = $this->session->userdata('user');
		$carts_quantity = $this->Cart->get_cart_quantity($user_id);
		echo $carts_quantity['carts_quantity'];
	}

	public function category($category_id = null)
	{
		// When the user change the sort state [0,1] the category id auto set to null so we need to store it to session.
		if ($category_id !== null) {
			$this->session->set_userdata('category_id', $category_id);
		} else {
			$category_id = $this->session->userdata('category_id');
		}

		// When the user select a category, the form send the category id here and category id of 0 when user select all products.
		if ($this->input->post('sort_by') !== null) {
			// Get all the products when the user change the sort but not yet select a category.
			if ($category_id == 0) {
				$products = $this->Shop->get_products_filter_sort($this->input->post('sort_by', TRUE));
			} else {
				$products = $this->Shop->get_products_filter($category_id, $this->input->post('sort_by', TRUE));
			}
		} else if ($category_id == 0) {
			$products = $this->Product->get_product();
		} else {
			$products = $this->Shop->get_product_by_category($category_id);
		}
		// Change the value of select tag "<select><option value='[0,1]'></option></select>" in front end.
		$this->session->set_flashdata('sort', $this->input->post('sort_by', TRUE));

		$category_name = $this->Product->get_category_name($category_id);

		$categories = $this->Shop->get_category_count();

		$data = array('categories' => $categories, 'products' => $products, 'category_name' => $category_name);

		$this->load->view('product/ajax/products_page_ajax', $data);
	}

	public function show($id)
	{

		$similar_products = $this->Product->get_category_product_id($id);
		$product = $this->Product->get_product_by_id($id);
		$title = ucwords($product['name'] . ' | Lashopda');
		$data = array('product' => $product, 'similar_products' => $similar_products, 'title' => $title);
		$this->load->view('product/item_page', $data);
	}
}
