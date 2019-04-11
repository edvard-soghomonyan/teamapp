<?php

namespace App\Repositories\Concretes\Api\V1\Teams;


use App\Repositories\Concretes\Api\V1\Repository;
use App\Repositories\Contracts\Api\V1\Teams\TeamsRepositoryInterface;
use App\Team;

class TeamsRepository extends Repository implements TeamsRepositoryInterface
{
	protected $model = Team::class;
}