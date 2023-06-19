<?php

/**
 * @property Cart Cart
 * @property Order Order
 * @property $input
 * @property $session
 */
class Carts extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$user_id = $this->session->userdata('user');
		if (!isset($user_id)) redirect('/');
		$this->load->model('Cart');
		$this->load->model('Order');
		$this->load->helper('exchange_rate');
	}

	public function index()
	{
		$user_id = $this->session->userdata('user');
		$carts = $this->Cart->get_cart($user_id['id']);

		$carts_quantity = $this->Cart->get_cart_quantity($user_id);
		$data = array('carts' => $carts, 'carts_quantity' => $carts_quantity);

		$this->load->view('product/cart_page', $data);
	}

	public function modify_item_quantity()
	{
		$user_id = $this->session->userdata('user')['id'];
		$product_id = $this->input->post('product_id', TRUE);
		$data = array('user_id' => $user_id, 'quantity' => $this->input->post('new_quantity', TRUE), 'product_id' => $product_id, 'cart_id' => $this->input->post('cart_id', TRUE));

		$this->Cart->updated_cart($data);
		$price = $this->Cart->get_cart_item_price($product_id, $user_id);
		$data = array('new_quantity' => $data['quantity'], 'price' => $price['price']);
		echo json_encode($data);
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
			$this->Cart->clean_cart($user_id['id']);

			redirect('carts/success_order');
		} else {
			$this->show_error_403();
		}
	}

	public function generate_userinfo_json($data, $search): array
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
//			if (!$_POST) $this->show_error_403();
//			'access_key' => 'c1a4746ac6dc6bab993ad27d8edc0adb',

		// shipping fee
		$shipping_fee = 50;

		$id = $this->session->userdata('user');

		// amount fetch in db
		$amount = $this->Cart->get_cart_amount($id['id'])['cart_price'];

		// Return default base EURO in basic subscription plan.
		$response = get_api_response('http://api.exchangeratesapi.io/v1/latest?access_key=c1a4746ac6dc6bab993ad27d8edc0adb', []);

		// Euro to usd and Euro to php, divide php to usd to get the 'php to usd conversion'
		$usd = $response['rates']['USD'];
		$php = $response['rates']['PHP'];
		$php_rate = $php / $usd;

		// usd amount cents
		$usd_amount = ($amount + $shipping_fee) / $php_rate * 100;

		$data = array('current_php_currency' => $php_rate, 'usd_amount' => $usd_amount, 'php_amount' => ($amount + $shipping_fee));
		echo json_encode($data);
	}

	public function delete_order()
	{
		if ($this->input->post()) {
			$user_id = $this->session->userdata('user');
			$this->Cart->delete_order($this->input->post('cart_id', TRUE), $user_id['id']);
		} else {
			$this->show_error_403();
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
				$current_quantity = $this->Cart->get_order_quantity($data);
				$this->Cart->updated_cart($data, $current_quantity);
			} else {
				$this->Cart->add_cart($data);
			}
		} else {
			$this->show_error_403();
		}
	}

	public function show_error_403()
	{
		$message_403 = "You don't have access to the url you where trying to reach.";
		show_error($message_403, 403);
	}
}
