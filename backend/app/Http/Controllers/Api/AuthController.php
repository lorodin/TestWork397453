<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    /**
     * Login action
     *
     * @OA\Post (
     *      path="/api/login",
     *      summary="Login",
     *      tags={"User"},
     *      description="Login",
     *      @OA\RequestBody(
     *          request="Login request",
     *          required=true,
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/LoginRequest")
     *          )
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Login result",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status",
     *                  type="string",
     *                  example="success"
     *              ),
     *              @OA\Property (
     *                  property="data",
     *                  type="object",
     *                  @OA\Property (
     *                      property="token",
     *                      type="string",
     *                      example="<access token>"
     *                  )
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent (
     *              @OA\Property (
     *                  property="status",
     *                  type="string",
     *                  example="error"
     *              ),
     *              @OA\Property (
     *                  property="data",
     *                  type="object",
     *                  @OA\Property (
     *                      property="errors",
     *                      type="object",
     *                      @OA\Property (
     *                          property="email",
     *                          type="array",
     *                          @OA\Items (
     *                              type="string",
     *                              example="Email is invalid"
     *                          )
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *          response=400,
     *          description="Fail login",
     *          @OA\JsonContent (
     *              @OA\Property (
     *                  property="status",
     *                  type="string",
     *                  example="error"
     *              ),
     *              @OA\Property (
     *                  property="data",
     *                  type="string",
     *                  example="Incorrect email or password"
     *              )
     *          )
     *      )
     * )
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $input = $request->validated();

        if(!Auth::attempt(['email' => $input['email'], 'password' => $input['password']])){
            return $this->jsonResponse(false, 'Incorrect email or password');
        }

        /**
         * @var User $user
         */
        $user = Auth::user();

        return $this->jsonResponse(true, [
            'token' => $user->createToken('Laravel')->accessToken
        ]);
    }

    /**
     * Login action
     *
     * @OA\Post (
     *      path="/api/register",
     *      summary="Register",
     *      tags={"User"},
     *      description="Register user",
     *      @OA\RequestBody(
     *          request="Register request",
     *          required=true,
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/RegisterRequest")
     *          )
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Login result",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status",
     *                  type="string",
     *                  example="success"
     *              ),
     *              @OA\Property (
     *                  property="data",
     *                  type="object",
     *                  @OA\Property (
     *                      property="token",
     *                      type="string",
     *                      example="<access token>"
     *                  )
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent (
     *              @OA\Property (
     *                  property="status",
     *                  type="string",
     *                  example="error"
     *              ),
     *              @OA\Property (
     *                  property="data",
     *                  type="object",
     *                  @OA\Property (
     *                      property="errors",
     *                      type="object",
     *                      @OA\Property (
     *                          property="email",
     *                          type="array",
     *                          @OA\Items (
     *                              type="string",
     *                              example="Email is invalid"
     *                          )
     *                      )
     *                  )
     *              )
     *          )
     *      )
     * )
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $input = $request->validated();

        $user = new User;

        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = bcrypt($input['password']);

        $user->save();

        if (!$user->save()) {
            return $this->jsonResponse(false, 'Unknown error', 400);
        }

        return $this->jsonResponse(true, [
            'token' => $user->createToken('MyApp')->accessToken
        ]);
    }
}
