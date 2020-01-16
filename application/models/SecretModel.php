<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by Tankó Péter
 */
class SecretModel extends SecretModelMap
{

	function __construct()
	{
		parent::__construct();
	}

	public static function get()
	{
		return new self;
	}

	/**
	 * override method
	 */
	public function save()
	{
		if (empty($this->hash)) {
			$this->hash = $this->generateUniqueHash();
			$this->insert();
		} else {
			$this->update(self::HASH);
		}
		return $this;
	}

	/**
	 * This method generates a unique hash to the secret object
	 * @return hash
	 */
	public function generateUniqueHash()
	{
		$hash = hashGenerator();
		while ($this->getByHash($hash) instanceof SecretModel) {
			$hash = hashGenerator();
		}
		return $hash;
	}

	/**
	 * Get secret object by hash
	 * @param $hash
	 */
	public function getByHash($hash)
	{
		return $this->db->select()
			->from(self::DB_TABLE_NAME)
			->where(self::HASH, $hash)
			->get()->first_row(get_class($this));
	}

	/**
	 * This method creates the secret object by the given parameters.
	 * @param $secret
	 * @param $expireAfterViews
	 * @param $expireAfter
	 */
	public function createSecret($secret, $expireAfterViews, $expireAfter)
	{
		$expireAfterInSeconds = 60 * $expireAfter;
		$actualDateTime = new DateTime();
		$this->setSecretText($secret);
		$this->setRemainingViews($expireAfterViews);
		$this->setCreatedAt($actualDateTime->format('Y-m-d H:i:s.u'));
		if ($expireAfter > 0) {
			$actualDateTime->modify("+{$expireAfterInSeconds} seconds");
			$this->setExpiresAt($actualDateTime->format('Y-m-d H:i:s.u'));
		}
		$this->save();
	}

	/**
	 * This method generates the response for the API.
	 * @return array
	 */
	public function toApi()
	{
		$createdAt = new DateTime($this->createdAt);
		$expiresAt = new DateTime($this->expiresAt);
		if (!empty($this->hash)) {
			return [
				"hash" => $this->hash,
				"secretText" => $this->secretText,
				"createdAt" => $createdAt->format('Y-m-d\TH:i:s.v\Z'),
				"expiresAt" => is_null($this->expiresAt) ? '' : $expiresAt->format('Y-m-d\TH:i:s.v\Z'),
				"remainingViews" => $this->remainingViews
			];
		}
		return [];
	}

	/**
	 * This method checks the accessibility of the secret object.
	 * @param $actualDateTime - if false, checks the current time.
	 * @return bool
	 */
	public function isExpired($actualDateTime = false)
	{
		if ($this instanceof SecretModel) {
			if ($this->remainingViews == 0) {
				return true;
			}
			if ($actualDateTime === false) {
				$actualDateTime = new DateTime();
			}
			if (!is_null($this->expiresAt)) {
				$expiresAt = new DateTime($this->expiresAt);
				if ($actualDateTime > $expiresAt) {
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * This method is decreasing the remaining number of views by 1 on the secret object.
	 */
	public function isShowed()
	{
		if ($this->remainingViews > 0) {
			$this->remainingViews--;
		}
		$this->save();
	}
}
