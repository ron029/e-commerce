<?php
	
	class Orders extends CI_Controller
	{
		public function admin_orders() {
			$this->load->view('admin/admin_orders_dashboard_page');
		}
	}
