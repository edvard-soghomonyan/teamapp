<?php

namespace App\Exceptions;


class RepoModelNotSetException extends \Exception
{
	/**
	 * Set the Repo that is missing it's model.
	 *
	 * @param string $repo
	 *
	 * @return $this
	 */
	public function setRepo(string $repo)
	{
		$this->message = "Model for repository [{$repo}] has not been set.";

		return $this;
	}
}