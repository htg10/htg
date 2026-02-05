<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('telecallers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('mobile');
            $table->unsignedBigInteger('user_id');
            $table->dateTime('meeting_datetime');
            $table->string('interest');
            $table->string('status')->default('NEW');
            $table->string('deal_status')->default('pending');
            $table->date('follow_up_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telecallers');
    }
};
