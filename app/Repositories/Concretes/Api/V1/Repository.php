<?php

namespace App\Repositories\Concretes\Api\V1;

use App\Exceptions\RepoModelNotSetException;
use App\Repositories\Contracts\Api\V1\RepositoryInterface;

class Repository implements RepositoryInterface
{
	protected $model;

	public function __construct()
	{
		if (! $this->model) {
			throw (new RepoModelNotSetException())->setRepo(get_called_class());
		}

		$this->model = new $this->model();
	}
}