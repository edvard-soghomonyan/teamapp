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

	public function test_can_edit_team()
	{
		$teamId = json_decode($this->post('/api/v1/teams', ['title' => 'Test title', 'api_token' => $this->user->api_token])->response->getContent())->data->id;

		$this->put("/api/v1/teams/{$teamId}", ['title' => 'Updated', 'api_token' => $this->user->api_token])
			->seeInDatabase('teams', ['title' => 'Updated']);

		//Create new user

		$newUser = json_decode($this->post('api/users', [
				'email' => 'new_user@test.com',
				'name' => 'Jane Doe']
		)->response->getContent());

		$this->put("/api/v1/teams/{$teamId}", ['title' => 'Updated', 'api_token' => $newUser->api_token])
			->seeStatusCode(401);
	}

	public function test_can_assign_user_to_team()
	{
		$teamId = json_decode($this->post('/api/v1/teams', ['title' => 'New Title', 'api_token' => $this->user->api_token])->response->getContent())->data->id;

		$newUser = json_decode($this->post('api/users', [
				'email' => 'new_user@test.com',
				'name' => 'Jane Doe']
		)->response->getContent());


		$this->post("/api/v1/teams/{$teamId}/assign/{$newUser->id}", ['api_token' => $this->user->api_token])
			->seeInDatabase('users_teams', ['user_id' => $newUser->id, 'team_id' => $teamId])->response->getContent();

		$this->put("/api/v1/teams/{$teamId}", ['title' => 'Updated', 'api_token' => $newUser->api_token])
			->seeStatusCode(401);
	}
}