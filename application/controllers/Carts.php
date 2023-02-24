<?php
	
	/**
	 * @property Cart Cart
	 * @property Order Order
	 */
	class Carts extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('Cart');
			$this->load->model('Order');
		}
		
		public function index()
		{
			$carts = $this->Cart->get_cart();
			$carts_quantity = $this->Cart->get_cart_quantity();
			$data = array('carts' => $carts, 'carts_quantity' => $carts_quantity);
			$this->load->view('product/cart_page', $data);
		}
		
		public function process_checkout()
		{
			if ($this->input->post()) {
				$data = $this->input->post(NULL, TRUE);
				
				$user_id = $this->session->userdata('user');
				
				$order_items = json_encode($this->Cart->get_cart_product_details());
				
				$ships_json = json_encode($this->generate_userinfo_json($data, 'ship'));
				$bills_json = json_encode($this->generate_userinfo_json($data, 'bill'));
				
				$shipping_fee = 3;
				
				$orders = array('user_id' => $user_id['id'], 'order_items' => $order_items, 'shipping' => $ships_json, 'billing' => $bills_json, 'shipping_fee' => $shipping_fee);
				$this->Order->add_order($orders);
				$this->Cart->clean_cart();
				redirect('carts/success_order');
			} else {
				$message_403 = "You don't have access to the url you where trying to reach.";
				show_error($message_403, 403);
			}
		}
		
		public function generate_userinfo_json($data, $search)
		{
			$keys = array_keys($data);
			$item_temp = array();
			$items = array();
			foreach ($keys as $key) {
				$item_temp[] = (strstr($key, $search)) ? $key : 0;
				foreach ($item_temp as $item) {
					if ($item == $key && $item !== 0) {
						$items[$item] = $data[$item];
						break;
					}
				}
			}
			return $items;
		}
		
		public function success_order()
		{
			$this->load->view('product/order_success');
		}
		
		public function get_cart_amount()
		{
			$amount = $this->Cart->get_cart_amount();
			print_r($amount['cart_price']);
		}
		
		public function delete_order()
		{
			if ($this->input->post()) {
				$this->Cart->delete_order($this->input->post('product_id', TRUE));
			} else {
				$message_403 = "You don't have access to the url you where trying to reach.";
				show_error($message_403, 403);
			}
		}
		
		public function process_order()
		{
			$user_id = $this->session->userdata('user');
			if ($this->input->post(NULL, TRUE) !== null) {
				print_r($_POST);
				$data = array('user_id' => $user_id['id'], 'quantity' => $this->input->post('quantity', TRUE), 'product_id' => $this->input->post('product_id', TRUE));
				$status = $this->Order->check_order_exist($this->input->post('product_id', TRUE));
				print_r($status);
				if ($status !== null) {
					$current_quantity = $this->Order->get_order_quantity($data);
					$this->Cart->updated_cart($data, $current_quantity);
				} else {
					$this->Cart->add_cart($data);
				}
			} else {
				$message_403 = "You don't have access to the url you where trying to reach.";
				show_error($message_403, 403);
			}
		}
	}
