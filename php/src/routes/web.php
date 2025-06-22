<?php
declare(strict_types=1);

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopController;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\User\TrashController;
use Illuminate\Support\Facades\Auth;
use App\View\Components\Sidebar;

//@todo delete 理解したら削除
// Route::get('/', [TopController::class, 'index'])->name('top.index');
// Route::get('/article/{post_id}', [TopController::class, 'articleShow'])->name('top.article.show');
// Route::get('/article/category/{category_id}', [TopController::class, 'articleCategory'])->name('top.article.category');
// Route::get('/user/{id}/index', [PostController::class, 'index'])->name('user.index');
// Route::get('/user/{id}/post/create', [PostController::class, 'create'])->name('post.create');
// Route::post('/user/{id}/post', [PostController::class, 'store'])->name('post.store');
// Route::get('/post/{post_id}', [PostController::class, 'show'])->name('post.show');
// Route::get('/post/edit/{post_id}', [PostController::class, 'edit'])->name('post.edit');
// Route::post('/post/edit/{post_id}', [PostController::class, 'update'])->name('post.update');
// Route::get('/post/trash', [TrashController::class, 'trashList'])->name('post.trash');
// Route::post('/post/trash/{post_id}', [TrashController::class, 'moveTrash'])->name('post.move.trash');
// Route::post('/post/restore/{post_id}', [TrashController::class, 'restore'])->name('post.restore');
// Route::post('/post/delete/{post_id}', [TrashController::class, 'delete'])->name('post.delete');

Route::controller(TopController::class)->group(function() {
    Route::get('/', 'index')->name('top.index');
    Route::get('/article/{post_id}', 'articleShow')->name('top.article.show');
    Route::get('/article/category/{category_id}', 'articleCategory')->name('top.article.category');
});

//画面遷移させるため完全修飾名でコントローラーを指定
Route::get('auth/register', 'App\Http\Controllers\Auth\RegisteredUserController@create')->name('register');
Route::post('auth/register', 'App\Http\Controllers\Auth\RegisteredUserController@store')->name('register');
Route::get('auth/login', 'App\Http\Controllers\Auth\AuthenticatedSessionController@create')->name('login');
Route::post('auth/login', 'App\Http\Controllers\Auth\AuthenticatedSessionController@store')->name('login');
Route::post('auth/logout', 'App\Http\Controllers\Auth\AuthenticatedSessionController@destroy')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //@todo delete:login済みでないと遷移させない(bootstrap/app.phpでmiddleware)
    Route::controller(PostController::class)->group(function() {
        Route::get('/user/{id}/index', 'index')->name('user.index');
        Route::get('/user/{id}/post/create', 'create')->name('post.create');
        Route::post('/user/{id}/post', 'store')->name('post.store');
        Route::get('/post/show/{post_id}', 'show')->name('post.show');
        Route::get('/post/edit/{post_id}', 'edit')->name('post.edit');
        Route::post('/post/edit/{post_id}', 'update')->name('post.update');
        Route::get('/post/saveDraft', 'saveDraft')->name('post.saveDraft');
        Route::get('/post/release', 'release')->name('post.release');
        Route::get('/post/reservationRelease', 'reservationRelease')->name('post.reservationRelease');
    });
    
    Route::controller(TrashController::class)->group(function() {
        Route::get('/post/trash', 'trashList')->name('post.trash');
        Route::post('/post/trash/{post_id}', 'moveTrash')->name('post.move.trash');
        Route::post('/post/restore/{post_id}', 'restore')->name('post.restore');
        Route::post('/post/delete/{post_id}', 'delete')->name('post.delete');
    });
});

require __DIR__.'/auth.php';