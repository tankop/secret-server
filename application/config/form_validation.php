<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by Tankó Péter
 */

$config['add_secret'] = [
	[
		'field' => 'secret',
		'label' => 'secret',
		'rules' => 'trim|required'
	],
	[
		'field' => 'expireAfterViews',
		'label' => 'expireAfterViews',
		'rules' => 'trim|required|is_natural_no_zero'
	],
	[
		'field' => 'expireAfter',
		'label' => 'expireAfter',
		'rules' => 'trim|required|is_natural'
	],
];
