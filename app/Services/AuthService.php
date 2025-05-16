<?php

namespace App\Services;

use App\Events\SendOtp;
use App\Models\User;
use App\Repositories\Contracts\OtpRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthService
{
    public function __construct(
        public UserRepositoryInterface $userRepository,
        // public MelipayamakService $melipayamakService,
        public OtpRepositoryInterface $otpRepository
    )
    {}

    public function sendOtpCode($loginId)
    {
        $check = $this->checkLoginId($loginId);
        $user = $this->userRepository->findOrCreateByMobile($check['login_id']);
        $otp = $this->makeOtp($user, $check);

        event(new SendOtp([$otp['otp_code']], $user->mobile, 314163));
        return $otp['token'];
    }

    public function reSendOtp($token)
    {
        $otp = $this->findWhere([
            'token' => $token,
            'used' => 0,
            'created_at' => ['>=', $this->getMinutes(5)]
        ], [], ['*']);

        if (empty($otp)) {
            return ['success' => false, 'message' => 'url is invalid'];
        }

        $user = $otp->user;

        $otpToken = $this->sendOtpCode($user->mobile);
        return ['otpToken' => $otpToken, 'success' => true, 'message' => 'send otp is successful'];
    }
    public function getMinutes(?int $minutes)
    {   // set minute return subMinutes, otherwise return now.
        return isset($minutes) ? Carbon::now()->subMinutes($minutes)->toDateTimeString() : Carbon::now();
    }

    public function loginViaApi(string $otpToken, string $otpCode)
    {
        $otp = $this->findWhere(['token' => $otpToken, 'used' => 0, 'created_at' => ['>=', $this->getMinutes(5)]], [], ['*']);

        if (empty($otp)) {
            return ['success' => false, 'message' => 'url is invalid'];
        }

        if ($otp->otp_code !== $otpCode) {
            return ['success' => false, 'message' => 'otp is invalid'];
        }

        $this->otpRepository->update($otp->id, ['used' => 1]);
        $user = $otp->user;

        $accessToken = $user->createToken('auth-token')->plainTextToken;

        return ['success' => true, 'message' => 'you are logged in', 'accessToken' => $accessToken, 'user' => $user];
    }

    public function makeOtp(User $user, array $check)
    {
        //create otp code
        $otpCode = rand(111111, 999999);
        $token = Str::random(60);

        $otpInputs = [
            'token' => $token,
            'otp_code' => $otpCode,
            'user_id' => $user->id,
            'login_id' => $check['login_id'],
            'type' => $check['type'],
        ];
        $this->otpRepository->create($otpInputs);
        return $otpInputs;
    }

    public function checkLoginId($loginId)
    {
        if (preg_match('/^(\+98|98|0)9\d{9}$/', $loginId)) {
            // 0 =>mobile
            //check mobile format
            $loginId = ltrim($loginId, 0);
            $loginId = substr($loginId, 0, 2) === '98' ? substr($loginId, 2) : $loginId;
            $loginId = str_replace('98', '', $loginId);
            $loginId = '0' . $loginId;
            $result = ['type' => 0, 'login_id' => $loginId];
        }
        return $result;
    }

    public function find($token)
    {
        return $this->otpRepository->findBy('token', $token);
    }

    public function findWhere(array $conditions, array $with = [], $columns)
    {
        return $this->otpRepository->findWhere($conditions, $with, $columns);
    }

}