<?php

namespace App\Modules\User\Providers;

use App\Modules\User\Services\IUserService;
use App\Modules\User\Services\UserServiceImpl;
use Illuminate\Support\ServiceProvider;

class UsersServiceProvider extends ServiceProvider
{

    public $bindings = [
        IUserService::class => UserServiceImpl::class,
    ];

}
