<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by Tankó Péter
 */
require APPPATH . "core/MasterRestController.php";
class Secret extends MasterRestController {
	function __construct() {
		parent::__construct();
		$this->load->model('SecretModelMap');
		$this->load->model('SecretModel');
	}

	public function index_get($hash) {
		if (!empty($hash)){
			$secret = SecretModel::get()->getByHash($hash);
			if ($secret instanceof SecretModel){
				$this->response($secret->toApi(), 200);
			}
		}
		$this->response(['error' => 'Secret not found'], 404);
	}

	public function index_post() {
		$this->config->set_item('rest_default_format', $this->response->format);
		$post = $this->input->post();
		$this->form_validation->set_data($post);
		if ($this->form_validation->run('add_secret') === TRUE){
			$secret = SecretModel::get();
			$secret->createSecret($post['secret'], $post['expireAfterViews'], $post['expireAfter']);
			$this->response($secret->toApi(), 200);
		}else{
			$this->response(['error' => 'Invalid input'], 405);
		}
	}

	public function index_put() {
		$error = ['status' => false, 'error' => 'Method Not Allowed'];
		$this->response($error, 500);
	}

}
