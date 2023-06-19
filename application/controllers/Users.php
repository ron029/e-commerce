<?php
defined('BASEPATH') or exit('No direct script access allowed');

/** @property User User
 * @property $session
 * @property $input
 */
class Users extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User');
	}

	public function register()
	{
		$this->load->view('login_register/registration_page');
	}

	public function login()
	{
		$data = $this->session->userdata('user');
		$this->user_role($data);
	}

	public function process_login()
	{
		$data = $this->User->check_user($this->input->post(NULL, TRUE));
		$this->session->set_userdata('user', $data);
		print_r($data);
		if (!$data) {
			$this->session->set_flashdata('login_error', 1);
			redirect(base_url('users/login'));
		} else {
			$this->user_role($data);
		}
	}

	public function logout()
	{
		session_destroy();
		redirect('/');
	}

	public function user_role($data)
	{
		if (!isset($data)) {
			$this->load->view('login_register/login_page');
		} else if ($data['role'] == 9) {
			redirect(base_url('dashboard/orders'));
		} else if ($data['role'] == 1) {
			redirect(base_url('products'));
		}
	}
}
