<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CanCreateNewUserTest extends TestCase
{
	use DatabaseTransactions;

	public function test_can_create_new_user()
	{
		$this->post('api/v1/users', ['name' => 'Member', 'email' => 'test@test.com'])
			->seeJson([
				'created' => true,
			]);
	}
}