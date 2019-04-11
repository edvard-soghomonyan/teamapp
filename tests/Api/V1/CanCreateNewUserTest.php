<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CanCreateNewUserTest extends TestCase
{
	use DatabaseTransactions;

	private $user;

	/**
	 * Setup the test environment.
	 *
	 * @return void
	 */
	protected function setUp(): void
	{
		parent::setUp();

		$this->user = json_decode($this->post('api/users', [
			'email' => 'valid@email.com',
			'name' => 'Member']
		)->response->getContent());

	}

	public function test_can_create_new_user()
	{
		$this->post('api/users', [])
			->notSeeInDatabase('users', ['name' => 'New Member']);

		$this->post('api/users', ['name' => 'New Member'])
			->notSeeInDatabase('users', ['name' => 'New Member']);

		$this->post('api/users', ['name' => 'New Member', 'email' => 'notvalidemail'])
			->notSeeInDatabase('users', ['name' => 'New Member']);

		$this->post('api/users', ['email' => 'notvalidemail'])
			->notSeeInDatabase('users', ['email' => 'notvalidemail']);

		$this->post('api/users', ['email' => 'newvalid@email.com'])
			->notSeeInDatabase('users', ['email' => 'newvalid@email.com']);

		$this->post('api/users', ['email' => 'newvalid1@email.com', 'name' => 'New Member'])
			->seeInDatabase('users', ['email' => 'newvalid1@email.com', 'name' => 'New Member']);
	}

	public function test_can_edit_user_info()
	{
		$this->put("api/v1/users", ['name' => 'Name changed', 'api_token' => $this->user->api_token])
			->seeInDatabase('users', ['name' => 'Name changed']);
	}
}