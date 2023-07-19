<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterCodeRequest;
use App\Http\Resources\UserResource;
use App\Models\Code;
use App\Services\CodeService;
use App\Services\UserService;
use App\Services\WalletService;
use Illuminate\Http\Response;

class CodesController extends Controller
{

    public function getUsersUsedCode(Code $code)
    {
        return response()->json([
            'data' => UserResource::collection($code->wallets()->get()->pluck('user'))
        ]);
    }

    public function register(RegisterCodeRequest $request, $code)
    {
        $user = (new UserService())->store($request->only('mobile'));
        $code = Code::where('code', $code)->first();

        // Check if the code is valid
        if (!$code) {
            return response()->json([
                'message' => 'Code is invalid'
            ], Response::HTTP_BAD_REQUEST);
        }

        // Check if the code is expired
        if (!$code->isValid) {
            return response()->json([
                'message' => 'Code is expired'
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


    // Change code status to active or inactive
    public function toggleStatus(Code $code)
    {

        $updateStatus = (new CodeService($code))->changeStatus(!$code->status);

        if ($updateStatus) {
            return response()->json([
                'message' => 'New status is ' . $code->status_in_human
            ]);
        } else {
            return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
