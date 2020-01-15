<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by Tankó Péter
 */
class Index extends MasterController {

	public function __construct() {
		$this->load_models[] = 'Secret';
		parent::__construct();
	}

	public function index() {
		$this->build('Index');
	}
}
