<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class CanCreateTeamsTest extends TestCase
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
				'email' => 'test@test.com',
				'name' => 'John Doe']
		)->response->getContent());
	}

	public function test_can_create_team()
	{
		$this->post('/api/v1/teams', ['title' => 'Test title'])
			->notSeeInDatabase('teams', ['title' => 'Test title']);

		$this->post('/api/v1/teams', ['api_token' => $this->user->api_token])
			->notSeeInDatabase('teams', ['title' => 'Test title']);

		$this->post('/api/v1/teams', ['title' => 'Test title', 'api_token' => $this->user->api_token])
			->seeInDatabase('teams', ['title' => 'Test title']);
	}
}