<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('memories', function (Blueprint $table) {
            $table->string('image_url')->default('')->nullable(false)->change(); // Thêm giá trị mặc định
        });
    }

    public function down(): void
    {
        Schema::table('memories', function (Blueprint $table) {
            $table->string('image_url')->nullable(false)->change(); // Loại bỏ giá trị mặc định
        });
    }
};
