<?php

use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamEditController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserStoreController;
use Symfony\Contracts\Service\ResetInterface;
use App\Http\Controllers\TeamCreateController;
use App\Http\Controllers\TeamSwitchController;
use App\Http\Controllers\TeamUpdateController;
use App\Http\Controllers\TeamProfileController;
use Illuminate\Auth\Middleware\RequirePassword;
use App\Http\Controllers\Auth\LoginIndexController;
use App\Http\Controllers\Auth\ResetIndexController;
use App\Http\Controllers\Auth\RecoverIndexController;
use App\Http\Controllers\Auth\RegisterIndexController;
use App\Http\Controllers\Auth\TwoFactorIndexController;
use App\Http\Controllers\Account\AccountIndexController;
use App\Http\Controllers\Account\SecurityIndexController;
use App\Http\Controllers\ChangeTeamMemberRoleController;
use App\Http\Controllers\RemoveTeamMemberController;
use App\Http\Controllers\TeamInviteController;
use App\Http\Controllers\TeamLeaveController;
use App\Http\Controllers\TeamStoreController;

// Please note: teams is Hospitals
// Teams ===== Hospitals
// Team ===== Hospital
Route::get('/', HomeController::class)->name('home');

Route::middleware('auth')->group(function(){
    Route::get('/dashboard', DashboardController::class)->name('dashboard')->middleware('verified');
    // user
    Route::post('/user/store', UserStoreController::class)->name('user.store');
    //team
    Route::get('/team/create', TeamCreateController::class)->name('team.create');
    Route::post('/team/store', TeamStoreController::class)->name('team.store');
    Route::get('/team/account', TeamProfileController::class)->name('team.account');
    Route::patch('/team/{team}/set_current', TeamSwitchController::class)->name('team.setCurrent');
    Route::get('/team/profile', TeamEditController::class)->name('team.edit');
    Route::patch('/team/update/{team}', TeamUpdateController::class)->name('team.update');
    Route::post('/team/leave/{team}', TeamLeaveController::class)->name('team.leave');
    Route::delete('/team/{team}/member/{user}/remove', RemoveTeamMemberController::class)->name('remove.team.member');
    Route::post('/team/{team}/invites', TeamInviteController::class)->name('team.invites.store');
    Route::delete('/team/{team}/invites/{invite}', [TeamInviteController::class, 'destroy'])->name('team.invites.destroy');
    Route::get('/team/invites/accept', [TeamInviteController::class, 'accept'])->name('team.invites.accept')->middleware('signed');
    Route::get('/team/{team}/members/{user}/role', ChangeTeamMemberRoleController::class)->name('team.members.role');
    Route::patch('/team/{team}/members/{user}/role', [ChangeTeamMemberRoleController::class, 'update'])->name('team.members.role.update');
});

if (Features::enabled(Features::registration())) {
    Route::get('/auth/register', RegisterIndexController::class)->name('auth.register');
}

Route::get('/auth/login', LoginIndexController::class)->name('auth.login');

if (Features::enabled(Features::updateProfileInformation())) {
    Route::get('/account', AccountIndexController::class)->name('account.index');
}

if (Features::hasSecurityFeatures()) {
    Route::get('/account/security', SecurityIndexController::class)->name('account.security.index');
}

if (Features::enabled(Features::twoFactorAuthentication())) {
    Route::get('/auth/two-factor', TwoFactorIndexController::class)->name('auth.two-factor');
}

if (Features::enabled(Features::resetPasswords())) {
    Route::get('/auth/recover', RecoverIndexController::class)->name('auth.recover');
    Route::get('/auth/reset', ResetIndexController::class)->name('password.reset');
}

require __DIR__ . '/fortify.php';
