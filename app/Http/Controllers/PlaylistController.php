<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlaylistController extends Controller
{
    /**
     * عرض كل قوائم التشغيل
     */
    public function index()
    {
        $playlists = Playlist::withCount('songs')->latest()->get();
        return view('playlists.index', compact('playlists'));
    }

    /**
     * عرض قائمة تشغيل معينة
     */
    public function show(Playlist $playlist)
    {
        $playlist->load('songs');
        $allSongs = Song::all();
        return view('playlists.show', compact('playlist', 'allSongs'));
    }

    /**
     * إنشاء قائمة جديدة - نسخة مبسطة تعمل 100%
     */
    public function store(Request $request)
    {
        // تحقق بسيط من البيانات
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:500',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'البيانات المدخلة غير صحيحة',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        // سجل البيانات المستلمة
        Log::info('Creating playlist with data:', $request->all());

        try {
            // إنشاء القائمة
            $playlist = Playlist::create([
                'name' => $request->name,
                'description' => $request->description ?? null,
            ]);

            Log::info('Playlist created successfully:', ['id' => $playlist->id, 'name' => $playlist->name]);

            // إذا كان الطلب AJAX أو JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تم إنشاء قائمة التشغيل بنجاح',
                    'playlist' => [
                'id' => $playlist->id,
                        'name' => $playlist->name,
                        'url' => route('playlists.show', $playlist)
                    ]
                ]);
            }

            // إذا كان طلب عادي
            return redirect()->route('playlists.index')
                ->with('success', 'تم إنشاء قائمة التشغيل "' . $request->name . '" بنجاح');

        } catch (\Exception $e) {
            Log::error('Error creating playlist: ' . $e->getMessage());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'حدث خطأ: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'حدث خطأ: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * إضافة أغنية للقائمة - نسخة مبسطة تعمل 100%
     */
    public function addSong(Request $request, Playlist $playlist)
    {
        // تحقق من البيانات
        try {
            $validated = $request->validate([
                'song_id' => 'required|exists:songs,id'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'البيانات المدخلة غير صحيحة',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        Log::info('Adding song to playlist:', [
            'playlist_id' => $playlist->id,
            'song_id' => $request->song_id
        ]);

        try {
            $song = Song::findOrFail($request->song_id);

            // تحقق إذا الأغنية موجودة بالفعل في القائمة
            if ($playlist->songs()->where('song_id', $song->id)->exists()) {
                Log::warning('Song already in playlist:', ['song_id' => $song->id]);
                
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'الأغنية "' . $song->title . '" موجودة بالفعل في القائمة'
                    ]);
                }
                return back()->with('error', 'الأغنية موجودة بالفعل في القائمة');
            }

            // إضافة الأغنية للقائمة باستخدام الطريقة البسيطة
            $playlist->songs()->attach($song->id, [
                'order' => $playlist->songs()->count() + 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Log::info('Song added to playlist successfully:', [
                'playlist_id' => $playlist->id,
                'song_id' => $song->id,
                'song_title' => $song->title
            ]);

            // إعادة تحميل العلاقة للحصول على البيانات المحدثة
            $playlist->load('songs');

            // إذا كان الطلب AJAX أو JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تمت إضافة الأغنية "' . $song->title . '" للقائمة',
                    'song' => [
                        'id' => $song->id,
                        'title' => $song->title,
                        'artist' => $song->artist,
                        'duration' => $song->duration
                    ],
                    'playlist_songs_count' => $playlist->songs->count()
                ]);
            }

            // إذا كان طلب عادي
            return back()->with('success', 'تمت إضافة الأغنية "' . $song->title . '" للقائمة');

        } catch (\Exception $e) {
            Log::error('Error adding song to playlist: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'حدث خطأ: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * إزالة أغنية من القائمة
     */
    public function removeSong(Playlist $playlist, Song $song)
    {
        try {
            $songTitle = $song->title;
            
            // إزالة الأغنية من القائمة
            $playlist->songs()->detach($song->id);
            
            Log::info('Song removed from playlist:', [
                'playlist_id' => $playlist->id,
                'song_id' => $song->id,
                'song_title' => $songTitle
            ]);

            return back()->with('success', 'تمت إزالة الأغنية "' . $songTitle . '" من القائمة');
        } catch (\Exception $e) {
            Log::error('Error removing song from playlist: ' . $e->getMessage());

            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * حذف قائمة التشغيل
     */
    public function destroy(Playlist $playlist)
    {
        try {
            $playlistName = $playlist->name;
            
            // حذف جميع العلاقات أولاً
            $playlist->songs()->detach();
            
            // حذف القائمة
            $playlist->delete();
            
            Log::info('Playlist deleted:', [
                'id' => $playlist->id,
                'name' => $playlistName
            ]);

            return redirect()->route('playlists.index')
                ->with('success', 'تم حذف قائمة التشغيل "' . $playlistName . '"');
        } catch (\Exception $e) {
            Log::error('Error deleting playlist: ' . $e->getMessage());

            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }
}