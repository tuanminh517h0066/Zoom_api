<?php
namespace App\Http\Controllers\Frontend\API;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;

class AuthController extends Controller
{
	
	public function test(Request $request)
	{
		echo 'Testing';
	}

	public function register(Request $request)
	{
		$user = Member::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password),
		]);

		$token = auth()->login($user);

		return $this->respondWithToken($token);
	}

	public function login(Request $request)
	{
		$password = $request->get('password');
        $email = $request->get('email');

		//$credentials = $request->only(['email' => $email, 'password' => $password]);
		if (!$token = auth('api')->attempt(['email' => $email, 'password' => $password])) {
			return response()->json(['error' => 'Unauthorized'], 401);
		}

		return $this->respondWithToken($token);
	}

	public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

	protected function respondWithToken($token)
	{
		return response()->json([
			'access_token' => $token,
			'token_type' => 'bearer',
			'expires_in' => auth('api')->factory()->getTTL() * 60,
			'status' => 200,
            'response' => 'Successfully login',
		]);
	}
}