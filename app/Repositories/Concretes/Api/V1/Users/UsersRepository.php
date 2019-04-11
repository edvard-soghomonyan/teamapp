<?php

namespace App\Repositories\Concretes\Api\V1\Users;


use App\Repositories\Concretes\Api\V1\Repository;
use App\Repositories\Contracts\Api\V1\Teams\TeamsRepositoryInterface;
use App\Repositories\Contracts\Api\V1\Users\UsersRepositoryInterface;
use App\User;
use App\UsersTeam;
use Illuminate\Support\Facades\Log;

class UsersRepository extends Repository implements UsersRepositoryInterface
{
	protected $model = User::class;

	protected $teamRepo;

	public function __construct(TeamsRepositoryInterface $teamRepo)
	{
		parent::__construct();

		$this->teamRepo = $teamRepo;
	}

	/**
	 * Create a team for a user
	 *
	 * @param array $data
	 *
	 * @return mixed
	 */
	public function createTeam(array $data)
	{
		$user = $this->findWhere('api_token', $data['api_token'])->first();

		$team = $this->teamRepo->store($data);

		$user->teams()->sync($team);

		$usersTeam = UsersTeam::whereUserId($user->id)->whereTeamId($team->id)->first();
		Log::debug($usersTeam->id);
		$usersTeam->assignRole('owner');

		return true;
	}
}