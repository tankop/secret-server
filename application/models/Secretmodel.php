<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by Tankó Péter
 */
class SecretModel extends SecretModelMap {

	function __construct() {
		parent::__construct();
	}

	public static function get() {
		return new self;
	}

	public function generateUniqueHash() {
		$hash = hashGenerator();
		while ($this->getByHash($hash) instanceof SecretModel) {
			$hash = hashGenerator();
		}
		return $hash;
	}

	public function getByHash($hash) {
		return $this->db->select()
			->from(self::DB_TABLE_NAME)
			->where(self::HASH, $hash)
			->get()->first_row(get_class($this));
	}

	public function save() {
		if (empty($this->hash)) {
			$this->hash = $this->generateUniqueHash();
			$this->insert();
		} else {
			$this->update(self::HASH);
		}
		return $this;
	}

	public function createSecret($secret, $expireAfterViews, $expireAfter) {
		$expireAfterInSeconds = 60 * $expireAfter;
		$actual_datetime = new DateTime();
		$timezone_UTC = new DateTimeZone("UTC");
		$actual_datetime->setTimezone($timezone_UTC);
		$this->setSecretText($secret);
		$this->setRemainingViews($expireAfterViews);
		$this->setCreatedAt($actual_datetime->format('Y-m-d H:i:s.u'));
		$actual_datetime->modify("+{$expireAfterInSeconds} seconds");
		$this->setExpiresAt($actual_datetime->format('Y-m-d H:i:s.u'));
		$this->save();
	}

	public function toApi() {
		$createdAt = new DateTime($this->createdAt);
		$expiresAt = new DateTime($this->expiresAt);
		if (!empty($this->hash)) {
			return [
				"hash" => $this->hash,
				"secretText" => $this->secretText,
				"createdAt" => $createdAt->format('Y-m-d\TH:i:s.v\Z'),
				"expiresAt" => $expiresAt->format('Y-m-d\TH:i:s.v\Z'),
				"remainingViews" => $this->remainingViews
			];
		}
	}
}
