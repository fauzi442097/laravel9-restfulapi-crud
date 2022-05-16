<?php

namespace App\Http\Controllers;

use App\Exceptions\ServiceException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Services\UserService;

class AuthController extends Controller
{
    //
    public $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(LoginRequest $request)
    {
        DB::beginTransaction();
        try {
            $credentials = $request->only(['username', 'password']);
            $data = $this->userService->Login($credentials);
            DB::commit();
            return $this->responseSuccess($data);
        } catch (ServiceException $e) {
            DB::rollBack();
            return $this->ServiceExceptionHandler($e);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e); // Reporting to Handler Without rendering error page
            return $this->internalServerError($e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $arrRequest = $request->all();
            $data = $this->userService->Register($arrRequest);
            return $this->responseSuccess($data);
        } catch (ServiceException $e) {
            DB::rollBack();
            return $this->ServiceExceptionHandler($e);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e); // Reporting to Handler Without rendering error page
            return $this->internalServerError($e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

    public function logout()
    {
        Auth::logout();
        return $this->responseSuccess();
    }

    public function refresh()
    {
        $data = [
            'user' => Auth::user(),
            'authorization' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ];
        return $this->responseSuccess($data);
    }
}
