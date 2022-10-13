<?php

namespace App\Modules\User\Services;

use App\Exceptions\UserPermanentDeleteException;
use App\Exceptions\UserUpdateFailedException;
use App\Models\User;
use App\Modules\Auth\Exceptions\UserAlreadyExistsException;
use App\Repositories\IUsersRepo;
use App\Repositories\UsersRepo;

class UserServiceImpl implements IUserService
{

    /**
     * @var IUsersRepo
     */
    private IUsersRepo $usersRepo;

    public function __construct(UsersRepo $usersRepo)
    {
        $this->usersRepo = $usersRepo;
    }

    /**
     * @param  array  $userData
     * @return User
     * @throws UserAlreadyExistsException
     */
    public function createUser(array $userData): User
    {
        if (!is_null($this->usersRepo->getUserByEmail($userData['email']))) {
            throw new UserAlreadyExistsException($userData['email']);
        }

        return $this->usersRepo->createUser(
            $userData['name'],
            $userData['last_name'],
            $userData['email'],
            bcrypt($userData['password']),
            $userData['language'],
            $userData['role'],
            null,
            now()
        );
    }

    /**
     * @param  array  $userDataToUpdate
     * @param  User  $user
     * @return User
     * @throws UserUpdateFailedException
     */
    public function updateUser(array $userDataToUpdate, User $user): User
    {

        if (isset($userDataToUpdate['password']) && $userDataToUpdate['password'] != '') {
            $userDataToUpdate['password'] = bcrypt($userDataToUpdate['password']);
        } else {
            unset($userDataToUpdate['password']);
        }

        return $this->usersRepo->updateUser($userDataToUpdate, $user);

    }

    /**
     * @param  int  $userId
     * @return bool
     * @throws UserPermanentDeleteException
     */
    public function permanentlyDeleteUser(int $userId): bool
    {
        return $this->usersRepo->permanentlyDeleteUser($this->usersRepo->getTrashedUserById($userId));
    }

    /**
     * @param  int  $userId
     * @return bool
     */
    public function unbanUser(int $userId): bool
    {
        return $this->usersRepo->unbanUser($this->usersRepo->getTrashedUserById($userId));
    }
}
