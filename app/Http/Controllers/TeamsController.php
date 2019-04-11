<?php

namespace App\Http\Controllers;


use App\Repositories\Contracts\Api\V1\Users\UsersRepositoryInterface;
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

		return response()->json(['success' => $this->userRepo->createTeam($request->all())]);
	}
}