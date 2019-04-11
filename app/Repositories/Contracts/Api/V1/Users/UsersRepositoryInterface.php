<?php

namespace App\Repositories\Contracts\Api\V1\Users;


use App\Repositories\Contracts\Api\V1\RepositoryInterface;

interface UsersRepositoryInterface extends RepositoryInterface
{
	/**
	 * Create a team for a user
	 *
	 * @param array $data
	 *
	 * @return mixed
	 */
	public function createTeam(array $data);

	/**
	 * Update team for a user
	 *
	 * @param int $teamId
	 * @param array $data
	 *
	 * @return mixed
	 */
	public function updateTeam($teamId, array $data);

	/**
	 * Can assign user to a team
	 *
	 * @param int $teamId
	 * @param int $userId
	 *
	 * @return mixed
	 */
	public function assignTeam($teamId, $userId);

	/**
	 * Can assign user to a team as Owner
	 *
	 * @param int $teamId
	 * @param int $userId
	 *
	 * @return mixed
	 */
	public function assignTeamAsOwner($teamId, $userId);

	/**
	 * Delete team for a user
	 *
	 * @param $teamId
	 *
	 * @return mixed
	 */
	public function deleteTeam($teamId);

}