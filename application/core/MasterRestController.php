<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by Tankó Péter
 */

use chriskacerguis\RestServer\Format;
use chriskacerguis\RestServer\RestController;
class MasterRestController extends RestController {

	function __construct() {
		parent::__construct();
	}

	public function response($data = null, $http_code = null, $continue = false)
	{
		//if profiling enabled then print profiling data
		$isProfilingEnabled = $this->config->item('enable_profiling');
		if (!$isProfilingEnabled) {
			ob_start();
			// If the HTTP status is not NULL, then cast as an integer
			if ($http_code !== null) {
				// So as to be safe later on in the process
				$http_code = (int) $http_code;
			}

			// Set the output as NULL by default
			$output = null;

			// If data is NULL and no HTTP status code provided, then display, error and exit
			if ($data === null && $http_code === null) {
				$http_code = HTTP_NOT_FOUND;
			}

			// If data is not NULL and a HTTP status code provided, then continue
			elseif ($data !== null) {
				// If the format method exists, call and return the output in that format
				if (method_exists(Format::class, 'to_'.$this->response->format)) {
					// CORB protection
					// First, get the output content.
					if ($this->response->format == 'xml') {
						$output = Format::factory($data)->{'to_'.$this->response->format}($data, null, 'Secret');
					}
					else {
						$output = Format::factory($data)->{'to_'.$this->response->format}();
					}

					// Set the format header
					// Then, check if the client asked for a callback, and if the output contains this callback :
					if (isset($this->_get_args['callback']) && $this->response->format == 'json' && preg_match('/^'.$this->_get_args['callback'].'/', $output)) {
						$this->output->set_content_type($this->_supported_formats['jsonp'], strtolower($this->config->item('charset')));
					} else {
						$this->output->set_content_type($this->_supported_formats[$this->response->format], strtolower($this->config->item('charset')));
					}

					// An array must be parsed as a string, so as not to cause an array to string error
					// Json is the most appropriate form for such a data type
					if ($this->response->format === 'array') {
						$output = Format::factory($output)->{'to_json'}();
					}
				} else {
					// If an array or object, then parse as a json, so as to be a 'string'
					if (is_array($data) || is_object($data)) {
						$data = Format::factory($data)->{'to_json'}();
					}

					// Format is not supported, so output the raw data as a string
					$output = $data;
				}
			}

			// If not greater than zero, then set the HTTP status code as 200 by default
			// Though perhaps 500 should be set instead, for the developer not passing a
			// correct HTTP status code
			$http_code > 0 || $http_code = HTTP_OK;

			$this->output->set_status_header($http_code);

			// JC: Log response code only if rest logging enabled
			if ($this->config->item('rest_enable_logging') === true) {
				$this->_log_response_code($http_code);
			}

			// Output the data
			$this->output->set_output($output);

			if ($continue === false) {
				// Display the data and exit execution
				$this->output->_display();
				exit;
			} else {
				if (is_callable('fastcgi_finish_request')) {
					// Terminates connection and returns response to client on PHP-FPM.
					$this->output->_display();
					ob_end_flush();
					fastcgi_finish_request();
					ignore_user_abort(true);
				} else {
					// Legacy compatibility.
					ob_end_flush();
				}
			}
			ob_end_flush();
			// Otherwise dump the output automatically
		} else {
			echo json_encode($data);
		}
	}
}

