<?php
	
	/** @property Order Order
	 * @property User User
	 */
	class Orders extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('Order');
			$this->load->model('User');
		}
		
		public function index()
		{
			$data['orders'] = $this->order_details();
			$this->load->view('admin/admin_orders_dashboard_page', $data);
		}
		public function show($id) {
			if ($id !== null) {
				$data = array();
				$orders = $this->order_details();
				foreach ($orders as $order) {
					if ($order['id'] == $id) {
						$data['order'] = $order;
						break;
					}
				}
				$this->load->view('admin/admin_order_detail_page', $data);
			} else {
				$message_403 = "You don't have access to the url you where trying to reach.";
				show_error($message_403, 403);
			}
		}
		
		public function order_details()
		{
			$orders = $this->Order->get_orders();

			$carts = array();
			$bills = array();
			$ships = array();
			$carts_total_price = array();
			
			foreach ($orders as $order_key => $order) {
				$carts_total_price[$order_key] = 0;
				$cart_item = array();
				$order_items = json_decode($order['order_items'], TRUE);
				
				foreach ($order_items as $key => $order_item) {
					$cart_item[$key]['name'] = $order_item['name'];
					$cart_item[$key]['price'] = $order_item['price'];
					$cart_item[$key]['description'] = $order_item['description'];
					$cart_item[$key]['quantity'] = $order_item['quantity'];
					$cart_item[$key]['images'] = json_decode($order_item['img_url'], TRUE)['imgid_no'];
					$cart_item[$key]['product_id'] = $order_item['product_id'];
					$carts_total_price[$order_key] += $order_item['price'];
				}
				$carts[$order_key] = $cart_item;
				
				$bills[$order_key] = json_decode($order['billing'], TRUE);
				$ships[$order_key] = json_decode($order['shipping'], TRUE);
			}
			foreach ($orders as $key => $order) {
				$orders[$key]['full_name'] = $this->User->get_user_full_name($order['user_id'])['full_name'];
				$orders[$key]['shipping'] = $ships[$key];
				$orders[$key]['billing'] = $bills[$key];
				$orders[$key]['order_items'] = $carts[$key];
				$orders[$key]['carts_total_price'] = $carts_total_price[$key];
			}
			
			return $orders;
		}
	}
