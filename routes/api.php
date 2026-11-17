<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
*/

Route::get('/initial-data', [PublicController::class, 'getInitialData']);
Route::get('/profile', [PublicController::class, 'getProfile']);
Route::get('/skills', [PublicController::class, 'getSkills']);
Route::get('/education', [PublicController::class, 'getEducation']);
Route::get('/experience', [PublicController::class, 'getExperience']);
Route::get('/projects', [PublicController::class, 'getProjects']);
Route::get('/projects/{id}', [PublicController::class, 'getProject']);
Route::get('/certifications', [PublicController::class, 'getCertifications']);
Route::get('/social-links', [PublicController::class, 'getSocialLinks']);
Route::post('/contact', [PublicController::class, 'submitContact']);
Route::get('/resume/download', [PublicController::class, 'downloadResume']);

// Authentication
Route::post('/auth/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Admin API Routes
|--------------------------------------------------------------------------
*/
Route::middleware('admin.auth')->prefix('admin')->group(function () {
    // Auth status & management
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    // Dashboard Overview
    Route::get('/overview', [AdminController::class, 'getOverview']);

    // Profile & Files
    Route::get('/profile', [AdminController::class, 'getProfile']);
    Route::put('/profile', [AdminController::class, 'updateProfile']);
    Route::post('/avatar/upload', [AdminController::class, 'uploadAvatar']);
    Route::post('/resume/upload', [AdminController::class, 'uploadResume']);

    // Skills
    Route::get('/skills', [AdminController::class, 'getSkills']);
    Route::post('/skills', [AdminController::class, 'storeSkill']);
    Route::put('/skills/{id}', [AdminController::class, 'updateSkill']);
    Route::delete('/skills/{id}', [AdminController::class, 'deleteSkill']);

    // Projects
    Route::get('/projects', [AdminController::class, 'getProjects']);
    Route::post('/projects', [AdminController::class, 'storeProject']);
    Route::put('/projects/{id}', [AdminController::class, 'updateProject']);
    Route::post('/projects/{id}/image', [AdminController::class, 'uploadProjectImage']);
    Route::delete('/projects/{id}', [AdminController::class, 'deleteProject']);

    // Education
    Route::get('/education', [AdminController::class, 'getEducation']);
    Route::post('/education', [AdminController::class, 'storeEducation']);
    Route::put('/education/{id}', [AdminController::class, 'updateEducation']);
    Route::delete('/education/{id}', [AdminController::class, 'deleteEducation']);

    // Experience
    Route::get('/experience', [AdminController::class, 'getExperience']);
    Route::post('/experience', [AdminController::class, 'storeExperience']);
    Route::put('/experience/{id}', [AdminController::class, 'updateExperience']);
    Route::delete('/experience/{id}', [AdminController::class, 'deleteExperience']);

    // Certifications
    Route::get('/certifications', [AdminController::class, 'getCertifications']);
    Route::post('/certifications', [AdminController::class, 'storeCertification']);
    Route::put('/certifications/{id}', [AdminController::class, 'updateCertification']);
    Route::delete('/certifications/{id}', [AdminController::class, 'deleteCertification']);

    // Social Links
    Route::get('/social-links', [AdminController::class, 'getSocialLinks']);
    Route::post('/social-links', [AdminController::class, 'storeSocialLink']);
    Route::put('/social-links/{id}', [AdminController::class, 'updateSocialLink']);
    Route::delete('/social-links/{id}', [AdminController::class, 'deleteSocialLink']);

    // Contact Messages
    Route::get('/messages', [AdminController::class, 'getMessages']);
    Route::patch('/messages/{id}/read', [AdminController::class, 'markMessageAsRead']);
    Route::delete('/messages/{id}', [AdminController::class, 'deleteMessage']);
});

