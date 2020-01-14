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
		'rules' => 'trim|required|is_natural'
	],
	[
		'field' => 'expireAfter',
		'label' => 'expireAfter',
		'rules' => 'trim|required|is_natural'
	],
];
