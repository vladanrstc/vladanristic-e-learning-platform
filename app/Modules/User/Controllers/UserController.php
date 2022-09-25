<?php

namespace App\Modules\User\Controllers;

use App\Enums\Modules;
use App\Exceptions\BanUserException;
use App\Exceptions\MessageTranslationNotFoundException;
use App\Exceptions\UserPermanentDeleteException;
use App\Exceptions\UserUpdateFailedException;
use App\Lang\LangHelper;
use App\Models\User;
use App\Modules\Auth\Exceptions\UserAlreadyExistsException;
use App\Modules\User\Requests\CreateUserRequest;
use App\Modules\User\Requests\UpdateLoggedUserRequest;
use App\Modules\User\Requests\UpdateUserRequest;
use App\Modules\User\Services\IUserService;
use App\Modules\User\Services\UserServiceImpl;
use App\Repositories\IUsersRepo;
use App\Repositories\UsersRepo;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    public function __construct(UserServiceImpl $userServiceImpl, UsersRepo $usersRepo) {
        $this->userService = $userServiceImpl;
        $this->usersRepo   = $usersRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $param = $request->get('q');

        if ($param != null) {
            return User::where("email", 'like', '%' . $param . '%')->paginate(10);
        } else {
            return User::paginate(10);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $userRequest
     * @return JsonResponse
     * @throws UserAlreadyExistsException
     */
    public function store(CreateUserRequest $userRequest): JsonResponse
    {
        return response()->json(['data' => $this->userService->createUser($userRequest->all())]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $updateUserRequest
     * @param User $user
     * @return JsonResponse
     * @throws UserUpdateFailedException
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
     * @throws UserPermanentDeleteException|MessageTranslationNotFoundException
     */
    public function destroy($user): JsonResponse
    {
        $this->userService->permanentlyDeleteUser((int) $user);
        return response()->json(["message" => LangHelper::getMessage("permanently_deleted_user", Modules::USER)]);
    }

    /**
     * @param User $user
     * @return JsonResponse
     * @throws MessageTranslationNotFoundException
     * @throws BanUserException
     */
    public function banUser(User $user) {
        $this->usersRepo->banUser($user);
        return response()->json(["message" => LangHelper::getMessage("banned_user", Modules::USER)]);
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
     * @throws MessageTranslationNotFoundException
     */
    public function unbanUser($user): JsonResponse
    {
        $this->usersRepo->unbanUser($user);
        return response()->json(["message" => LangHelper::getMessage("unbanned_user", Modules::USER)]);
    }

    /**
     * @return JsonResponse
     */
    public function loggedUser(): JsonResponse
    {
        return response()->json(["data" => Auth::user()]);
    }

    /**
     * @param UpdateLoggedUserRequest $request
     * @return JsonResponse
     * @throws UserUpdateFailedException
     */
    public function updateLoggedUser(UpdateLoggedUserRequest $request): JsonResponse
    {
        return response()->json(['data' => $this->userService->updateUser($request->except([
            "current_password", "password_repeat"
        ]), Auth::user())]);
    }

}
