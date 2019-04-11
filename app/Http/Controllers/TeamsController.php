<?php

namespace App\Http\Controllers;


use App\Repositories\Contracts\Api\V1\Users\UsersRepositoryInterface;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TeamsController extends Controller
{
	protected $userRepo;

	public function __construct(UsersRepositoryInterface $userRepo)
	{
		$this->userRepo = $userRepo;
	}

	public function store(Request $request)
	{
		$this->validate($request, [
			'title' => 'required'
		]);

		return response()->json(['data' => $this->userRepo->createTeam($request->all())]);
	}

	public function update($teamId, Request $request)
	{
		$this->validate($request, [
			'title' => 'required'
		]);

		return $this->userRepo->updateTeam($teamId, $request->all());
	}

	public function assignUser($teamId, $userId)
	{
		return response()->json($this->userRepo->assignTeam($teamId, $userId));
	}
}