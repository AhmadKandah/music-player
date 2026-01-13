
<!-- resources/views/playlists/index.blade.php -->
@extends('layouts.master')

@section('title', 'قوائم التشغيل - MelodyMix')

@section('styles')
<style>
    .hero-section {
        padding: 80px 0 40px;
        text-align: center;
        background: linear-gradient(135deg, rgba(0, 176, 155, 0.1) 0%, rgba(150, 201, 61, 0.05) 100%);
        border-radius: 0 0 40px 40px;
        margin-bottom: 40px;
    }
    
    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
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
    
    .playlist-card {
        position: relative;
        overflow: hidden;
        padding: 30px;
        margin-bottom: 30px;
        height: 100%;
        transition: all 0.4s ease;
        cursor: pointer;
    }
    
    .playlist-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 176, 155, 0.2);
    }
    
    .playlist-cover {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        font-size: 2.5rem;
        color: white;
        box-shadow: 0 10px 20px rgba(0, 176, 155, 0.3);
    }
    
    .playlist-info {
        text-align: center;
    }
    
    .playlist-title {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: white;
        line-height: 1.3;
    }
    
    .playlist-description {
        color: #94a3b8;
        font-size: 0.95rem;
        margin-bottom: 20px;
        min-height: 40px;
    }
    
    .playlist-stats {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 25px;
    }
    
    .stat-item {
        text-align: center;
    }
    
    .stat-number {
        font-size: 1.8rem;
        font-weight: 800;
        background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 1;
    }
    
    .stat-label {
        color: #94a3b8;
        font-size: 0.85rem;
        margin-top: 5px;
    }
    
    .playlist-actions {
        display: flex;
        justify-content: center;
        gap: 10px;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
    }
    
    .playlist-card:hover .playlist-actions {
        opacity: 1;
        transform: translateY(0);
    }
    
    .action-btn {
        width: 45px;
        height: 45px;
        border-radius: 12px;
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
        background: rgba(0, 176, 155, 0.2);
        border-color: #00b09b;
        transform: scale(1.1);
    }
    
    .empty-state {
        text-align: center;
        padding: 80px 20px;
    }
    
    .empty-icon {
        font-size: 5rem;
        background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 20px;
    }
    
    .create-form {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 40px;
    }
    
    .form-title {
        color: #00b09b;
        margin-bottom: 20px;
        font-weight: 600;
    }
    
    .form-control, .form-select {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
        border-radius: 12px;
        padding: 12px 15px;
        transition: all 0.3s;
    }
    
    .form-control:focus, .form-select:focus {
        background: rgba(255, 255, 255, 0.08);
        border-color: #00b09b;
        color: white;
        box-shadow: 0 0 0 3px rgba(0, 176, 155, 0.1);
    }
    
    .form-control::placeholder {
        color: #94a3b8;
    }
    
    .btn-success {
        background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
        border: none;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 176, 155, 0.3);
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <h1 class="hero-title fade-in">قوائم تشغيلك المفضلة</h1>
        <p class="hero-subtitle fade-in">أنشئ قوائم تشغيل خاصة بك، رتب أغانيك المفضلة، واستمتع بتجربة موسيقية شخصية</p>
    </div>
</section>

<!-- Create Playlist Form -->
<div class="container mb-5">
    <div class="create-form fade-in">
        <h3 class="form-title"><i class="fas fa-plus-circle me-2"></i>إنشاء قائمة تشغيل جديدة</h3>
        <form action="{{ route('playlists.store') }}" method="POST" id="createPlaylistForm">
            @csrf
            <div class="row">
                <div class="col-md-5 mb-3">
                    <input type="text" name="name" class="form-control" 
                           placeholder="اسم قائمة التشغيل *" required
                           value="{{ old('name') }}">
                    @error('name')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-5 mb-3">
                    <input type="text" name="description" class="form-control" 
                           placeholder="وصف قصير (اختياري)"
                           value="{{ old('description') }}">
                </div>
                <div class="col-md-2 mb-3">
                    <button type="submit" class="btn btn-success w-100" id="createBtn">
                        <i class="fas fa-save me-1"></i>إنشاء
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Playlists Grid -->
<div class="container">
    <!-- رسائل النجاح/الخطأ -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($playlists->count() > 0)
    <div class="row">
        @foreach($playlists as $playlist)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="glass-card playlist-card fade-in" 
                 onclick="window.location.href= '{{ route('playlists.show', $playlist) }}'">
                <div class="playlist-cover">
                    <i class="fas fa-list-music"></i>
                </div>
                
                <div class="playlist-info">
                    <h3 class="playlist-title">{{ $playlist->name }}</h3>
                    
                    @if($playlist->description)
                    <p class="playlist-description">{{ $playlist->description }}</p>
                    @else
                    <p class="playlist-description text-muted">لا يوجد وصف</p>
                    @endif
                    
                    <div class="playlist-stats">
                        <div class="stat-item">
                            <div class="stat-number">{{ $playlist->songs_count ?? 0 }}</div>
                            <div class="stat-label">أغنية</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">
                                @php
                                    $duration = $playlist->songs->sum('duration') ?? 0;
                                    echo floor($duration / 60);
                                @endphp
                            </div>
                            <div class="stat-label">دقيقة</div>
                        </div>
                    </div>
                </div>
                
                <div class="playlist-actions">
                    <button class="action-btn" 
                            onclick="event.stopPropagation(); window.location.href='{{ route('playlists.show', $playlist) }}'"
                            title="فتح القائمة">
                        <i class="fas fa-play"></i>
                    </button>
                    
                    <form action="{{ route('playlists.destroy', $playlist) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn" 
                                onclick="event.stopPropagation(); return confirm('هل تريد حذف قائمة التشغيل \ "{{ $playlist->name }}\"؟')"
                                title="حذف القائمة">
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
            <i class="fas fa-list-music"></i>
        </div>
        <h3 class="h4 mb-3">لا توجد قوائم تشغيل حالياً</h3>
        <p class="text-muted mb-4">أنشئ أول قائمة تشغيل لتجمع فيها أغانيك المفضلة</p>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
// Form submission for creating playlist
document.getElementById('createPlaylistForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const formData = new FormData(form);
    const submitBtn = document.getElementById('createBtn');
    const originalText = submitBtn.innerHTML;
    
    // Show loading
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>جاري الإنشاء...';
    submitBtn.disabled = true;
    
    // Send request
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
                throw new Error(data.message || 'حدث خطأ في إنشاء القائمة');
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
            showNotification('✅ ' + data.message);
            // Reset form
            form.reset();
            // Reload page after 1.5 seconds
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else if (data && !data.success) {
            showNotification('❌ ' + (data.message || 'حدث خطأ'));
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('❌ ' + (error.message || 'حدث خطأ في الاتصال. جرب مرة أخرى.'));
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}); 


// Show notification
function showNotification(message) {
    // Remove existing notifications
    const existing = document.querySelectorAll('.custom-notification');
    existing.forEach(el => el.remove());
    
    // Create new notification
    const notification = document.createElement('div');
    notification.className = 'custom-notification';
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        background: rgba(30, 27, 75, 0.95);
        border: 1px solid rgba(0, 176, 155, 0.3);
        border-radius: 15px;
        color: white;
        z-index: 9999;
        animation: fadeIn 0.3s ease-out;
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        max-width: 400px;
    `;
    notification.innerHTML = `
        <div style="display: flex; align-items: center; gap: 10px;">
            ${message.includes('✅') ? '<i class="fas fa-check-circle" style="color: #00b09b;"></i>' : 
              message.includes('❌') ? '<i class="fas fa-exclamation-circle" style="color: #ef4444;"></i>' : 
              '<i class="fas fa-info-circle" style="color: #8b5cf6;"></i>'}
            <span>${message}</span>
        </div>
    `;
    
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
        from { opacity: 0; transform: translateY(-20px) translateX(20px); }
        to { opacity: 1; transform: translateY(0) translateX(0); }
    }
    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0) translateX(0); }
        to { opacity: 0; transform: translateY(-20px) translateX(20px); }
    }
`;
document.head.appendChild(style);

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    console.log('🎵 Playlists page ready');
});
</script>
@endsection