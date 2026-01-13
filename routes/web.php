<?php

use App\Http\Controllers\PlaylistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SongController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// الصفحة الرئيسية تذهب مباشرة للأغاني
Route::get('/', function () {
    return redirect()->route('songs.index');
});

// روابط الأغاني
Route::resource('songs', SongController::class);

// رابط تشغيل الأغنية
Route::get('/songs/{song}/play', [SongController::class, 'play'])
     ->name('songs.play');
     //
     // routes/web.php - أضف هذه الروابط
Route::resource('playlists', PlaylistController::class);
Route::post('/playlists/{playlist}/add-song', [PlaylistController::class, 'addSong'])
     ->name('playlists.add-song');
Route::delete('/playlists/{playlist}/remove-song/{song}', [PlaylistController::class, 'removeSong'])
     ->name('playlists.remove-song');
     //,والله في عون العبد ما كان العبد ف عون اخيه
//هذا للتعديل مع عبد الررحمن
//,ووو
//تعديل اخر