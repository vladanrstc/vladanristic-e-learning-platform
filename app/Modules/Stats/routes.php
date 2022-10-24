<?php

use App\Modules\Stats\Controllers\StatsController;
use Illuminate\Support\Facades\Route;

Route::get("/{commandName}", [StatsController::class, "executeCommand"]);
