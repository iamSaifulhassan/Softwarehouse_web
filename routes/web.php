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

// Dashboard routes
Route::get('/dashboard', [SoftwareUserController::class, 'dashboard']);
Route::get('/dashboard/requirements-analyst', [SoftwareUserController::class, 'requirementsAnalystDashboard']);
Route::get('/dashboard/team-lead', [SoftwareUserController::class, 'teamLeadDashboard']);
Route::get('/dashboard/developer', [SoftwareUserController::class, 'developerDashboard']);
Route::get('/dashboard/qa-specialist', [SoftwareUserController::class, 'qaSpecialistDashboard']);
Route::get('/team', [SoftwareUserController::class, 'teamLeadDashboard']);

// Issue management (no IDs in routes)
Route::get('/issues', [ProjectIssueController::class, 'index']);
Route::get('/issues/create', [ProjectIssueController::class, 'create']);
Route::post('/issues/store', [ProjectIssueController::class, 'store']);

// Issue actions using POST with issue_id in form data
Route::post('/issues/assign', [ProjectIssueController::class, 'assign']);
Route::post('/issues/start', [ProjectIssueController::class, 'start']);
Route::post('/issues/complete', [ProjectIssueController::class, 'complete']);
Route::post('/issues/approve', [ProjectIssueController::class, 'approve']);
Route::post('/issues/reject', [ProjectIssueController::class, 'reject']);

// Profile CRUD
Route::get('/profile', [SoftwareUserController::class, 'profile']);
Route::post('/profile/update', [SoftwareUserController::class, 'updateProfile']);
Route::post('/profile/delete', [SoftwareUserController::class, 'deleteProfile']);
