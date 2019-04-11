<?php

namespace App\Repositories\Contracts\Api\V1;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
	/**
	 * Store a new resource
	 *
	 * @param array $data
	 *
	 * @return mixed
	 */
	public function store(array $data);

	/**
	 * Update an existing resource
	 *
	 * @param $id
	 * @param array $data
	 *
	 * @return mixed
	 */
	public function update($id, array $data);

	/**
	 * Get a single object
	 *
	 * @param int $id
	 * @param array $columns
	 *
	 * @return Model|Collection
	 */
	public function findOrFail($id, $columns = ['*']);

	/**
	 * @param array $data
	 *
	 * @return mixed
	 */
	public function firstOrCreate(array $data = []);

	/**
	 * Get a single object
	 *
	 * @param int $id
	 * @param array $columns
	 *
	 * @return Object
	 */
	public function find($id, $columns = ['*']);

	/**
	 * Destroy an object
	 *
	 * @param int $id
	 *
	 * @return int
	 */
	public function destroy($id);

	/**
	 * See if record exists, given a specific column value
	 *
	 * @param string $col
	 * @param string $value
	 *
	 * @return bool
	 */
	public function has($col, $value);

	/**
	 * Find with where condition
	 *
	 * @param $column
	 * @param $value
	 *
	 * @return mixed
	 */
	public function findWhere($column, $value);
}