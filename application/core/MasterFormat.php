<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by Tankó Péter
 */
class MasterFormat extends \chriskacerguis\RestServer\Format
{

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * TODO: response yaml type
	 */
	public function to_yaml($data = null)
	{

		return "";
	}
}
