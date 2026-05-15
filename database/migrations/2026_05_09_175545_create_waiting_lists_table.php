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
        // ДОБАВЬ ВОТ ЭТУ СТРОЧКУ (Она снесет старую таблицу на боевом сервере перед созданием новой)
        Schema::dropIfExists('waiting_lists');

        Schema::create('waiting_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->date('desired_date');
            $table->string('status')->default('pending'); // pending (ждет), notified (уведомлен)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waiting_lists');
    }
};
