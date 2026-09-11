<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\StrukturController;
use App\Http\Controllers\Frontend\GalleryController;
use App\Http\Controllers\Frontend\ContactController;


/*
|==========================================================================
| FRONTEND PUBLIK
|==========================================================================
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/tentang', [AboutController::class, 'index'])
    ->name('frontend.about');

Route::get('/tentang/visi-misi', [AboutController::class, 'visiMisi'])
    ->name('frontend.about.visi-misi');

Route::get('/tentang/sejarah', [AboutController::class, 'sejarah'])
    ->name('frontend.about.sejarah');

Route::get('/struktur', [StrukturController::class, 'index'])
    ->name('frontend.struktur');

Route::get('/struktur/{pengurus}', [StrukturController::class, 'detail'])
    ->name('frontend.struktur.detail');

Route::get('/gallery', [GalleryController::class, 'index'])
    ->name('frontend.gallery');

Route::get('/gallery/{gallery}', [GalleryController::class, 'album'])
    ->name('frontend.gallery.album');

Route::get('/kontak', [ContactController::class, 'index'])
    ->name('frontend.contact');

Route::post('/kontak', [ContactController::class, 'store'])
    ->name('frontend.contact.store');