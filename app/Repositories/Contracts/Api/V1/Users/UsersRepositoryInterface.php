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
}