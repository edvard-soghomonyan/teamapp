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
		$usersTeam->assignRole('owner');

		return $team;
	}

	/**
	 * Update team for a user
	 *
	 * @param int $teamId
	 * @param array $data
	 *
	 * @return mixed
	 */
	public function updateTeam($teamId, array $data)
	{
		$user = $this->findWhere('api_token', $data['api_token'])->first();
		$usersTeam = UsersTeam::whereUserId($user->id)->whereTeamId($teamId)->first();

		if (is_object($usersTeam) && $usersTeam->hasRole('owner')) {
			return $this->teamRepo->update($teamId, ['title' => $data['title']]);
		}

		return response('Unauthorized.', 401);
	}

	/**
	 * Can assign user to a team
	 *
	 * @param int $teamId
	 * @param int $userId
	 *
	 * @return mixed
	 */
	public function assignTeam($teamId, $userId)
	{
		$user = $this->findOrFail($userId);
		$team = $this->teamRepo->findOrFail($teamId);

		$user->teams()->sync($team);

		$usersTeam = UsersTeam::whereUserId($user->id)->whereTeamId($team->id)->first();
		$usersTeam->assignRole('member');

		return true;
	}

	/**
	 * Can assign user to a team as owner
	 *
	 * @param int $teamId
	 * @param int $userId
	 *
	 * @return mixed
	 */
	public function assignTeamAsOwner($teamId, $userId)
	{
		$user = $this->findOrFail($userId);
		$team = $this->teamRepo->findOrFail($teamId);

		$user->teams()->sync($team);

		$usersTeam = UsersTeam::whereUserId($user->id)->whereTeamId($team->id)->first();
		$usersTeam->assignRole('owner');

		return true;
	}

	public function deleteTeam($teamId)
	{
		$user = $this->findWhere('api_token', $data['api_token'])->first();

		$usersTeam = UsersTeam::whereUserId($user->id)->whereTeamId($teamId)->first();

		if (is_object($usersTeam) && $usersTeam->hasRole('owner')) {
			return $this->teamRepo->destroy($teamId);
		}

		return response('Unauthorized.', 401);
	}
}