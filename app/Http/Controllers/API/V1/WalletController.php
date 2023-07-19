<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterCodeRequest;
use App\Models\Code;
use App\Services\CodeService;
use App\Services\UserService;
use App\Services\WalletService;
use Illuminate\Http\Response;

class WalletController extends Controller
{

    // Gets the user or creates the user if it doesn't exist
    // Checking if the code exists, is valid, or has been used by the user
    public function registerCode(RegisterCodeRequest $request)
    {
        $user = (new UserService())->store($request->only('mobile'));
        $code = Code::where('code', $request->input('code'))->first();

        // Check if the code is valid
        if (!($code && $code->isValid)) {
            return response()->json([
                'message' => 'Code is invalid'
            ], Response::HTTP_BAD_REQUEST);
        }


        // Check if the code used by user
        if ((new CodeService($code))->used($user)) {
            return response()->json([
                'message' => 'You already registered this code'
            ], Response::HTTP_CONFLICT);
        }

        // Charging user wallet
        if ((new WalletService($user))->storeUsingCode($code)) {
            return response()->json([
                'message' => 'Successfully done'
            ], Response::HTTP_CREATED);
        }

        return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);

    }
}
