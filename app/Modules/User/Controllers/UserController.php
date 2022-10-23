<?php

namespace App\Modules\User\Controllers;

use App\Decorators\InfoLangHelper;
use App\Enums\Modules;
use App\Lang\ILangHelper;
use App\Models\User;
use App\Modules\User\Requests\CreateUserRequest;
use App\Modules\User\Requests\UpdateLoggedUserRequest;
use App\Modules\User\Requests\UpdateUserRequest;
use App\Modules\User\Services\IUserService;
use App\Repositories\IUsersRepo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * @var IUserService
     */
    private IUserService $userService;

    /**
     * @var IUsersRepo
     */
    private IUsersRepo $usersRepo;

    /**
     * @var ILangHelper
     */
    private ILangHelper $langHelper;

    public function __construct(IUserService $userService, IUsersRepo $usersRepo, ILangHelper $langHelper)
    {
        $this->userService = $userService;
        $this->usersRepo   = $usersRepo;
        $this->langHelper  = $langHelper;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json(["data" => $this->userService->searchUsers($request->get('q'))]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUserRequest  $userRequest
     * @return JsonResponse
     */
    public function store(CreateUserRequest $userRequest): JsonResponse
    {
        return response()->json(['data' => $this->userService->createUser($userRequest->all())]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $updateUserRequest
     * @param  User  $user
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $updateUserRequest, User $user): JsonResponse
    {
        return response()->json(['data' => $this->userService->updateUser($updateUserRequest->all(), $user)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $user
     * @return JsonResponse
     */
    public function destroy($user): JsonResponse
    {
        $this->userService->permanentlyDeleteUser((int) $user);
        return response()->json(
            ["message" => $this->langHelper->getMessage("permanently_deleted_user", Modules::USER)]);
    }

    /**
     * @param  User  $user
     * @return JsonResponse
     */
    public function banUser(User $user): JsonResponse
    {
        $this->usersRepo->banUser($user);
        $infoLangHelper = new InfoLangHelper($this->langHelper);
        return response()->json(["message" => $infoLangHelper->getMessage("banned_user", Modules::USER)]);
    }

    /**
     * @return mixed
     */
    public function bannedUsers(): mixed
    {
        return User::onlyTrashed()->paginate(10);
    }

    /**
     * @param $user
     * @return JsonResponse
     */
    public function unbanUser($user): JsonResponse
    {
        $this->userService->unbanUser($user);
        return response()->json(["message" => $this->langHelper->getMessage("unbanned_user", Modules::USER)]);
    }

    /**
     * @return JsonResponse
     */
    public function loggedUser(): JsonResponse
    {
        return response()->json(["data" => Auth::user()]);
    }

    /**
     * @param  UpdateLoggedUserRequest  $request
     * @return JsonResponse
     */
    public function updateLoggedUser(UpdateLoggedUserRequest $request): JsonResponse
    {
        return response()->json([
            'data' => $this->userService->updateUser(
                $request->except([
                    "current_password", "password_repeat"
                ]), Auth::user())
        ]);
    }

}
