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
		$this->put("api/v1/users", ['name' => 'Name changed'])->seeStatusCode(401);

		$this->put("api/v1/users", ['name' => 'Name changed', 'api_token' => $this->user->api_token])
			->seeInDatabase('users', ['name' => 'Name changed']);
	}

	public function test_can_delete_user_info()
	{
		$this->put("api/v1/users", [])->seeStatusCode(401);

		$this->delete("api/v1/users", ['api_token' => $this->user->api_token])->seeStatusCode(200);

		//Because of soft delete
		$this->seeInDatabase('users', ['name' => 'Member']);
	}

	public function test_can_see_list_of_teams_for_the_user()
	{
		$teamId1 = json_decode($this->post('/api/v1/teams', ['title' => 'New Title', 'api_token' => $this->user->api_token])->response->getContent())->data->id;

		$teamId2 = json_decode($this->post('/api/v1/teams', ['title' => 'New Title 1', 'api_token' => $this->user->api_token])->response->getContent())->data->id;

		$content = json_decode($this->get("/api/v1/users/teams?api_token={$this->user->api_token}")->response->getContent());

		$this->assertEquals($teamId1, $content->teams[0]->pivot->team_id);
		$this->assertEquals($teamId2, $content->teams[1]->pivot->team_id);
	}
}