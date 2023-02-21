<?php
	
	class Carts extends CI_Controller
	{
		public function index() {
			$this->load->view('product/cart_page');
		}
	}
