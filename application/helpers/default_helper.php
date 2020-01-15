<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by Tankó Péter
 */

if (!function_exists('hashGenerator')) {
	function hashGenerator() {
		return md5(uniqid(rand(), true));
	}
}

