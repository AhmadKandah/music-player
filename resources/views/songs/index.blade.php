<!-- resources/views/songs/index.blade.php -->
@extends('layouts.master')

@section('title', 'الأناشيد - MelodyMix')

@section('styles')
<style>
    .hero-section {
        padding: 80px 0 40px;
        text-align: center;
        background: linear-gradient(135deg, rgba(109, 40, 217, 0.1) 0%, rgba(139, 92, 246, 0.05) 100%);
        border-radius: 0 0 40px 40px;
        margin-bottom: 40px;
    }
    
    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #fff 0%, #c4b5fd 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 20px;
    }
    
    .hero-subtitle {
        color: #cbd5e1;
        font-size: 1.2rem;
        max-width: 600px;
        margin: 0 auto 30px;
    }
    
    .song-card {
        position: relative;
        overflow: hidden;
        padding: 25px;
        margin-bottom: 25px;
        height: 100%;
    }
    
    .song-cover {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #6d28d9 0%, #8b5cf6 100%);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 2rem;
        color: white;
    }
    
    .song-info {
        flex: 1;
    }
    
    .song-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 5px;
        color: white;
    }
    
    .song-artist {
        color: #94a3b8;
        font-size: 0.95rem;
        margin-bottom: 15px;
    }
    
    .song-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }
    
    .play-btn {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6d28d9 0%, #8b5cf6 100%);
        border: none;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .play-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 5px 15px rgba(109, 40, 217, 0.4);
    }
    
    .action-btn {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .action-btn:hover {
        background: rgba(109, 40, 217, 0.2);
        border-color: #6d28d9;
    }
    
    .empty-state {
        text-align: center;
        padding: 80px 20px;
    }
    
    .empty-icon {
        font-size: 5rem;
        background: linear-gradient(135deg, #6d28d9 0%, #8b5cf6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 20px;
    }
    
    .stats-card {
        padding: 25px;
        text-align: center;
        margin-bottom: 25px;
    }
    
    .stat-number {
        font-size: 3rem;
        font-weight: 800;
        background: linear-gradient(135deg, #6d28d9 0%, #8b5cf6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 1;
    }
    
    .stat-label {
        color: #94a3b8;
        font-size: 1rem;
        margin-top: 10px;
    }
    
    /* Music Player Styles */
    .music-player-container {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(30, 27, 75, 0.95);
        backdrop-filter: blur(20px);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        z-index: 1000;
        padding: 15px 0;
    }
    
    .progress {
        height: 5px;
        background: rgba(255, 255, 255, 0.1);
        cursor: pointer;
    }
    
    .progress-bar {
        background: linear-gradient(135deg, #6d28d9 0%, #8b5cf6 100%);
        transition: width 0.1s linear;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <h1 class="hero-title fade-in">اكتشف عالم الموسيقى</h1>
        <p class="hero-subtitle fade-in">استمع إلى أجمل الأغاني، أنشئ قوائمك المفضلة، واستمتع بتجربة موسيقية فريدة</p>
        
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="{{ route('songs.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i>إضافة أغنية جديدة
            </a>
            <a href="{{ route('playlists.index') }}" class="btn btn-outline-light btn-lg">
                <i class="fas fa-list-music me-2"></i>تصفح القوائم
            </a>
        </div>
    </div>
</section>

<!-- Stats -->
<div class="container mb-5">
    <div class="row">
        <div class="col-md-4">
            <div class="glass-card stats-card fade-in">
                <div class="stat-number">{{ $songs->count() }}</div>
                <div class="stat-label">أغنية</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass-card stats-card fade-in">
                <div class="stat-number">{{ $playlistsCount ?? 0 }}</div>
                <div class="stat-label">قائمة تشغيل</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass-card stats-card fade-in">
                <div class="stat-number">{{ floor($totalDuration ?? 0) }}</div>
                <div class="stat-label">دقيقة موسيقى</div>
            </div>
        </div>
    </div>
</div>

<!-- Songs Grid -->
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3">كل الأغاني</h2>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-light" onclick="shuffleAll()">
                <i class="fas fa-random me-1"></i>عشوائي
            </button>
            <button class="btn btn-outline-light" onclick="playAll()">
                <i class="fas fa-play me-1"></i>تشغيل الكل
            </button>
        </div>
    </div>
    
    @if($songs->count() > 0)
    <div class="row">
        @foreach($songs as $song)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="glass-card song-card fade-in" 
                 data-song-id="{{ $song->id }}"
                 data-song-title="{{ $song->title }}"
                 data-song-artist="{{ $song->artist }}"
                 data-song-url="{{ asset($song->file_path) }}"
                 data-song-duration="{{ $song->duration ?? 0 }}">
                <div class="song-cover">
                    <i class="fas fa-music"></i>
                </div>
                
                <div class="song-info">
                    <h3 class="song-title">{{ $song->title }}</h3>
                    <p class="song-artist">{{ $song->artist }}</p>
                    
                    @if($song->album)
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-compact-disc me-2" style="color: #8b5cf6;"></i>
                        <small class="text-muted">{{ $song->album }}</small>
                    </div>
                    @endif
                    
                    @if($song->duration)
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-clock me-2" style="color: #8b5cf6;"></i>
                        <small class="text-muted">
                            @php
                                $minutes = floor($song->duration / 60);
                                $seconds = $song->duration % 60;
                                echo sprintf('%02d:%02d', $minutes, $seconds);
                            @endphp
                        </small>
                    </div>
                    @endif
                </div>
                
                <div class="song-actions">
                    <button class="play-btn" onclick="playSong(this)">
                        <i class="fas fa-play"></i>
                    </button>
                    
                    <button class="action-btn" onclick="addToQueue(this)" title="إضافة للطابور">
                        <i class="fas fa-plus"></i>
                    </button>
                    
                    <form action="{{ route('songs.destroy', $song) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn" onclick="return confirm('هل تريد حذف هذه الأغنية؟')" title="حذف">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="glass-card empty-state fade-in">
        <div class="empty-icon">
            <i class="fas fa-music"></i>
        </div>
        <h3 class="h4 mb-3">لا توجد أغاني حالياً</h3>
        <p class="text-muted mb-4">ابدأ بإضافة أول أغنية لمكتبتك الموسيقية</p>
        <a href="{{ route('songs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>إضافة أول أغنية
        </a>
    </div>
    @endif
</div>

<!-- Hidden data for JavaScript -->
<div id="songsData" style="display: none;">
    @foreach($songs as $song)
    <div class="song-data"
         data-id="{{ $song->id }}"
         data-title="{{ $song->title }}"
         data-artist="{{ $song->artist }}"
         data-url="{{ asset($song->file_path) }}"
         data-duration="{{ $song->duration ?? 0 }}">
    </div>
    @endforeach
</div>

<!-- Global Music Player -->
<div class="music-player-container" id="musicPlayer" style="display: none;">
    <div class="container">
        <div class="row align-items-center">
            <!-- Song Info -->
            <div class="col-md-3">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <div class="song-cover" style="width: 50px; height: 50px;">
                            <i class="fas fa-music"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="mb-0" id="currentSongTitle">...</h6>
                        <small class="text-muted" id="currentSongArtist">...</small>
                    </div>
                </div>
            </div>
            
            <!-- Controls -->
            <div class="col-md-6">
                <div class="text-center">
                    <!-- Progress Bar -->
                    <div class="d-flex align-items-center mb-2">
                        <small class="text-muted me-2" id="currentTime">0:00</small>
                        <div class="progress flex-grow-1" style="cursor: pointer;" onclick="seekAudio(event)">
                            <div class="progress-bar" id="progressBar" style="width: 0%;"></div>
                        </div>
                        <small class="text-muted ms-2" id="totalDuration">0:00</small>
                    </div>
                    
                    <!-- Control Buttons -->
                    <div class="d-flex justify-content-center align-items-center gap-3">
                        <button class="action-btn" onclick="toggleRepeat()" id="repeatBtn" title="تكرار">
                            <i class="fas fa-redo"></i>
                        </button>
                        
                        <button class="action-btn" onclick="prevSong()" title="السابق">
                            <i class="fas fa-step-backward"></i>
                        </button>
                        
                        <button class="play-btn" style="width: 60px; height: 60px;" onclick="togglePlay()" id="playPauseBtn">
                            <i class="fas fa-play" id="playIcon"></i>
                        </button>
                        
                        <button class="action-btn" onclick="nextSong()" title="التالي">
                            <i class="fas fa-step-forward"></i>
                        </button>
                        
                        <button class="action-btn" onclick="toggleShuffle()" id="shuffleBtn" title="عشوائي">
                            <i class="fas fa-random"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Volume -->
            <div class="col-md-3">
                <div class="d-flex align-items-center justify-content-end">
                    <i class="fas fa-volume-up me-2 text-muted"></i>
                    <input type="range" class="form-range" id="volumeControl" min="0" max="1" step="0.1" value="0.8" 
                           style="width: 100px;" onchange="changeVolume(this.value)">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Audio Element -->
<audio id="audioPlayer" ontimeupdate="updateProgress()" onended="handleSongEnd()"></audio>
@endsection

@section('scripts')
<script>
// ============================================
// GLOBAL VARIABLES AND ELEMENTS
// ============================================
const audioPlayer = document.getElementById('audioPlayer');
const musicPlayer = document.getElementById('musicPlayer');
const progressBar = document.getElementById('progressBar');
const currentTimeEl = document.getElementById('currentTime');
const totalDurationEl = document.getElementById('totalDuration');
const currentSongTitle = document.getElementById('currentSongTitle');
const currentSongArtist = document.getElementById('currentSongArtist');
const playPauseBtn = document.getElementById('playPauseBtn');
const playIcon = document.getElementById('playIcon');
const repeatBtn = document.getElementById('repeatBtn');
const shuffleBtn = document.getElementById('shuffleBtn');
const volumeControl = document.getElementById('volumeControl');

// Player state
let currentQueue = [];
let currentIndex = -1;
let repeatMode = 'none'; // 'none', 'one', 'all'
let isShuffle = false;
let originalQueue = [];

// ============================================
// INITIALIZATION
// ============================================
function initPlayer() {
    console.log('🎵 Initializing music player...');
    
    // Set initial volume
    audioPlayer.volume = volumeControl.value;
    
    // Load all songs into queue
    loadAllSongs();
    
    console.log('✅ Player initialized with', currentQueue.length, 'songs');
}

function loadAllSongs() {
    currentQueue = [];
    
    // Get all song data from hidden div
    const songElements = document.querySelectorAll('.song-data');
    
    songElements.forEach(element => {
        currentQueue.push({
            id: element.dataset.id,
            title: element.dataset.title,
            artist: element.dataset.artist,
            url: element.dataset.url,
            duration: parseInt(element.dataset.duration) || 0
        });
    });
    
    originalQueue = [...currentQueue];
}

// ============================================
// PLAYER CONTROLS
// ============================================
function playSong(buttonElement) {
    const songCard = buttonElement.closest('.song-card');
    
    if (!songCard) {
        console.error('❌ Could not find song card');
        return;
    }
    
    const songId = songCard.dataset.songId;
    const songTitle = songCard.dataset.songTitle;
    const songArtist = songCard.dataset.songArtist;
    const songUrl = songCard.dataset.songUrl;
    const songDuration = parseInt(songCard.dataset.songDuration) || 0;
    
    // Find song in queue
    let songIndex = currentQueue.findIndex(song => song.id == songId);
    
    if (songIndex === -1) {
        // Add to queue
        const newSong = {
            id: songId,
            title: songTitle,
            artist: songArtist,
            url: songUrl,
            duration: songDuration
        };
        
        currentQueue.push(newSong);
        songIndex = currentQueue.length - 1;
    }
    
    // Play the song
    currentIndex = songIndex;
    loadAndPlaySong();
    
    // Show notification
    showNotification(`▶️ تشغيل: ${songTitle}`);
}

function loadAndPlaySong() {
    if (currentIndex < 0 || currentIndex >= currentQueue.length) {
        console.error('❌ No song to play');
        return;
    }
    
    const song = currentQueue[currentIndex];
    
    console.log('🎶 Playing:', song.title);
    
    // Update UI
    currentSongTitle.textContent = song.title;
    currentSongArtist.textContent = song.artist;
    
    // Set audio source
    audioPlayer.src = song.url;
    
    // Show player
    musicPlayer.style.display = 'block';
    
    // Play audio
    const playPromise = audioPlayer.play();
    
    if (playPromise !== undefined) {
        playPromise.then(() => {
            playIcon.className = 'fas fa-pause';
        }).catch(error => {
            console.error('❌ Playback error:', error);
            showNotification('⚠️ تعذر تشغيل الملف. تأكد من صحة ملف الصوت.');
        });
    }
    
    // Update duration
    audioPlayer.onloadedmetadata = function() {
        if (audioPlayer.duration && !isNaN(audioPlayer.duration)) {
            const duration = audioPlayer.duration;
            const minutes = Math.floor(duration / 60);
            const seconds = Math.floor(duration % 60);
            totalDurationEl.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        }
    };
}

function togglePlay() {
    if (!audioPlayer.src) {
        // If no song is loaded, play first song
        if (currentQueue.length > 0) {
            currentIndex = 0;
            loadAndPlaySong();
        }
        return;
    }
    
    if (audioPlayer.paused) {
        audioPlayer.play();
        playIcon.className = 'fas fa-pause';
    } else {
        audioPlayer.pause();
        playIcon.className = 'fas fa-play';
    }
}

function nextSong() {
    if (currentQueue.length === 0) return;
    
    if (isShuffle) {
        // Random next song
        currentIndex = Math.floor(Math.random() * currentQueue.length);
    } else {
        // Normal next song
        currentIndex = (currentIndex + 1) % currentQueue.length;
    }
    
    loadAndPlaySong();
    showNotification('⏭️ التالي: ' + currentQueue[currentIndex].title);
}

function prevSong() {
    if (currentQueue.length === 0) return;
    
    if (audioPlayer.currentTime > 3) {
        // If more than 3 seconds played, restart current song
        audioPlayer.currentTime = 0;
        showNotification('🔄 إعادة التشغيل');
    } else {
        // Go to previous song
        currentIndex = currentIndex - 1;
        if (currentIndex < 0) currentIndex = currentQueue.length - 1;
        loadAndPlaySong();
        showNotification('⏮️ السابق: ' + currentQueue[currentIndex].title);
    }
}

// ============================================
// REPEAT & SHUFFLE
// ============================================
function toggleRepeat() {
    const modes = ['none', 'one', 'all'];
    const currentModeIndex = modes.indexOf(repeatMode);
    repeatMode = modes[(currentModeIndex + 1) % modes.length];
    
    // Update button appearance
    repeatBtn.style.color = repeatMode === 'none' ? 'white' : '#8b5cf6';
    repeatBtn.title = repeatMode === 'none' ? 'تكرار: لا' : 
                     repeatMode === 'one' ? 'تكرار: أغنية واحدة' : 
                     'تكرار: كل القائمة';
    
    showNotification(`🔁 وضع التكرار: ${repeatMode === 'none' ? 'غير مفعل' : repeatMode === 'one' ? 'أغنية واحدة' : 'كل القائمة'}`);
}

function toggleShuffle() {
    isShuffle = !isShuffle;
    
    if (isShuffle) {
        // Shuffle the queue
        shuffleArray(currentQueue);
        shuffleBtn.style.color = '#8b5cf6';
        shuffleBtn.title = 'عشوائي: مفعل';
        showNotification('🔀 التشغيل العشوائي مفعل');
    } else {
        // Restore original order
        currentQueue = [...originalQueue];
        shuffleBtn.style.color = 'white';
        shuffleBtn.title = 'عشوائي: غير مفعل';
        showNotification('🔀 التشغيل العشوائي غير مفعل');
    }
}

// ============================================
// PROGRESS & VOLUME
// ============================================
function updateProgress() {
    if (!audioPlayer.duration || isNaN(audioPlayer.duration)) return;
    
    const progress = (audioPlayer.currentTime / audioPlayer.duration) * 100;
    progressBar.style.width = `${progress}%`;
    
    // Update current time
    const currentMinutes = Math.floor(audioPlayer.currentTime / 60);
    const currentSeconds = Math.floor(audioPlayer.currentTime % 60);
    currentTimeEl.textContent = `${currentMinutes}:${currentSeconds.toString().padStart(2, '0')}`;
}

function seekAudio(event) {
    if (!audioPlayer.duration || isNaN(audioPlayer.duration)) return;
    
    const progressBar = event.currentTarget;
    const clickPosition = event.offsetX;
    const totalWidth = progressBar.clientWidth;
    const percentage = clickPosition / totalWidth;
    
    audioPlayer.currentTime = percentage * audioPlayer.duration;
}

function changeVolume(volume) {
    audioPlayer.volume = volume;
    
    // Update volume icon
    const volumeIcon = document.querySelector('.fa-volume-up');
    if (volume == 0) {
        volumeIcon.className = 'fas fa-volume-mute';
    } else if (volume < 0.5) {
        volumeIcon.className = 'fas fa-volume-down';
    } else {
        volumeIcon.className = 'fas fa-volume-up';
    }
}

// ============================================
// QUEUE MANAGEMENT
// ============================================
function addToQueue(buttonElement) {
    const songCard = buttonElement.closest('.song-card');
    
    if (!songCard) return;
    
    const songId = songCard.dataset.songId;
    const songTitle = songCard.dataset.songTitle;
    const songArtist = songCard.dataset.songArtist;
    const songUrl = songCard.dataset.songUrl;
    const songDuration = parseInt(songCard.dataset.songDuration) || 0;
    
    // Check if already in queue
    const exists = currentQueue.some(song => song.id == songId);
    
    if (!exists) {
        currentQueue.push({
            id: songId,
            title: songTitle,
            artist: songArtist,
            url: songUrl,
            duration: songDuration
        });
        
        showNotification(`➕ تمت إضافة "${songTitle}" إلى قائمة التشغيل`);
    } else {
        showNotification(`⚠️ "${songTitle}" موجودة بالفعل في القائمة`);
    }
}

function playAll() {
    if (currentQueue.length === 0) {
        showNotification('❌ لا توجد أغاني للتشغيل');
        return;
    }
    
    currentIndex = 0;
    loadAndPlaySong();
    showNotification('▶️ تشغيل كل الأغاني');
}

function shuffleAll() {
    if (currentQueue.length === 0) {
        showNotification('❌ لا توجد أغاني للتشغيل');
        return;
    }
    
    // Enable shuffle
    isShuffle = true;
    shuffleBtn.style.color = '#8b5cf6';
    shuffleBtn.title = 'عشوائي: مفعل';
    
    // Shuffle and play random song
    shuffleArray(currentQueue);
    currentIndex = 0;
    loadAndPlaySong();
    showNotification('🔀 تشغيل عشوائي لجميع الأغاني');
}

// ============================================
// EVENT HANDLERS
// ============================================
function handleSongEnd() {
    console.log('🎵 Song ended');
    
    switch(repeatMode) {
        case 'one':
            // Repeat same song
            audioPlayer.currentTime = 0;
            audioPlayer.play();
            break;
            
        case 'all':
            // Go to next or loop to first
            if (currentIndex === currentQueue.length - 1) {
                currentIndex = 0;
            } else {
                currentIndex++;
            }
            loadAndPlaySong();
            break;
            
        case 'none':
        default:
            // Go to next song if available
            if (currentIndex < currentQueue.length - 1) {
                currentIndex++;
                loadAndPlaySong();
            } else {
                // End of queue
                playIcon.className = 'fas fa-play';
                showNotification('⏹️ انتهت قائمة التشغيل');
            }
            break;
    }
}

// ============================================
// UTILITY FUNCTIONS
// ============================================
function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
}

function showNotification(message) {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'notification glass-card';
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        background: rgba(30, 27, 75, 0.95);
        border: 1px solid rgba(109, 40, 217, 0.3);
        border-radius: 15px;
        color: white;
        z-index: 9999;
        animation: fadeIn 0.3s ease-out;
        max-width: 300px;
        backdrop-filter: blur(10px);
    `;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'fadeOut 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// ============================================
// PAGE LOAD INITIALIZATION
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    // Add fadeOut animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-20px); }
        }
    `;
    document.head.appendChild(style);
    
    // Initialize player
    initPlayer();
    
    // Add keyboard shortcuts
    document.addEventListener('keydown', function(event) {
        switch(event.code) {
            case 'Space':
                event.preventDefault();
                togglePlay();
                break;
            case 'ArrowRight':
                if (event.ctrlKey) nextSong();
                break;
            case 'ArrowLeft':
                if (event.ctrlKey) prevSong();
                break;
        }
    });
    
    console.log('🚀 MelodyMix Music Player Ready!');
});
</script>
@endsection