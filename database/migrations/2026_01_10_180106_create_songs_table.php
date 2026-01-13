<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();  // رقم تعريف تلقائي
            $table->string('title');  // عنوان الأغنية
            $table->string('artist');  // اسم الفنان
            $table->string('album')->nullable();  // الألبوم (اختياري)
            $table->string('file_path');  // مسار ملف الصوت
            $table->string('cover_image')->nullable();  // صورة الألبوم
            $table->integer('duration')->nullable();  // المدة بالثواني
            $table->timestamps();  // تاريخ الإنشاء والتعديل
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
