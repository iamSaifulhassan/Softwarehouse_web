<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoftwareUserController;
use App\Http\Controllers\ProjectIssueController;

// Public routes
Route::get('/', function () {
    return redirect('/login');
});

// Authentication routes
Route::get('/login', [SoftwareUserController::class, 'showLogin']);
Route::post('/login', [SoftwareUserController::class, 'login']);
Route::get('/register', [SoftwareUserController::class, 'showRegister']);
Route::post('/register', [SoftwareUserController::class, 'register']);
Route::get('/logout', [SoftwareUserController::class, 'logout']);

// Dashboard
Route::get('/dashboard', [SoftwareUserController::class, 'dashboard']);

// User management
Route::get('/users', [SoftwareUserController::class, 'index']);
Route::get('/users/create', [SoftwareUserController::class, 'create']);
Route::post('/users', [SoftwareUserController::class, 'store']);
Route::get('/users/{softwareUser}', [SoftwareUserController::class, 'show']);
Route::get('/users/{softwareUser}/edit', [SoftwareUserController::class, 'edit']);
Route::put('/users/{softwareUser}', [SoftwareUserController::class, 'update']);
Route::delete('/users/{softwareUser}', [SoftwareUserController::class, 'destroy']);

// Issue management
Route::get('/issues', [ProjectIssueController::class, 'index']);
Route::get('/issues/create', [ProjectIssueController::class, 'create']);
Route::post('/issues', [ProjectIssueController::class, 'store']);
Route::get('/issues/{projectIssue}', [ProjectIssueController::class, 'show']);
Route::get('/issues/{projectIssue}/edit', [ProjectIssueController::class, 'edit']);
Route::put('/issues/{projectIssue}', [ProjectIssueController::class, 'update']);
Route::delete('/issues/{projectIssue}', [ProjectIssueController::class, 'destroy']);

// Team Lead specific routes
Route::post('/issues/{projectIssue}/assign', [ProjectIssueController::class, 'assign']);

// Developer specific routes
Route::post('/issues/{projectIssue}/status', [ProjectIssueController::class, 'updateStatus']);

// QA specific routes
Route::post('/issues/{projectIssue}/qa', [ProjectIssueController::class, 'qaAction']);
