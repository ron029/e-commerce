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
		
		}
		
		public function delete_product() {
			if ($this->input->post()) {
				$this->Product->delete_product($this->input->post('product_id', TRUE));
			} else {
				$message_403 = "You don't have access to the url you where trying to reach.";
				show_error($message_403, 403);
			}
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
		public function check_category($category1, $category2) {
			// $category1 - $this->input->post('product_add_category', TRUE);
			// $category2 - $this->input->post('product_category', TRUE);
			
			$category_id = 0;
			$check_category_if_exist = $this->Product->get_category_id_by_name($category1);
			
			if ($category1 && !($check_category_if_exist)) {
				// Create a new category for no existing category name.
				$this->Product->add_category($category1);
				$category_id = $this->Product->get_id_new_category();
				
			} else {
				// Use the current category_id if the category name exists.
				if ($category1) {
					$category_id = $this->Product->get_category_id_by_name($category1);
				} else if ($category2) {
					$category_id = $this->Product->get_category_id_by_name($category2);
				}
				print_r($category_id);
			}
			return $category_id;
		}
		
		public function new_product($img = null)
		{
			if (isset($img)) {
				$product = $this->Product->get_product_by_id($img);
				$img_url = json_decode($product['img_url'], TRUE);
				echo 'image to be delete is: ';
				print_r($img);
				echo 'images for id: ';
				print_r($img_url['imgid_no']);
				// Check if the form is for product update purposes.
			} else if ($this->input->post('product_id')) {
				echo '<pre>';
				print_r($this->input->post());
				echo '<pre>';
				
				echo '<pre>';
				print_r($_FILES);
				echo '<pre>';
				
				$product_id = $this->input->post('product_id', TRUE);
				$product = $this->Product->get_product_by_id($product_id);
				
				$image_names = $product['img_url'];
				if ($main = $this->input->post('img_upload_main_id')) { //
					$img_url = json_decode($product['img_url'], TRUE);
					
					foreach ($img_url['imgid_no'] as $key => $image) {
						if ($image == $main[0]) {
							$tmp = $img_url['imgid_no'][0];
							$img_url['imgid_no'][0] = $main[0];
							$img_url['imgid_no'][$key] = $tmp;
							break;
						}
					}
					
					$new_img_name = json_encode($img_url['imgid_no']);
					$new_img_name = '{ "imgid_no" : ' . $new_img_name . '}';
					
					// Overwrite $image_names from old image_url to new image_url.
					$image_names = $new_img_name;
				}
				$old_images = explode(',',  $this->input->post('set_images'));
				
				$img_names = array();
				for ($counter = 1; $counter < 5; $counter++) {
					$img_names[] = $product_id . '_' . $counter;
				}
				$available_name = array_diff($img_names, $old_images);
				
				// Verify category if exist then get the category id. If not, create a new category for no existing category then get the id.
				$category_id = $this->check_category($this->input->post('product_add_category', TRUE), $this->input->post('product_category', TRUE));
				
				$update_details = array('category_id' => $category_id, 'product_name' => $this->input->post('product_name', TRUE), 'product_desc' => $this->input->post('product_desc', TRUE), 'product_price' => $this->input->post('product_price', TRUE), 'product_qty' => $this->input->post('product_qty', TRUE), 'img_url' => $image_names, 'product_id' => $this->input->post('product_id', TRUE));
				$this->Product->update_product($update_details);
				
				// Check if there is a form submitted otherwise 403 status is thrown.
			} else if ($this->input->post()) {
				// Verify category if exist.
				$category_id = $this->check_category($this->input->post('product_add_category', TRUE), $this->input->post('product_category', TRUE));
				
				$this->Product->add_product($this->input->post(NULL, TRUE), $category_id); // Add new product
				
				$new_product = $this->Product->newly_created_product();
				
				$currentDirectory = getcwd();
				$uploadDirectory = '\\assets\\img\\products\\';
				$errors = array(); // Store errors here
				
				$fileExtensionsAllowed = array('jpg', 'jpeg', 'png'); // These will be the only file extensions allowed
				
				$fileName = $_FILES['img_upload']['name'];
				$fileSize = $_FILES['img_upload']['size'];
				$fileTmpName = $_FILES['img_upload']['tmp_name'];
				$fileType = $_FILES['img_upload']['type'];
				
				$main = $this->input->post('img_upload_main_id', TRUE); // Get the file name of the main image.
				
				$json = '{ "imgid_no": [ '; // Create one JSON format image name for the multiple image.
				foreach ($_FILES['img_upload']['name'] as $key => $file) {
					if (isset($main) && $main !== $_FILES['img_upload']['name'][$key]) continue;
					$json .= '"' . $new_product['id'] . '_' . ($key + 1) . '"';
					if (isset($_FILES['img_upload']['name'][$key + 1]) || count($_FILES['img_upload']['name']) == 2) $json .= ',';
				}
				if ($main) {
					foreach ($_FILES['img_upload']['name'] as $key => $file) {
						if (isset($main) && $main === $_FILES['img_upload']['name'][$key]) continue;
						$json .= '"' . $new_product['id'] . '_' . ($key + 1) . '"';
						if (isset($_FILES['img_upload']['name'][$key + 1]) && count($_FILES['img_upload']['name']) < 2) $json .= ',';
					}
				}
				$json .= '] }';
				
				print_r(json_decode($json));
				
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
					
					// Rename image/s.
					foreach ($uploadPath as $key => $upload) {
						$didUpload = move_uploaded_file($fileTmpName[$key], $upload);
						$imgs[$key] = base_url('assets/img/products/') . $fileName[$key];
						$array[$key] = explode('/', $imgs[$key]);
						$fileExtension[$key] = end($array[$key]);
						rename($currentDirectory . '\\assets\\img\\products\\' . $fileExtension[$key], $currentDirectory . '\\assets\\img\\products\\' . $new_product['id'] . '_' . ($key + 1) . '.jpg');
					}
					
					if ($didUpload) {
//						echo "The file " . basename($fileName[0]) . " has been uploaded";
						$this->Product->add_img_url_new_product($json, $new_product['id']);
					} else {
//						echo "An error occurred. Please contact the administrator.";
					}
				}
			} else {
				$message_403 = "You don't have access to the url you where trying to reach.";
				show_error($message_403, 403);
				die();
			}
		}
		
		public function get_product_by_id($id)
		{
			$data['categories'] = $this->Product->get_category();
			$data['product'] = $this->Product->get_product_by_id($id);
			$data_json['data'] = json_encode($data);
			$this->load->view('admin/ajax/json', $data_json);
		}
	}
