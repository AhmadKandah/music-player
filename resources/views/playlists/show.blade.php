<!-- resources/views/playlists/show.blade.php -->
@extends('layouts.master')

@section('title', $playlist->name . ' - MelodyMix')

@section('styles')
<style>
    .playlist-header {
        padding: 60px 0 40px;
        background: linear-gradient(135deg, rgba(0, 176, 155, 0.2) 0%, rgba(150, 201, 61, 0.1) 100%);
        border-radius: 0 0 40px 40px;
        margin-bottom: 40px;
    }
    
    .playlist-header-content {
        display: flex;
        align-items: center;
        gap: 30px;
    }
    
    .playlist-cover-large {
        width: 180px;
        height: 180px;
        background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
        border-radius: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: white;
        box-shadow: 0 15px 30px rgba(0, 176, 155, 0.3);
        flex-shrink: 0;
    }
    
    .playlist-header-info {
        flex: 1;
    }
    
    .playlist-header-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: white;
        margin-bottom: 10px;
    }
    
    .playlist-header-meta {
        color: #94a3b8;
        font-size: 1.1rem;
        margin-bottom: 20px;
    }
    
    .playlist-header-actions {
        display: flex;
        gap: 15px;
        margin-top: 25px;
    }
    
    .btn-play-large {
        padding: 15px 35px;
        border-radius: 15px;
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    /* تحسين تصميم قائمة الأغاني */
    .song-list-item {
        display: flex;
        align-items: center;
        padding: 20px;
        margin-bottom: 15px;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
        cursor: pointer;
        gap: 20px;
    }
    
    .song-list-item:hover {
        background: rgba(255, 255, 255, 0.07);
        border-color: rgba(0, 176, 155, 0.3);
        transform: translateX(10px);
        box-shadow: 0 10px 25px rgba(0, 176, 155, 0.15);
    }
    
    .song-number {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
    }
    
    .song-info {
        flex: 1;
        min-width: 0;
    }
    
    .song-list-title {
        font-size: 1.15rem;
        font-weight: 600;
        color: white;
        margin-bottom: 5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .song-list-artist {
        color: #94a3b8;
        font-size: 0.9rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .song-duration {
        color: #94a3b8;
        font-size: 0.9rem;
        margin: 0 15px;
        min-width: 60px;
        text-align: center;
        flex-shrink: 0;
        background: rgba(255, 255, 255, 0.05);
        padding: 6px 12px;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .song-list-actions {
        display: flex;
        gap: 10px;
        flex-shrink: 0;
    }
    
    /* تحسين تصميم أزرار التشغيل */
    .play-song-btn {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
        border: none;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        cursor: pointer;
        font-size: 1.2rem;
    }
    
    .play-song-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 5px 15px rgba(0, 176, 155, 0.4);
    }
    
    .play-song-btn.playing {
        background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
    }
    
    /* زر إزالة من القائمة */
    .remove-from-playlist-btn {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #ef4444;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        cursor: pointer;
        font-size: 1.1rem;
    }
    
    .remove-from-playlist-btn:hover {
        background: rgba(239, 68, 68, 0.2);
        border-color: #ef4444;
        transform: scale(1.05);
    }
    
    .add-song-section {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 40px;
    }
    
    .section-title {
        color: #00b09b;
        margin-bottom: 25px;
        font-weight: 600;
        font-size: 1.3rem;
    }
    
    .empty-playlist {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-playlist-icon {
        font-size: 4rem;
        background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 20px;
    }
    
    @media (max-width: 768px) {
        .playlist-header-content {
            flex-direction: column;
            text-align: center;
        }
        
        .playlist-cover-large {
            width: 150px;
            height: 150px;
            font-size: 3rem;
        }
        
        .playlist-header-title {
            font-size: 2rem;
        }
        
        .playlist-header-actions {
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .song-list-item {
            flex-wrap: wrap;
            gap: 15px;
            padding: 15px;
        }
        
        .song-info {
            flex: 1 1 100%;
            order: 2;
            margin-top: 10px;
        }
        
        .song-duration {
            order: 3;
            margin: 0;
        }
        
        .song-list-actions {
            order: 4;
            width: 100%;
            justify-content: center;
            margin-top: 15px;
        }
        
        .song-number {
            order: 1;
        }
    }
</style>
@endsection

@section('content')
<!-- Playlist Header -->
<div class="playlist-header">
    <div class="container">
        <div class="playlist-header-content fade-in">
            <div class="playlist-cover-large">
                <i class="fas fa-list-music"></i>
            </div>
            
            <div class="playlist-header-info">
                <h1 class="playlist-header-title">{{ $playlist->name }}</h1>
                
                @if($playlist->description)
                <p class="playlist-header-meta">{{ $playlist->description }}</p>
                @endif
                
                <div class="playlist-header-meta">
                    <i class="fas fa-music me-1"></i>
                    {{ $playlist->songs->count() }} أغنية
                    <span class="mx-2">•</span>
                    <i class="fas fa-clock me-1"></i>
                    @php
                        $totalDuration = $playlist->songs->sum('duration');
                        $minutes = floor($totalDuration / 60);
                        $seconds = $totalDuration % 60;
                        echo $minutes . ' دقيقة';
                        if ($seconds > 0) echo ' و' . $seconds . ' ثانية';
                    @endphp
                </div>
                
                <div class="playlist-header-actions">
                    <button class="btn btn-success btn-play-large" onclick="playPlaylistAll()">
                        <i class="fas fa-play me-2"></i>تشغيل القائمة
                    </button>
                    <button class="btn btn-outline-light" onclick="shufflePlaylist()">
                        <i class="fas fa-random me-2"></i>عشوائي
                    </button>
                    <a href="{{ route('playlists.index') }}" class="btn btn-outline-light">
                        <i class="fas fa-arrow-right me-2"></i>العودة
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Song Section -->
<div class="container mb-5">
    <div class="add-song-section fade-in">
        <h3 class="section-title"><i class="fas fa-plus-circle me-2"></i>إضافة أغنية للقائمة</h3>
        
        <!-- Messages -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 15px;">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 15px;">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        
        <form action="{{ route('playlists.add-song', $playlist) }}" method="POST" id="addSongForm">
            @csrf
            <div class="row">
                <div class="col-md-8 mb-3">
                    <select name="song_id" class="form-select" required id="songSelect">
                        <option value="">اختر أغنية من المكتبة...</option>
                        @foreach($allSongs as $song)
                            @if(!$playlist->songs->contains($song->id))
                            <option value="{{ $song->id }}">
                                {{ $song->title }} - {{ $song->artist }}
                                @if($song->album)
                                    ({{ $song->album }})
                                @endif
                            </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <button type="submit" class="btn btn-success w-100" id="addSongBtn">
                        <i class="fas fa-plus me-2"></i>إضافة للقائمة
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Songs List -->
<div class="container">
    <h3 class="section-title mb-4"><i class="fas fa-music me-2"></i>أغاني القائمة</h3>
    
    @if($playlist->songs->count() > 0)
    <div class="song-list" id="playlistSongs">
        @foreach($playlist->songs as $index => $song)
        <div class="glass-card song-list-item fade-in" 
             data-song-id="{{ $song->id }}"
             data-song-title="{{ $song->title }}"
             data-song-artist="{{ $song->artist }}"
             data-song-url="{{ asset($song->file_path) }}"
             data-song-duration="{{ $song->duration }}"
             data-song-index="{{ $index }}">
            <div class="song-number">{{ $index + 1 }}</div>
            
            <div class="song-info">
                <div class="song-list-title">{{ $song->title }}</div>
                <div class="song-list-artist">{{ $song->artist }}</div>
            </div>
            
            <div class="song-duration">
                @if($song->duration)
                    @php
                        $minutes = floor($song->duration / 60);
                        $seconds = $song->duration % 60;
                        echo sprintf('%02d:%02d', $minutes, $seconds);
                    @endphp
                @else
                    0:00
                @endif
            </div>
            
            <div class="song-list-actions">
                <button class="play-song-btn" onclick="playThisSong(this)" title="تشغيل">
                    <i class="fas fa-play"></i>
                </button>
                
                <form action="{{ route('playlists.remove-song', [$playlist, $song]) }}" 
                      method="POST" 
                      class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="remove-from-playlist-btn" 
                            onclick="event.stopPropagation(); return confirm('هل تريد إزالة الأغنية \"{{ $song->title }}\" من القائمة؟')"
                            title="إزالة من القائمة">
                        <i class="fas fa-times"></i>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="glass-card empty-playlist fade-in">
        <div class="empty-playlist-icon">
            <i class="fas fa-music"></i>
        </div>
        <h3 class="h4 mb-3">القائمة فارغة</h3>
        <p class="text-muted mb-4">أضف بعض الأغاني لتبدأ الاستماع</p>
    </div>
    @endif
</div>

<!-- Hidden Audio Element for Playlist -->
<audio id="playlistAudioPlayer"></audio>
@endsection

@section('scripts')
<script>
// Global variables
let currentAudio = document.getElementById('playlistAudioPlayer');
let currentPlayingBtn = null;

// Play a specific song from playlist
function playThisSong(buttonElement) {
    const songElement = buttonElement.closest('.song-list-item');
    if (!songElement) return;
    
    const songTitle = songElement.dataset.songTitle;
    const songArtist = songElement.dataset.songArtist;
    const songUrl = songElement.dataset.songUrl;
    
    // Reset previous playing button
    if (currentPlayingBtn && currentPlayingBtn !== buttonElement) {
        resetPlayButton(currentPlayingBtn);
    }
    
    // If clicking the same song that's currently playing
    if (currentPlayingBtn === buttonElement) {
        if (currentAudio.paused) {
            // Resume playback
            currentAudio.play();
            buttonElement.classList.add('playing');
            buttonElement.querySelector('i').className = 'fas fa-pause';
            buttonElement.title = 'إيقاف';
            showNotification(`▶️ استئناف التشغيل: ${songTitle}`, 'info');
        } else {
            // Pause playback
            currentAudio.pause();
            buttonElement.classList.remove('playing');
            buttonElement.querySelector('i').className = 'fas fa-play';
            buttonElement.title = 'تشغيل';
            showNotification(`⏸️ إيقاف مؤقت: ${songTitle}`, 'info');
        }
    } else {
        // Play new song
        currentAudio.src = songUrl;
        currentAudio.play().then(() => {
            // Update button state
            buttonElement.classList.add('playing');
            buttonElement.querySelector('i').className = 'fas fa-pause';
            buttonElement.title = 'إيقاف';
            currentPlayingBtn = buttonElement;
            
            // Add event listener for when song ends
            currentAudio.onended = function() {
                resetPlayButton(buttonElement);
                currentPlayingBtn = null;
            };
            
            showNotification(`▶️ تشغيل: ${songTitle} - ${songArtist}`, 'success');
        }).catch(error => {
            console.error('Playback error:', error);
            showNotification('❌ تعذر تشغيل الملف', 'error');
        });
    }
}

// Reset play button to default state
function resetPlayButton(buttonElement) {
    if (buttonElement) {
        buttonElement.classList.remove('playing');
        buttonElement.querySelector('i').className = 'fas fa-play';
        buttonElement.title = 'تشغيل';
    }
}

// Play all songs in playlist
function playPlaylistAll() {
    const songs = document.querySelectorAll('.song-list-item');
    if (songs.length === 0) {
        showNotification('❌ القائمة فارغة', 'error');
        return;
    }
    
    // Play first song
    const firstPlayBtn = songs[0].querySelector('.play-song-btn');
    if (firstPlayBtn) {
        playThisSong(firstPlayBtn);
    }
}

// Shuffle playlist (just for UI - doesn't actually reorder)
function shufflePlaylist() {
    const songs = document.querySelectorAll('.song-list-item');
    if (songs.length === 0) {
        showNotification('❌ القائمة فارغة', 'error');
        return;
    }
    
    showNotification('🔀 تم تفعيل وضع التشغيل العشوائي', 'info');
}

// Form submission for adding song to playlist
const addSongForm = document.getElementById('addSongForm');
if (addSongForm) {
    addSongForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const formData = new FormData(form);
        const submitBtn = document.getElementById('addSongBtn');
        const originalText = submitBtn.innerHTML;
        
        // Validation
        const songSelect = document.getElementById('songSelect');
        if (!songSelect.value) {
            showNotification('❌ يرجى اختيار أغنية', 'error');
            return;
        }
        
        // Show loading
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>جاري الإضافة...';
        submitBtn.disabled = true;
        
        // Send AJAX request
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(async response => {
            const contentType = response.headers.get('content-type');
            
            // Check if response is JSON
            if (contentType && contentType.includes('application/json')) {
                const data = await response.json();
                
                if (!response.ok) {
                    // Handle validation errors
                    if (data.errors) {
                        const errorMessages = Object.values(data.errors).flat().join(', ');
                        throw new Error(errorMessages);
                    }
                    throw new Error(data.message || 'حدث خطأ في إضافة الأغنية');
                }
                
                return data;
            } else {
                // If not JSON, it might be a redirect or HTML response
                if (response.ok) {
                    // Success - reload page
                    window.location.reload();
                    return;
                }
                throw new Error('استجابة غير متوقعة من الخادم');
            }
        })
        .then(data => {
            if (data && data.success) {
                showNotification('✅ ' + data.message, 'success');
                // Reset form
                form.reset();
                // Reload page after 1.5 seconds
                setTimeout(() => window.location.reload(), 1500);
            } else if (data && !data.success) {
                showNotification('❌ ' + (data.message || 'حدث خطأ'), 'error');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('❌ ' + (error.message || 'حدث خطأ في الاتصال'), 'error');
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });
}

// Click on song item to play
document.querySelectorAll('.song-list-item').forEach(item => {
    item.addEventListener('click', function(e) {
        // Only trigger if not clicking on buttons or forms
        if (!e.target.closest('button') && !e.target.closest('form')) {
            const playBtn = this.querySelector('.play-song-btn');
            if (playBtn) {
                playThisSong(playBtn);
            }
        }
    });
});

// Show notification
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existing = document.querySelectorAll('.custom-notification');
    existing.forEach(el => el.remove());
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'custom-notification';
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        background: ${type === 'success' ? 'rgba(16, 185, 129, 0.1)' : type === 'error' ? 'rgba(239, 68, 68, 0.1)' : 'rgba(59, 130, 246, 0.1)'};
        border: 1px solid ${type === 'success' ? 'rgba(16, 185, 129, 0.3)' : type === 'error' ? 'rgba(239, 68, 68, 0.3)' : 'rgba(59, 130, 246, 0.3)'};
        border-radius: 15px;
        color: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
        z-index: 9999;
        animation: fadeIn 0.3s ease-out;
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        max-width: 400px;
        display: flex;
        align-items: center;
        gap: 10px;
    `;
    
    const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
    notification.innerHTML = `<i class="fas ${icon}"></i><span>${message}</span>`;
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'fadeOut 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add fadeOut animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-20px); }
    }
`;
document.head.appendChild(style);

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    console.log('🎵 Playlist page loaded');
});
</script>
@endsection