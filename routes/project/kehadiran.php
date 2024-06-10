<?php

declare(strict_types=1);

use App\Orchid\Screens\Kehadiran\Ahli_ListScreen;
use App\Orchid\Screens\Kehadiran\Aktiviti_ListScreen;
use App\Orchid\Screens\Kehadiran\Kehadiran_ListScreen;
use App\Orchid\Screens\Kehadiran\Kelas_ListScreen;
use Tabuna\Breadcrumbs\Trail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Kehadiran Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Aktiviti
Route::screen('aktiviti', Aktiviti_ListScreen::class)
    ->name('kehadiran.aktiviti')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Kelas'), route('kehadiran.aktiviti'));
    });


// Kelas
Route::screen('kelas', Kelas_ListScreen::class)
    ->name('kehadiran.kelas')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Kelas'), route('kehadiran.kelas'));
    });


// Ahli
Route::screen('ahli', Ahli_ListScreen::class)
    ->name('kehadiran.ahli')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Ahli'), route('kehadiran.ahli'));
    });


// Kehadiran
Route::screen('kehadiran', Kehadiran_ListScreen::class)
    ->name('kehadiran.kehadiran')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Kehadiran'), route('kehadiran.kehadiran'));
    });

