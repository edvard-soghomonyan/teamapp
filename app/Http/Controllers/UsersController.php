<?php

namespace App\Http\Controllers;


use App\Repositories\Contracts\Api\V1\Users\UsersRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UsersController extends Controller
{
	/**
	 * @var UsersRepositoryInterface
	 */
	protected $userRepo;

	public function __construct(UsersRepositoryInterface $userRepo)
	{
		$this->userRepo = $userRepo;
	}

	public function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|email|unique:users'
		]);

		if (! $this->userRepo->has('email', $request->email)) {
			$data = $request->all();
			$data['api_token'] = base64_encode(Str::random(40));

			return response()->json($this->userRepo->store($data));
		}

		return response()->json($this->userRepo->findWhere('email', $request->email));
	}

	public function update(Request $request)
	{
		$this->validate($request, [
			'name' => 'required'
		]);

		$userId = $this->userRepo->findWhere('api_token', $request->api_token)->first()->id;

		$this->userRepo->update($userId, $request->all());

		return response()->json(['success' => true]);
	}

	public function destroy(Request $request)
	{
		$userId = $this->userRepo->findWhere('api_token', $request->api_token)->first()->id;

		$this->userRepo->destroy($userId);

		return response()->json(['success' => true]);
	}
}