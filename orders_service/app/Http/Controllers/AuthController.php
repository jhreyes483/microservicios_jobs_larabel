<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ClientHttp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ClientHttp;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], /*401 */);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        $data = response()->json([
            'status' => 'success',
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer'
            ],
            'user'=> $user
        ]);

        return $data;


        return response()->json(['error' => 'Unauthorized'], 401);
    }




    public function toLoginWarehouseService()
    {

        $this->urlWarehouseService  = config('alegra_services.URL_WAREHOUSE_INGREDIENTS_SERVICE');
        $output['status']           = false;
        $output['msg']              = 'error';
        $params['email']            = Auth::user()->email;
        $params['password']         = Auth::user()->password;
        $resp = $this->sendHttp( $this->getUrlWarehouseService()['warehouseLoginService'] ,$params,'POST',[] );
        return $resp;

    }
}
