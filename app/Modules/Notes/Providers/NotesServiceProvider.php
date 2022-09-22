<?php

namespace App\Modules\Notes\Providers;

use App\Modules\Notes\Services\INotesService;
use App\Modules\Notes\Services\NotesServiceImpl;
use Illuminate\Support\ServiceProvider;

class NotesServiceProvider extends ServiceProvider
{

    public $bindings = [
        INotesService::class => NotesServiceImpl::class,
    ];

}
