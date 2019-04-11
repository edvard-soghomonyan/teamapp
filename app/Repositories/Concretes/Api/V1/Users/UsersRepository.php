<?php

namespace App\Repositories\Concretes\Api\V1\Users;


use App\Repositories\Concretes\Api\V1\Repository;
use App\Repositories\Contracts\Api\V1\Users\UsersRepositoryInterface;
use App\User;

class UsersRepository extends Repository implements UsersRepositoryInterface
{
	protected $model = User::class;
}