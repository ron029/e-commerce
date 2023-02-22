<?php
	/** @property Product Product
	 * @property Shop Shop
	 */
	class Shops extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('Product');
			$this->load->model('Shop');
		}
		
		public function index() {
			$this->load->view('product/products_page');
		}
		public function index_html() {
			$categories = $this->Shop->get_category_count();
			$products = $this->Product->get_product();
			$data = array('categories' => $categories, 'products' => $products);
			$this->load->view('product/ajax/products_page_ajax', $data);
		}
	}
