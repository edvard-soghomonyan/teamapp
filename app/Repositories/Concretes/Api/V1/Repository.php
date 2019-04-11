<?php

namespace App\Repositories\Concretes\Api\V1;

use App\Exceptions\RepoModelNotSetException;
use App\Repositories\Contracts\Api\V1\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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

	/**
	 * Store a new resource
	 *
	 * @param array $data
	 *
	 * @return mixed
	 */
	public function store(array $data)
	{
		$model = $this->model->create($data);

		return $model;
	}

	/**
	 * Update an existing resource
	 *
	 * @param $id
	 * @param array $data
	 *
	 * @return mixed
	 */
	public function update($id, array $data)
	{
		$model = $this->model->findOrFail($id);

		$model->update($data);

		return $model;
	}

	/**
	 * Get a single object
	 *
	 * @param int $id
	 * @param array $columns
	 *
	 * @return Model|Collection
	 */
	public function findOrFail($id, $columns = ['*'])
	{
		return $this->model->findOrFail($id, $columns);
	}

	/**
	 * @param array $data
	 *
	 * @return mixed
	 */
	public function firstOrCreate(array $data = [])
	{
		$model = $this->model->firstOrCreate($data);

		return $model;
	}

	/**
	 * Get a single object
	 *
	 * @param int $id
	 * @param array $columns
	 *
	 * @return Object
	 */
	public function find($id, $columns = ['*'])
	{
		return $this->model->find($id, $columns);
	}

	/**
	 * Destroy an object
	 *
	 * @param int $id
	 *
	 * @return int
	 */
	public function destroy($id)
	{
		$model = $this->find($id);

		$result = $model->destroy($id);

		return $result;
	}

	/**
	 * See if record exists, given a specific column value
	 *
	 * @param string $col
	 * @param string $value
	 *
	 * @return bool
	 */
	public function has($col, $value)
	{
		return (boolean) ($this->model->where($col, $value)->count());
	}

	/**
	 * Find with where condition
	 *
	 * @param $column
	 * @param $value
	 *
	 * @return mixed
	 */
	public function findWhere($column, $value)
	{
		return $this->model->where($column, 'LIKE', "%$value%");
	}
}