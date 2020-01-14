<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SecretModel_test extends TestCase {

	protected $ci;

	public function setUp() {
		$this->ci = &get_instance();
		$this->ci->load->model('SecretModelMap');
		$this->ci->load->model('SecretModel');
		parent::setUp();
	}

	/**
	 * @test
	 */
	public function check_hash_length() {
		$hash = hashGenerator();
		$this->assertEquals(strlen($hash), 32);
	}

	/**
	 * @test
	 */
	public function check_secret_object_created(){
		$this->ci->db->trans_start();

		$secret = SecretModel::get();
		$actual_date = date('Y-m-d H:i:s');
		$secret->fromArray([
			SecretModel::SECRET_TEXT => 'Test',
			SecretModel::REMAINING_VIEWS => 10,
			SecretModel::EXPIRES_AT => $actual_date,
			SecretModel::CREATED_AT => $actual_date,
		]);
		$secret->save();

		$created_secret = SecretModel::get()->getByHash($secret->getHash());

		$this->assertEquals($secret, $created_secret);
		$this->ci->db->trans_rollback();
	}

	/**
	 * @test
	 */
	public function check_created_secret_object_expiration_time(){
		$this->ci->db->trans_start();

		$minutes = 5646554;
		$seconds = 60 * $minutes;
		$secret = SecretModel::get();
		$secret->createSecret("Test", 15, $minutes);

		$createdAt = new DateTime($secret->getCreatedAt());
		$expiresAt = new DateTime($secret->getExpiresAt());
		$sinceCreatedAt = $expiresAt->getTimestamp() - $createdAt->getTimestamp();

		$this->assertEquals($sinceCreatedAt, $seconds);
		$this->ci->db->trans_rollback();
	}
}
