<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by Tankó Péter
 */
class SecretModelMap extends MasterModel
{

	const HASH = 'hash';
	const SECRET_TEXT = 'secretText';
	const CREATED_AT = 'createdAt';
	const EXPIRES_AT = 'expiresAt';
	const REMAINING_VIEWS = 'remainingViews';

	const DB_TABLE_NAME = 'secret';

	protected $hash;
	protected $secretText;
	protected $createdAt;
	protected $expiresAt;
	protected $remainingViews;

	function __construct()
	{
		parent::__construct();
		$this->setDbTablename(self::DB_TABLE_NAME);
		$this->db_fields = $this->db->list_fields($this->db_tablename);
	}

	public function getHash()
	{
		return $this->hash;
	}

	public function setHash($hash)
	{
		$this->hash = $hash;
	}

	public function getSecretText()
	{
		return $this->secretText;
	}

	public function setSecretText($secretText)
	{
		$this->secretText = $secretText;
	}

	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;
	}

	public function getExpiresAt()
	{
		return $this->expiresAt;
	}

	public function setExpiresAt($expiresAt)
	{
		$this->expiresAt = $expiresAt;
	}

	public function getRemainingViews()
	{
		return $this->remainingViews;
	}

	public function setRemainingViews($remainingViews)
	{
		$this->remainingViews = $remainingViews;
	}
}
