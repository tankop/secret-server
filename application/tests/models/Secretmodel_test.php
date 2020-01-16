<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SecretModel_test extends TestCase
{

	protected $ci;

	public function setUp()
	{
		$this->ci = &get_instance();
		$this->ci->load->model('SecretModelMap');
		$this->ci->load->model('SecretModel');
		parent::setUp();
	}

	/**
	 * @test
	 */
	public function check_hash_length()
	{
		$hash = hashGenerator();
		$this->assertEquals(strlen($hash), 32);
	}

	/**
	 * @test
	 */
	public function check_secret_object_created()
	{
		$this->ci->db->trans_start();

		$secret = SecretModel::get();
		$actualDateTime = new DateTime();
		$secret->fromArray([
			SecretModel::SECRET_TEXT => 'Test',
			SecretModel::REMAINING_VIEWS => 10,
			SecretModel::EXPIRES_AT => $actualDateTime->format('Y-m-d H:i:s.u'),
			SecretModel::CREATED_AT => $actualDateTime->format('Y-m-d H:i:s.u'),
		]);
		$secret->save();

		$created_secret = SecretModel::get()->getByHash($secret->getHash());

		$this->assertEquals($secret, $created_secret);
		$this->ci->db->trans_rollback();
	}

	/**
	 * @test
	 */
	public function check_created_secret_object_expiration_time()
	{
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

	/**
	 * @test
	 */
	public function check_secret_is_expired_after_view()
	{
		$this->ci->db->trans_start();
		$expireAfterViews = 5;
		$minutes = 10;
		$secret = SecretModel::get();
		$secret->createSecret("Test", $expireAfterViews, $minutes);
		for ($i = 1; $i <= $expireAfterViews; $i++) {
			$secret->isShowed();
		}

		$this->assertEquals($secret->isExpired(), true);
		$this->ci->db->trans_rollback();
	}

	/**
	 * @test
	 */
	public function check_secret_is_expired_after_expiration_time()
	{
		$this->ci->db->trans_start();
		$minutes = 10;
		$expireAfterInSeconds = 60 * $minutes;
		$actualDateTime = new DateTime();
		$expiresAt = new DateTime();
		$expiresAt->modify("+{$expireAfterInSeconds} seconds");
		$secret = SecretModel::get();
		$secret->fromArray([
			SecretModel::SECRET_TEXT => 'Test',
			SecretModel::REMAINING_VIEWS => 2,
			SecretModel::EXPIRES_AT => $expiresAt->format('Y-m-d H:i:s.u'),
			SecretModel::CREATED_AT => $actualDateTime->format('Y-m-d H:i:s.u'),
		]);
		$secret->save();
		$expireAfterInSeconds++;
		$actualDateTime->modify("+{$expireAfterInSeconds} seconds");
		$this->assertEquals($secret->isExpired($actualDateTime), true);
		$this->ci->db->trans_rollback();
	}
}
