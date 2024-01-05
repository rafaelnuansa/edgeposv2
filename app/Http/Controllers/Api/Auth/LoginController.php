<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    /**
     * index
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request)
    {
        //set validasi
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        //response error validasi
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //get "email" dan "password" dari input
        $credentials = $request->only('email', 'password');

        //check jika "email" dan "password" tidak sesuai
        if (!$token = auth()->guard('api')->attempt($credentials)) {

            //response login "failed"
            return response()->json([
                'success' => false,
                'message' => 'Email or Password is incorrect'
            ], 400);
        }

        //response login "success" dengan generate "Token"
        return response()->json([
            'success'       => true,
            'user'          => auth()->guard('api')->user()->only(['name', 'email']),
            'permissions'   => auth()->guard('api')->user()->getPermissionArray(),
            'token'         => $token
        ], 200);
    }

    /**
     * logout
     *
     * @return void
     */
    public function logout()
    {
        //remove "token" JWT
        JWTAuth::invalidate(JWTAuth::getToken());

        //response "success" logout
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function validateToken(Request $request)
    {
        try {
            // Mendapatkan token dari header Authorization
            $token = JWTAuth::getToken();

            // Mencoba memeriksa apakah token masih valid
            JWTAuth::checkOrFail($token);

            // Token masih valid, kembalikan respons sukses
            return response()->json([
                'success' => true,
                'message' => 'Token is valid',
            ], 200);
        } catch (\Exception $e) {
            // Tangani kesalahan jika token tidak valid
            return response()->json([
                'success' => false,
                'message' => 'Token is not valid'. $e->getMessage(),
            ], 401);
        }
    }

}
