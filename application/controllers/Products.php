<?php
	
	/** @property Product Product */
	class Products extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('Product');
		}
		
		public function index()
		{
			$this->load->view('product/products_page');
		}
		
		public function get_new_product()
		{
			$data['data'] = $this->Product->newly_created_product();
			$data_json['data'] = json_encode($data);
			$this->load->view('admin/ajax/json', $data_json);
		}
		
		public function get_template_delete_category($id)
		{
			$category_name = $this->Product->get_category_name($id);
			$category_id = $id;
			$data = array('name' => $category_name, 'id' => $category_id);
			$this->load->view('admin/delete_category', $data);
		}
		
		public function edit_category($id)
		{
			if ($this->input->post(NULL, TRUE)) {
				$this->Product->edit_category($this->input->post(NULL, TRUE), $id);
			} else {
				$message_403 = "You don't have access to the url you where trying to reach.";
				show_error($message_403, 403);
			}
		}
		
		public function show()
		{
			$this->load->view('product/item_page');
		}
		
		public function delete_category()
		{
			print_r($this->input->post());
			if ($this->input->post('category_id', TRUE)) {
				$this->Product->delete_category($this->input->post('category_id', TRUE));
			} else {
				$message_403 = "You don't have access to the url you where trying to reach.";
				show_error($message_403, 403);
			}
		}
		
		public function admin_products()
		{
			$this->load->view('admin/admin_products_dashboard_page');
		}
		
		public function get_category_for_new_product()
		{
			$data['categories'] = $this->Product->get_category();
			$data_json['data'] = json_encode($data);
			$this->load->view('admin/ajax/json', $data_json);
		}
		
		public function get_products()
		{
			$data['products'] = $this->Product->get_product();
			$this->load->view('admin/ajax/products', $data);
		}
		
		public function get_product_by_id($id)
		{
			$data['categories'] = $this->Product->get_category();
			$data['product'] = $this->Product->get_product_by_id($id);
			$data_json['data'] = json_encode($data);
			$this->load->view('admin/ajax/json', $data_json);
		}
		
		public function new_product()
		{
			if ($this->input->post()) {
				echo '<pre>';
				print_r($this->input->post());
				echo '<pre>';
				if ($this->input->post('product_add_category', TRUE)) {
//					$this->Product->add_category($this->input->post('product_add_category', TRUE));
//					$category_id = $this->Product->get_id_new_category();
//				    $this->Product->add_product($this->input->post(NULL, TRUE), $category_id);
				} else {
					if ($this->input->post('product_category')) {
					
					}
				}
				$new_product = $this->Product->newly_created_product();
				$currentDirectory = getcwd();
				$uploadDirectory = '\\assets\\img\\products\\';
				$errors = array(); // Store errors here
				
				$fileExtensionsAllowed = array('jpg', 'jpeg', 'png'); // These will be the only file extensions allowed
				
				$fileName = $_FILES['img_upload']['name'];
				$fileSize = $_FILES['img_upload']['size'];
				$fileTmpName = $_FILES['img_upload']['tmp_name'];
				$fileType = $_FILES['img_upload']['type'];
				$json = '{ "imgid_no": [ ';
				for ($counter = 1; $counter <= sizeof($_FILES['img_upload']['name']); $counter++) {
					$json .= '"' . $new_product['id'] . '_' . $counter . '"';
					if ($counter !== sizeof($_FILES['img_upload']['name'])) {
						$json .= ',';
					}
				}
				$json .= '] }';
				print_r($json);
				print_r($_FILES);
				foreach ($fileName as $key => $file) {
					$array[$key] = explode('.', $file);
					$fileExtension[$key] = strtolower(end($array[$key]));
					$uploadPath[$key] = $currentDirectory . $uploadDirectory . basename($file);
				}
				
				foreach ($fileExtension as $key => $file_ext) {
					if (!in_array($file_ext, $fileExtensionsAllowed)) {
						$errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
					}
					if ($fileSize[$key] > 4000000) {
						$errors[] = "File exceeds maximum size (4MB)";
					}
				}
				if (count($errors) < 1) {
					$imgs = array();
					foreach ($uploadPath as $key => $upload) {
//						$didUpload = move_uploaded_file($fileTmpName[$key], $upload);
						$imgs[$key] = base_url('assets/img/products/') . $fileName[$key];
						$array[$key] = explode('/', $imgs[$key]);
						$fileExtension[$key] = end($array[$key]);
//						rename($currentDirectory . '\\assets\\img\\products\\' . $fileExtension[$key], $currentDirectory . '\\assets\\img\\products\\' . $new_product['id'] . '_' . ($key + 1) . '.jpg');
					}
					print_r($currentDirectory . '\\assets\\img\\products\\' . $new_product['id'] . '_' . 1 . '.jpg');
					$didUpload = 1;
					if ($didUpload) {
						echo "The file " . basename($fileName[0]) . " has been uploaded";
//						$this->Product->add_img_url_new_product($json, $new_product['id']);
					} else {
						echo "An error occurred. Please contact the administrator.";
					}
				}
			} else {
				$message_403 = "You don't have access to the url you where trying to reach.";
				show_error($message_403, 403);
			}
		}
		
		public function updated_product()
		{
			print_r($this->input->post());
			if ($this->input->post()) {
			
			} else {
				$message_403 = "You don't have access to the url you where trying to reach.";
				show_error($message_403, 403);
			}
		}
	}
