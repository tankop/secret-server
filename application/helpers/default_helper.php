<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by Tankó Péter
 */

if (!function_exists('base64_url_encode')) {
	function base64_url_encode($input) {
		return rtrim(strtr(base64_encode($input), '+/', '-_'), '=');
	}
}

if (!function_exists('base64_url_decode')) {
	function base64_url_decode($input) {
		return base64_decode(str_pad(strtr($input, '-_', '+/'), strlen($input) % 4, '=', STR_PAD_RIGHT));
	}
}

if (!function_exists('unparse_filters')) {
	function unparse_filters($filters_encoded) {
		return json_decode(base64_url_decode($filters_encoded), TRUE);
	}
}

if (!function_exists('parse_filters')) {
	function parse_filters($filters_array) {
		return base64_url_encode(json_encode($filters_array));
	}
}

if (!function_exists('create_flash')) {
	function create_flash(&$instance, $type, $title, $text) {
		if (is_object($instance)) {
			$instance->session->set_flashdata('type', $type);
			$instance->session->set_flashdata('title', $title);
			$instance->session->set_flashdata('text', $text);
		}
	}
}

if (!function_exists('hashGenerator')) {
	function hashGenerator() {
		return md5(uniqid(rand(), true));
	}
}

