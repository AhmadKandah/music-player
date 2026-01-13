<!-- resources/views/songs/create.blade.php -->
@extends('layouts.master')

@section('title', 'إضافة أغنية جديدة - MelodyMix')

@section('styles')
<style>
    .hero-section {
        padding: 60px 0 40px;
        text-align: center;
        background: linear-gradient(135deg, rgba(109, 40, 217, 0.1) 0%, rgba(139, 92, 246, 0.05) 100%);
        border-radius: 0 0 40px 40px;
        margin-bottom: 40px;
    }
    
    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        background: linear-gradient(135deg, #fff 0%, #c4b5fd 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 15px;
    }
    
    .hero-subtitle {
        color: #cbd5e1;
        font-size: 1.1rem;
        max-width: 500px;
        margin: 0 auto;
    }
    
    .form-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 40px 0;
    }
    
    .form-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 25px;
        padding: 40px;
        transition: all 0.3s ease;
    }
    
    .form-card:hover {
        border-color: rgba(109, 40, 217, 0.3);
        box-shadow: 0 15px 35px rgba(109, 40, 217, 0.2);
    }
    
    .form-header {
        text-align: center;
        margin-bottom: 40px;
    }
    
    .form-header-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #6d28d9 0%, #8b5cf6 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2.5rem;
        color: white;
        box-shadow: 0 10px 20px rgba(109, 40, 217, 0.3);
    }
    
    .form-header h2 {
        color: white;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .form-header p {
        color: #94a3b8;
        font-size: 1rem;
    }
    
    .form-group {
        margin-bottom: 30px;
    }
    
    .form-label {
        display: flex;
        align-items: center;
        gap: 10px;
        color: white;
        font-weight: 600;
        margin-bottom: 12px;
        font-size: 1.05rem;
    }
    
    .form-label i {
        color: #8b5cf6;
        font-size: 1.2rem;
    }
    
    .required-star {
        color: #ef4444;
        margin-right: 5px;
    }
    
    .form-control, .form-select {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
        border-radius: 15px;
        padding: 15px 20px;
        font-size: 1rem;
        transition: all 0.3s;
        height: auto;
    }
    
    .form-control:focus, .form-select:focus {
        background: rgba(255, 255, 255, 0.08);
        border-color: #6d28d9;
        color: white;
        box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.2);
    }
    
    .form-control::placeholder {
        color: #64748b;
    }
    
    .file-upload-area {
        border: 2px dashed rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        padding: 40px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        background: rgba(255, 255, 255, 0.02);
    }
    
    .file-upload-area:hover {
        border-color: #6d28d9;
        background: rgba(109, 40, 217, 0.05);
    }
    
    .file-upload-area.dragover {
        border-color: #8b5cf6;
        background: rgba(139, 92, 246, 0.1);
    }
    
    .file-upload-icon {
        font-size: 3.5rem;
        color: #8b5cf6;
        margin-bottom: 15px;
    }
    
    .file-upload-text h4 {
        color: white;
        margin-bottom: 10px;
        font-weight: 600;
    }
    
    .file-upload-text p {
        color: #94a3b8;
        font-size: 0.9rem;
        margin-bottom: 20px;
    }
    
    .file-info {
        background: rgba(255, 255, 255, 0.03);
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
    }
    
    .file-info-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        color: #cbd5e1;
        font-size: 0.9rem;
    }
    
    .file-info-item i {
        color: #8b5cf6;
        width: 20px;
    }
    
    .selected-file {
        background: rgba(109, 40, 217, 0.1);
        border: 1px solid rgba(109, 40, 217, 0.3);
        border-radius: 12px;
        padding: 15px;
        margin-top: 20px;
        display: none;
    }
    
    .selected-file.show {
        display: block;
        animation: fadeIn 0.3s ease;
    }
    
    .file-preview {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .file-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #6d28d9 0%, #8b5cf6 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }
    
    .file-details {
        flex: 1;
    }
    
    .file-name {
        color: white;
        font-weight: 600;
        margin-bottom: 5px;
        word-break: break-all;
    }
    
    .file-size {
        color: #94a3b8;
        font-size: 0.85rem;
    }
    
    .remove-file {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #ef4444;
        border-radius: 8px;
        padding: 8px 15px;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 0.9rem;
    }
    
    .remove-file:hover {
        background: rgba(239, 68, 68, 0.2);
    }
    
    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 40px;
    }
    
    .btn-submit {
        flex: 2;
        background: linear-gradient(135deg, #6d28d9 0%, #8b5cf6 100%);
        border: none;
        color: white;
        padding: 18px 30px;
        border-radius: 15px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(109, 40, 217, 0.3);
    }
    
    .btn-submit:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }
    
    .btn-back {
        flex: 1;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
        padding: 18px 30px;
        border-radius: 15px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s;
        text-align: center;
        text-decoration: none;
    }
    
    .btn-back:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(109, 40, 217, 0.3);
        color: white;
        text-decoration: none;
    }
    
    .error-message {
        color: #ef4444;
        font-size: 0.9rem;
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .success-message {
        color: #10b981;
        font-size: 0.9rem;
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    @media (max-width: 768px) {
        .form-container {
            padding: 20px;
        }
        
        .form-card {
            padding: 30px 20px;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .hero-title {
            font-size: 2.2rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <h1 class="hero-title fade-in">إضافة أغنية جديدة</h1>
        <p class="hero-subtitle fade-in">املأ تفاصيل الأغنية وارفع ملف الصوت لإثراء مكتبتك الموسيقية</p>
    </div>
</section>

<!-- Form Container -->
<div class="container form-container">
    <!-- Success/Error Messages -->
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

    <div class="form-card fade-in">
        <!-- Form Header -->
        <div class="form-header">
            <div class="form-header-icon">
                <i class="fas fa-plus-circle"></i>
            </div>
            <h2>إضافة أغنية جديدة</h2>
            <p>املأ المعلومات التالية لإضافة أغنية جديدة لمكتبتك</p>
        </div>

        <!-- Form -->
        <form action="{{ route('songs.store') }}" method="POST" enctype="multipart/form-data" id="songForm">
            @csrf
            
            <!-- Song Title -->
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-heading"></i>
                    <span>عنوان الأغنية</span>
                    <span class="required-star">*</span>
                </label>
                <input type="text" 
                       name="title" 
                       class="form-control" 
                       placeholder="أدخل عنوان الأغنية"
                       value="{{ old('title') }}"
                       required>
                @error('title')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <!-- Artist -->
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-user"></i>
                    <span>اسم الفنان</span>
                    <span class="required-star">*</span>
                </label>
                <input type="text" 
                       name="artist" 
                       class="form-control" 
                       placeholder="أدخل اسم الفنان"
                       value="{{ old('artist') }}"
                       required>
                @error('artist')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <!-- Album -->
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-compact-disc"></i>
                    <span>الألبوم (اختياري)</span>
                </label>
                <input type="text" 
                       name="album" 
                       class="form-control" 
                       placeholder="أدخل اسم الألبوم"
                       value="{{ old('album') }}">
                @error('album')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <!-- Audio File Upload -->
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-file-audio"></i>
                    <span>ملف الصوت</span>
                    <span class="required-star">*</span>
                </label>
                
                <!-- File Upload Area -->
                <div class="file-upload-area" id="fileUploadArea">
                    <div class="file-upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div class="file-upload-text">
                        <h4>انقر لاختيار ملف أو اسحب وأفلت هنا</h4>
                        <p>اسحب ملف الصوت إلى هذه المنطقة لرفعه</p>
                    </div>
                    <input type="file" 
                           name="song_file" 
                           id="songFile" 
                           accept="audio/*"
                           required
                           style="display: none;">
                    <button type="button" class="btn btn-outline-light" onclick="document.getElementById('songFile').click()">
                        <i class="fas fa-folder-open me-2"></i>تصفح الملفات
                    </button>
                </div>
                
                <!-- Selected File Preview -->
                <div class="selected-file" id="selectedFile">
                    <div class="file-preview">
                        <div class="file-icon">
                            <i class="fas fa-music"></i>
                        </div>
                        <div class="file-details">
                            <div class="file-name" id="fileName">...</div>
                            <div class="file-size" id="fileSize">...</div>
                        </div>
                        <button type="button" class="remove-file" onclick="removeFile()">
                            <i class="fas fa-times me-1"></i>إزالة
                        </button>
                    </div>
                </div>
                
                <!-- File Information -->
                <div class="file-info">
                    <div class="file-info-item">
                        <i class="fas fa-info-circle"></i>
                        <span>أنواع الملفات المدعومة: MP3, WAV, OGG, M4A</span>
                    </div>
                    <div class="file-info-item">
                        <i class="fas fa-database"></i>
                        <span>الحد الأقصى لحجم الملف: 50 ميجابايت</span>
                    </div>
                    <div class="file-info-item">
                        <i class="fas fa-clock"></i>
                        <span>مدة الرفع تعتمد على سرعة اتصالك بالإنترنت</span>
                    </div>
                </div>
                
                @error('song_file')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fas fa-save me-2"></i>
                    حفظ الأغنية
                </button>
                <a href="{{ route('songs.index') }}" class="btn-back">
                    <i class="fas fa-arrow-right me-2"></i>
                    العودة للقائمة
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
// DOM Elements
const fileUploadArea = document.getElementById('fileUploadArea');
const songFileInput = document.getElementById('songFile');
const selectedFileDiv = document.getElementById('selectedFile');
const fileNameSpan = document.getElementById('fileName');
const fileSizeSpan = document.getElementById('fileSize');
const submitBtn = document.getElementById('submitBtn');
const songForm = document.getElementById('songForm');

// File validation
function validateFile(file) {
    const maxSize = 50 * 1024 * 1024; // 50MB
    const allowedTypes = ['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/mp4', 'audio/x-m4a'];
    const allowedExtensions = /(\.mp3|\.wav|\.ogg|\.m4a)$/i;

    // Check file size
    if (file.size > maxSize) {
        showError('حجم الملف كبير جداً! الحد الأقصى 50 ميجابايت');
        return false;
    }

    // Check file type and extension
    if (!allowedTypes.includes(file.type) && !allowedExtensions.exec(file.name)) {
        showError('نوع الملف غير مدعوم! استخدم MP3, WAV, OGG, M4A فقط');
        return false;
    }

    return true;
}

// Show file preview
function showFilePreview(file) {
    if (!validateFile(file)) {
        songFileInput.value = '';
        return;
    }

    // Update file info
    fileNameSpan.textContent = file.name;
    fileSizeSpan.textContent = formatFileSize(file.size);
    
    // Show preview
    selectedFileDiv.classList.add('show');
    
    // Add pulse animation
    fileUploadArea.style.animation = 'pulse 0.5s ease';
    setTimeout(() => {
        fileUploadArea.style.animation = '';
    }, 500);
    
    // Show success message
    showSuccess('تم اختيار الملف بنجاح!');
}

// Remove file
function removeFile() {
    songFileInput.value = '';
    selectedFileDiv.classList.remove('show');
    fileUploadArea.classList.remove('dragover');
    showSuccess('تمت إزالة الملف');
}

// Format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Show error message
function showError(message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${message}`;
    errorDiv.style.animation = 'fadeIn 0.3s ease';
    
    // Remove existing error
    const existingError = document.querySelector('.error-message:not([data-permanent])');
    if (existingError) {
        existingError.remove();
    }
    
    // Insert after file upload area
    fileUploadArea.parentNode.insertBefore(errorDiv, fileUploadArea.nextSibling);
    
    // Remove after 5 seconds
    setTimeout(() => {
        if (errorDiv.parentNode) {
            errorDiv.style.animation = 'fadeOut 0.3s ease';
            setTimeout(() => errorDiv.remove(), 300);
        }
    }, 5000);
}

// Show success message
function showSuccess(message) {
    const successDiv = document.createElement('div');
    successDiv.className = 'success-message';
    successDiv.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
    successDiv.style.animation = 'fadeIn 0.3s ease';
    
    // Remove existing success
    const existingSuccess = document.querySelector('.success-message');
    if (existingSuccess) {
        existingSuccess.remove();
    }
    
    // Insert after file upload area
    fileUploadArea.parentNode.insertBefore(successDiv, fileUploadArea.nextSibling);
    
    // Remove after 3 seconds
    setTimeout(() => {
        if (successDiv.parentNode) {
            successDiv.style.animation = 'fadeOut 0.3s ease';
            setTimeout(() => successDiv.remove(), 300);
        }
    }, 3000);
}

// Form submission
songForm.addEventListener('submit', function(e) {
    // Validate file is selected
    if (!songFileInput.files.length) {
        e.preventDefault();
        showError('يرجى اختيار ملف صوتي');
        return false;
    }

    // Validate file
    const file = songFileInput.files[0];
    if (!validateFile(file)) {
        e.preventDefault();
        return false;
    }

    // Show loading
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> جاري الرفع...';
    submitBtn.disabled = true;
    
    // Add fadeOut animation to form
    this.style.animation = 'fadeOut 0.5s ease';
});

// File input change event
songFileInput.addEventListener('change', function(e) {
    if (this.files.length > 0) {
        showFilePreview(this.files[0]);
    }
});

// Drag and drop functionality
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    fileUploadArea.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    fileUploadArea.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    fileUploadArea.addEventListener(eventName, unhighlight, false);
});

function highlight() {
    fileUploadArea.classList.add('dragover');
}

function unhighlight() {
    fileUploadArea.classList.remove('dragover');
}

fileUploadArea.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    
    if (files.length > 0) {
        songFileInput.files = files;
        showFilePreview(files[0]);
    }
}

// Click on upload area to trigger file input
fileUploadArea.addEventListener('click', function(e) {
    if (e.target === this || e.target.classList.contains('file-upload-text') || 
        e.target.classList.contains('file-upload-icon')) {
        songFileInput.click();
    }
});

// Add fadeOut animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(20px); }
    }
`;
document.head.appendChild(style);

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    console.log('🎵 Add song page loaded');
    
    // If there was an old file value (from validation error), show it
    if (songFileInput.files.length > 0) {
        showFilePreview(songFileInput.files[0]);
    }
});
</script>
@endsection