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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();

            // ⭐️ここから追加↓
            $table->string('event_name');
            $table->text('details')->nullable();
            $table->dateTime('start_date')->notNullable(); // start_date を NOT NULL
            $table->dateTime('end_date')->notNullable(); // end_date も NOT NULL
            $table->unsignedBigInteger('user_id');
            // ⭐️ここまで追加↑

            $table->timestamps();

            // ⭐️これも追加。外部キー制約。user_idには、usersテーブルに登録してあるidだけ入れられるようにする。
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
