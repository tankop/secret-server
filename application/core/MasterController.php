<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';

class MasterController extends CI_Controller {

    protected $data;
    protected $load_models = [];
    protected $controller;
    protected $js_custom_files = false;
    protected $css_custom_files = false;

    public function __construct() {
		parent::__construct();
		date_default_timezone_set('UTC');
		$this->load_models = array_merge(
			$this->load_models, [
				'Secret'
			]
		);
		$this->loadModels();
		$this->controller = mb_strtolower(get_class($this));
    }

    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST' ? true : false;
    }

    protected function build($view) {
        if ($view) {
            $this->data['view'] = $view;
            $this->data['controller'] = $this->controller;
            $this->data['flash'] = $this->getFlashMessages();
            $this->data['js_custom_files'] = $this->js_custom_files;
            $this->data['css_custom_files'] = $this->css_custom_files;
            $this->load->view('layouts/Default', $this->data);
        }
        return false;
    }


    public function _remap($method, $params = array()) {
		if (method_exists($this, $method)) {
			return call_user_func_array(array($this, $method), $params);
		} else {
			return call_user_func_array(array($this, 'index'), array_merge((array)$method, $params));
		}
    }

    protected function loadModels() {
        foreach ($this->load_models as $model) {
            $this->load->model($model . "ModelMap");
            $this->load->model($model . "Model");
        }
    }

    protected function getFlashMessages() {
        $flashArray = $this->session->flashdata();
        $return = array(
            'type' => isset($flashArray['type']) ? $flashArray['type'] : false,
            'title' => isset($flashArray['title']) ? $flashArray['title'] : false,
            'text' => isset($flashArray['text']) ? $flashArray['text'] : false,
        );
        if ($return['type'] != false) {
            unset($_SESSION['text'], $_SESSION['__ci_vars']['text']);
        }
        return $return;
    }
}
