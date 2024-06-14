<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthApiController extends Controller
{
    // /**
    //  * Create a new AuthController instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login', 'register']]);
    // }

    // public function register() {
    //     $validator = Validator::make(request()->all(),[
    //         'name' => 'required',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required',
    //     ]);

    //     if($validator->fails()) {
    //         return response()->json($validator->messages());
    //     }

    //     $user = User::create([
    //         'name' => request('name'),
    //         'email' => request('email'),
    //         'password' => Hash::make(request('password')),
    //     ]);
    //     if($user) {
    //         return response()->json(['message' => 'Pendaftaran Berhasil']);
    //     } else {
    //         return response()->json(['message' => 'Pendaftaran Gagal']);
    //     }
    // }

    // /**
    //  * Get a JWT via given credentials.
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function login()
    // {
    //     $credentials = request(['email', 'password']);

    //     if (!$token = auth()->attempt($credentials)) {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }

    //     return $this->respondWithToken($token);
    // }

    // /**
    //  * Get the authenticated User.
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function me()
    // {
    //     return response()->json(auth()->user());
    // }

    // /**
    //  * Log the user out (Invalidate the token).
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function logout()
    // {
    //     auth()->logout();

    //     return response()->json(['message' => 'Successfully logged out']);
    // }

    // /**
    //  * Refresh a token.
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function refresh()
    // {
    //     return $this->respondWithToken(auth()->refresh());
    // }

    // /**
    //  * Get the token array structure.
    //  *
    //  * @param  string $token
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // protected function respondWithToken($token)
    // {
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => auth()->factory()->getTTL() * 60
    //     ]);
    // }


    //Register API(POST,formdata)
    public function register(Request $request)
    {
        //Data Validation
        $request->validate([
            'name'      => ['required'],
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return response()->json([
            'status'  => true,
            'message' => 'Registrasi berhasil',
        ]);
    }

    //profil API(POST,formdata)
    public function login(Request $request)
    {
        //Data Validation
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        $token = JWTAuth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if (!empty($token)) {
            return response()->json([
                'status'  => true,
                'message' => 'Berhasil login',
                'token' => $token
            ]);
        }

        return response()->json([
            'status'  => false,
            'message' => 'Gagal login',
        ]);
    }

    //profile API(GET)
    public function profile()
    {
        $userData = auth()->user();

        return response()->json([
            'status'  => true,
            'message' => 'Data profil',
            'token' => $userData
        ]);
    }

    //(GET)
    public function refreshToken()
    {
        $newToken = auth()->refresh();

        return response()->json([
            'status'  => true,
            'message' => 'New Access token generated',
            'token' => $newToken
        ]);
    }

    //(GET)
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'status'  => true,
            'message' => 'user berhasil logout',
        ]);
    }
}
