<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Playlist;
use Illuminate\Http\Request;

class SongController extends Controller
{
    /**
     * عرض قائمة الأغاني
     */
  public function index()
{
    $songs = Song::all();
    $playlistsCount = Playlist::count();
    $totalDuration = Song::sum('duration') / 60;
    
    // تحويل البيانات لـ JSON
    $songsJson = $songs->map(function($song) {
        return [
            'id' => $song->id,
            'title' => $song->title,
            'artist' => $song->artist,
            'url' => asset($song->file_path),
            'duration' => $song->duration
        ];
    })->toJson();
    
    return view('songs.index', compact('songs', 'playlistsCount', 'totalDuration', 'songsJson'));
}

    /**
     * عرض نموذج إضافة أغنية
     */
    public function create()
    {
        return view('songs.create');
    }

    /**
     * حفظ الأغنية الجديدة - نسخة مبسطة ومضمونة
     */
    public function store(Request $request)
    {
        try {
            // 1. تحقق بسيط من البيانات
            if (empty($request->title) || empty($request->artist)) {
                return redirect()->back()
                    ->with('error', 'العنوان والفنان مطلوبان')
                    ->withInput();
            }

            // 2. تحقق من وجود ملف الصوت
            if (!$request->hasFile('song_file')) {
                return redirect()->back()
                    ->with('error', 'يجب اختيار ملف صوت')
                    ->withInput();
            }

            $file = $request->file('song_file');
            
            // 3. تأكد أن الملف صحيح
            if (!$file->isValid()) {
                return redirect()->back()
                    ->with('error', 'الملف غير صالح')
                    ->withInput();
            }

            // 4. التحقق من نوع الملف
            $allowedTypes = ['mp3', 'wav', 'ogg', 'mpeg'];
            $extension = $file->getClientOriginalExtension();
            
            if (!in_array(strtolower($extension), $allowedTypes)) {
                return redirect()->back()
                    ->with('error', 'نوع الملف غير مدعوم. استخدم MP3, WAV, OGG')
                    ->withInput();
            }

            // 5. حفظ الملف في public/songs/
            $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9\-_.]/', '', $file->getClientOriginalName());
            $publicPath = public_path('songs');
            
            // إنشاء مجلد songs إذا لم يكن موجوداً
            if (!file_exists($publicPath)) {
                mkdir($publicPath, 0755, true);
            }
            
            // نقل الملف إلى public/songs/
            $file->move($publicPath, $fileName);
            $filePath = 'songs/' . $fileName;

            // 6. إنشاء الأغنية في قاعدة البيانات
            $song = Song::create([
                'title' => $request->title,
                'artist' => $request->artist,
                'album' => $request->album ?? null,
                'file_path' => $filePath,
                'cover_image' => null,
                'duration' => 0,
            ]);

            // 7. نجاح - العودة للقائمة
            return redirect()->route('songs.index')
                ->with('success', '🎉 تمت إضافة الأغنية "' . $request->title . '" بنجاح!');

        } catch (\Exception $e) {
            // 8. في حالة خطأ
            return redirect()->back()
                ->with('error', 'حدث خطأ: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * حذف أغنية
     */
    public function destroy(Song $song)
    {
        try {
            // حذف الملف من public/songs/
            $filePath = public_path($song->file_path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            // حذف من قاعدة البيانات
            $song->delete();
            
            return redirect()->route('songs.index')
                ->with('success', 'تم حذف الأغنية بنجاح');
                
        } catch (\Exception $e) {
            return redirect()->route('songs.index')
                ->with('error', 'خطأ في الحذف: ' . $e->getMessage());
        }
    }

    /**
     * تشغيل الأغنية (لعرض الملف)
     */
    public function play(Song $song)
    {
        $filePath = public_path($song->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'ملف الصوت غير موجود');
        }
        
        return response()->file($filePath);
    }
}