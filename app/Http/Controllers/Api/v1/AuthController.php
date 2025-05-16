<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use App\Http\Requests\Api\ConfirmOtpRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    public function loginRegister(AuthRequest $request, AuthService $authService)
    {
        $validated = $request->validated();
        $token = $authService->sendOtpCode($validated['id']); 

        return Response::jsonResponse(['otpToken' => $token], 'send otp code successful', 200);
    }

    public function loginConfirm(ConfirmOtpRequest $request, AuthService $authService)
    {
        $validated = $request->validated();
        $result = $authService->loginViaApi($validated['otp_token'], $validated['otp_code']);

        if($result['success'] === false && $result['message'] == 'url is invalid')
        {
            return Response::jsonResponse(null, $result['message'], 400);
        }
        if($result['success'] === false && $result['message'] == 'otp is invalid')
        {
            return Response::jsonResponse(null, $result['message'], 422);
        }
        return Response::jsonResponse(['user' => $result['user'], 'token' => $result['accessToken']], $result['message'], 200);
    }

    public function loginResendOtp(AuthService $authService, Request $request)
    {
        $otpToken = $request->validate([
            'otp_token' => ['required', 'string', 'size:60']
        ]);
        $result = $authService->reSendOtp($otpToken['otp_token']);
        if($result['success'] === false && $result['message'] == 'url is invalid')
        {
            return Response::jsonResponse(null, $result['message'], 400);
        }
        return Response::jsonResponse($result['otpToken'], $result['message'], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return Response::jsonResponse(null, 'you are logged out', 204);
    }
}
