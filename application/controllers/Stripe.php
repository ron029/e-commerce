<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stripe extends CI_Controller
{

	/**
	 * Get All Data from this method.
	 *
	 * @return Response
	 */
	public function __construct()
	{
		parent::__construct();
		$user_id = $this->session->userdata('user');
		if (!isset($user_id)) redirect('/');
		$this->load->library("session");
		$this->load->helper('url');
		$this->load->helper('exchange_rate');
	}

	/**
	 * Get All Data from this method.
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->load->view('stripe/index');
	}

	/**
	 * Get All Data from this method.
	 *
	 * @return Response
	 * @throws \Stripe\Exception\ApiErrorException
	 */
	public function payment()
	{
		require_once('application/libraries/stripe-php/init.php');

		$stripeSecret = 'sk_test_51MekQ5Akz0y3CGDBPzlSZNMjdqgzpYWpStvJoe5aUUxV1M041RutPYRiT4ifkTcofPCJQNcXagSuhbtaKFZi7FUJ00L2yWTfGT';

		\Stripe\Stripe::setApiKey($stripeSecret);

		$stripe = \Stripe\Charge::create([
			"amount" => $this->input->post('amount'),
			"currency" => "USD",
			"source" => $this->input->post('tokenId'),
			"description" => "Test payment from tutsmake.com."
		]);

		// after successful payment, you can store payment related information into your database

		$data = array('success' => true, 'data' => $stripe);

		echo json_encode($data);
	}

	public function show_error_403()
	{
		$message_403 = "You don't have access to the url you where trying to reach.";
		show_error($message_403, 403);
	}
}
